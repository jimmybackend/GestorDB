<?php
$servidor  = "localhost";
$usuario   = "xxxxxxxxx";
$clave     = "xxxxxxxxxx";
$basedatos = "xxxxxxxxx";

$db_connection = mysqli_connect($servidor, $usuario, $clave, $basedatos) or die(mysqli_error($db_connection));

if (!$db_connection) {
    die('No se ha podido conectar a la base de datos: ' . mysqli_connect_error());
}
?>