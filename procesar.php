<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {http_response_code(405);exit('Method not allowed');}
$csrf=$_POST['csrf']??null;
if (!is_string($csrf)||!isset($_SESSION['gestordb_csrf'])||!hash_equals($_SESSION['gestordb_csrf'],$csrf)) {http_response_code(403);exit('Invalid session');}
require_once __DIR__.'/db.php';
require_once __DIR__.'/SchemaHierarchy.php';
require_once __DIR__.'/GestorAccess.php';
$identity=GestorAccess::requireIdentity();
if(($identity['mode']??'')!=='admin'){http_response_code(403);exit('CRUD de usuarios no autorizado');}
$schema=(new SchemaHierarchy($db_connection))->inspect();
$table=$_POST['table']??null;
$action=$_POST['action']??null;
$fields=$_POST['field']??[];
if (!is_string($table)||!isset($schema[$table])||!is_string($action)||!in_array($action,['add','edit','delete'],true)||!is_array($fields)) {http_response_code(400);exit('Invalid operation');}
$meta=$schema[$table];
$quote=static fn(string $s)=>'`'.str_replace('`','``',$s).'`';
$allowed=array_keys($meta['columns']);
$values=[];
foreach ($fields as $key=>$value) {
    if (!is_string($key)||!in_array($key,$allowed,true)||!is_string($value)) {http_response_code(400);exit('Invalid field');}
    if (str_contains(strtolower($meta['columns'][$key]['EXTRA']),'auto_increment'))continue;
    // Omit empty fields rather than overwriting existing values or defaults.
    if ($value!=='') $values[$key]=$value;
}
$pk=$meta['pk'];
if ($action!=='add' && count($pk)!==1) {http_response_code(400);exit('A simple primary key is required');}
if ($action!=='add' && (!isset($_POST['pk_value'])||!is_string($_POST['pk_value'])||$_POST['pk_value']==='')) {http_response_code(400);exit('Missing primary key value');}
try {
    if ($action==='add') {
        if (!$values) throw new RuntimeException('No values supplied');
        $names=array_keys($values);
        $sql='INSERT INTO '.$quote($table).' ('.implode(',',array_map($quote,$names)).') VALUES ('.implode(',',array_fill(0,count($names),'?')).')';
        $parameters=array_values($values);
    } elseif ($action==='edit') {
        if (!$values) throw new RuntimeException('No values supplied');
        unset($values[$pk[0]]);
        if (!$values) throw new RuntimeException('No editable fields supplied');
        $names=array_keys($values);
        $sql='UPDATE '.$quote($table).' SET '.implode(',',array_map(static fn($col)=>$quote($col).'=?',$names)).' WHERE '.$quote($pk[0]).'=?';
        $parameters=[...array_values($values),$_POST['pk_value']];
    } else {
        $sql='DELETE FROM '.$quote($table).' WHERE '.$quote($pk[0]).'=?';
        $parameters=[$_POST['pk_value']];
    }
    $stmt=$db_connection->prepare($sql);
    $types=str_repeat('s',count($parameters));
    $stmt->bind_param($types,...$parameters);
    $stmt->execute();
    $stmt->close();
    header('Location: dashboard.php?table='.rawurlencode($table).'&action=see',true,303);
    exit;
} catch (Throwable $ex) {
    error_log('GestorDB CRUD failed: '.$ex->getMessage());
    http_response_code(422);
    exit('The operation could not be completed. Check constraints and server logs.');
}
