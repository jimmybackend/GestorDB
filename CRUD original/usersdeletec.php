<?php
// Conexión a la base de datos
include 'db.php';

// Verificar si se recibió la confirmación para eliminar el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar_eliminar'])) {
    // Obtener el correo electrónico del usuario a eliminar
    $correo_eliminar = $_POST['correo_eliminar'];

    // Construir la consulta SQL para eliminar el usuario
    $query_eliminar = "DELETE FROM Users WHERE email = '$correo_eliminar'";

    // Ejecutar la consulta de eliminación
    if ($db_connection->query($query_eliminar) === TRUE) {
        echo "El usuario con correo electrónico '$correo_eliminar' se ha eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $db_connection->error;
    }
} else {
    // Redireccionar al usuario de vuelta al formulario de búsqueda si intenta acceder directamente a este script sin confirmar la eliminación
    header("Location: buscar_usuario.php");
    exit();
}

// Cerrar conexión a la base de datos
$db_connection->close();
?>
