<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
if($_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Method not allowed');}
require_once __DIR__.'/GestorAccess.php';
$id=GestorAccess::requireIdentity();
if(($id['mode']??'')!=='admin'){http_response_code(403);exit('Administrator required');}
$csrf=$_POST['csrf']??null;
if(!is_string($csrf)||!isset($_SESSION['gestordb_csrf'])||!hash_equals($_SESSION['gestordb_csrf'],$csrf)){http_response_code(403);exit('Invalid session');}
if(($_POST['confirm']??null)!=='yes'){http_response_code(400);exit('Confirmation required');}
$op=$_POST['op']??null;
if(!is_string($op)||!in_array($op,['primary','index','foreign'],true)){http_response_code(400);exit('Invalid operation');}
foreach(['table','column','index_name','parent','parent_column','constraint'] as $key){
 if(!isset($_POST[$key]))$_POST[$key]='';
 if(!is_string($_POST[$key])){http_response_code(400);exit('Invalid input');}
}
require_once __DIR__.'/db.php';
require_once __DIR__.'/SchemaKeys.php';
try{
 $keys=new SchemaKeys($db_connection);
 if($op==='primary')$keys->addPrimary($_POST['table'],$_POST['column']);
 elseif($op==='index')$keys->addIndex($_POST['table'],$_POST['column'],$_POST['index_name']);
 else $keys->addForeignKey($_POST['table'],$_POST['column'],$_POST['parent'],$_POST['parent_column'],$_POST['constraint']);
 header('Location: dashboard.php?table='.rawurlencode($_POST['table']).'&schema_updated=1',true,303);
 exit;
}catch(Throwable $ex){
 error_log('GestorDB key DDL failed: '.$ex->getMessage());
 http_response_code(422);
 exit('MySQL could not apply the requested key. Verify types, existing data and server logs.');
}
