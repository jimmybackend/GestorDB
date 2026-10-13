<?php
declare(strict_types=1);
session_start();
header('Cache-Control: no-store');
require_once __DIR__.'/GestorAccess.php';
$mode=GestorAccess::mode();
if(($_GET['logout']??'')==='1') { $_SESSION=[];session_regenerate_id(true);header('Location: index.php',true,303);exit; }
if(GestorAccess::identity()){header('Location: dashboard.php',true,303);exit;}
if(!isset($_SESSION['gestordb_login_csrf'])) $_SESSION['gestordb_login_csrf']=bin2hex(random_bytes(24));
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $token=$_POST['csrf']??null;
 if(!is_string($token)||!hash_equals($_SESSION['gestordb_login_csrf'],$token)){$error='Sesión inválida';}
 else {
  require_once __DIR__.'/db.php';
  $email=trim((string)($_POST['email']??''));
  $password=(string)($_POST['password']??'');
  if(GestorAccess::login($db_connection,$email,$password)){header('Location: dashboard.php',true,303);exit;}
  $error='Credenciales inválidas o contraseña no compatible';
 }
}
$e=static fn($v)=>htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');
?><!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>GestorDB · Acceso</title><link rel="stylesheet" href="assets/gestordb.css"></head>
<body><main class="login-shell"><article class="panel"><h1>GestorDB</h1><p>Administrador dinámico de bases de datos MySQL. Descubre tablas, relaciones y formularios a partir del esquema real.</p>
<?php if($mode==='admin'):?><p class="warning">Acceso administrativo directo disponible solamente desde una dirección IP permitida por el servidor.</p>
<?php else: ?>
<h2>Acceso de usuario</h2><?php if($error):?><p class="warning"><?=$e($error)?></p><?php endif;?>
<form method="post" class="edit-form" autocomplete="on">
<input type="hidden" name="csrf" value="<?=$e($_SESSION['gestordb_login_csrf'])?>">
<label>Correo electrónico<input type="email" name="email" required autocomplete="username"></label>
<label>Contraseña<input type="password" name="password" required autocomplete="current-password"></label>
<button type="submit">Entrar</button></form>
<p>Por seguridad, el registro público está desactivado. El administrador puede crear cuentas con un proceso autorizado.</p>
<?php if($mode==='mixed'):?><p>El acceso administrativo directo sólo funciona desde una IP autorizada.</p><?php endif;?>
<?php endif;?></article></main></body></html>