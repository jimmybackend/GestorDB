<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
if ($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Método no permitido');}
require_once __DIR__.'/GestorAccess.php';
$identity=GestorAccess::requireIdentity();
if(($identity['mode']??'')!=='admin'){http_response_code(403);exit('Sólo administrador');}
$csrf=$_POST['csrf']??null;
if(!is_string($csrf)||!isset($_SESSION['gestordb_csrf'])||!hash_equals($_SESSION['gestordb_csrf'],$csrf)){http_response_code(403);exit('Sesión no válida');}
require_once __DIR__.'/db.php';
require_once __DIR__.'/SchemaEditor.php';
$op=$_POST['op']??'';
if(!is_string($op)||!in_array($op,['create','add','move'],true)){http_response_code(400);exit('Operación inválida');}
$table=$_POST['table']??'';
$column=$_POST['column']??'';
$type=$_POST['type']??'VARCHAR';
$length=filter_var($_POST['length']??255,FILTER_VALIDATE_INT);
$after=$_POST['after']??'';
if(!is_string($table)||!is_string($column)||!is_string($type)||!is_string($after)||$length===false){http_response_code(400);exit('Parámetros inválidos');}
try {
 $editor=new SchemaEditor($db_connection);
 if($op==='create')$editor->create($table,$column,$type,$length);
 elseif($op==='add')$editor->addColumn($table,$column,$type,$length,$after);
 else $editor->moveColumn($table,$column,$after);
 header('Location: dashboard.php?table='.rawurlencode($table).'&schema_updated=1',true,303);
 exit;
}catch(Throwable $error){
 error_log('GestorDB schema editor: '.$error->getMessage());
 http_response_code(422);
 exit('No fue posible modificar el esquema. Revisa las restricciones de la tabla y el registro del servidor.');
}
