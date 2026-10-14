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
require_once __DIR__.'/GestorFieldCodec.php';
require_once __DIR__.'/OwnershipPolicy.php';
$identity=GestorAccess::requireIdentity();
$isUser=($identity['mode']??'')==='user';
if(!$isUser&&($identity['mode']??'')!=='admin'){http_response_code(403);exit('Acceso no autorizado');}
$schema=(new SchemaHierarchy($db_connection))->inspect();
$table=$_POST['table']??null;
$action=$_POST['action']??null;
$fields=$_POST['field']??[];
if (!is_string($table)||!isset($schema[$table])||!is_string($action)||!in_array($action,['add','edit','delete'],true)||!is_array($fields)) {http_response_code(400);exit('Invalid operation');}
$meta=$schema[$table];
$owner=null;
if($isUser){
    if($table===(string)$identity['table']){http_response_code(403);exit('Tabla protegida');}
    $owner=OwnershipPolicy::column($meta,(string)$identity['table']);
    if($owner===null){http_response_code(403);exit('Propiedad no verificable');}
}
$quote=static fn(string $s)=>'`'.str_replace('`','``',$s).'`';
$allowed=array_keys($meta['columns']);
$values=[];
$expressions=[];
foreach ($fields as $key=>$value) {
    if (!is_string($key)||!in_array($key,$allowed,true)||!(is_string($value)||is_array($value))) {http_response_code(400);exit('Invalid field');}
    if (str_contains(strtolower($meta['columns'][$key]['EXTRA']),'auto_increment'))continue;
    // Omit empty fields rather than overwriting existing values or defaults.
    if ($value!=='' && $value!==[]) {
        $decoded=GestorFieldCodec::decode($meta['columns'][$key],$value);
        $values[$key]=$decoded['value'];
        $expressions[$key]=$decoded['sql'];
    }
}
$pk=$meta['pk'];
$keys=$_POST['pk']??[];
if($action!=='add'){
 if(!$pk||!is_array($keys)||count($keys)!==count($pk)){http_response_code(400);exit('Invalid primary key');}
 foreach($pk as $key){
  if(!isset($keys[$key])||!is_string($keys[$key])||$keys[$key]===''){http_response_code(400);exit('Incomplete primary key');}
 }
}
$where=implode(' AND ',array_map(static fn($key)=>$quote($key).'=?',$pk));
$keyParameters=$action==='add'?[]:array_map(static fn($key)=>$keys[$key],$pk);
try {
    if ($action==='add') {
        if (!$values) throw new RuntimeException('No values supplied');
        $names=array_keys($values);
        $sql='INSERT INTO '.$quote($table).' ('.implode(',',array_map($quote,$names)).') VALUES ('.implode(',',array_map(static fn($name)=>$expressions[$name],$names)).')';
        $parameters=array_values($values);
    } elseif ($action==='edit') {
        if (!$values) throw new RuntimeException('No values supplied');
        foreach($pk as $key){ unset($values[$key],$expressions[$key]); }
        if (!$values) throw new RuntimeException('No editable fields supplied');
        $names=array_keys($values);
        $sql='UPDATE '.$quote($table).' SET '.implode(',',array_map(static fn($col)=>$quote($col).'='.$expressions[$col],$names)).' WHERE '.$where;
        $parameters=[...array_values($values),...$keyParameters];
    } else {
        $sql='DELETE FROM '.$quote($table).' WHERE '.$where;
        $parameters=$keyParameters;
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
