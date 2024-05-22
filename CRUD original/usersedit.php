<?php
// Conexión a la base de datos
include 'db.php';

// Verificar si se envió un correo electrónico para buscar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo electrónico enviado por el formulario
    $correo_buscar = $_POST['correo_buscar'];

    // Construir la consulta SQL para buscar el correo electrónico en la tabla de usuarios
    $query_buscar = "SELECT * FROM Users WHERE email = '$correo_buscar'";
    $resultado_buscar = $db_connection->query($query_buscar);

    // Verificar si se encontraron resultados
    if ($resultado_buscar->num_rows > 0) {
        echo "<h2>Resultado de la Búsqueda</h2>";

        // Mostrar el formulario para actualizar los datos del usuario encontrado
        echo "<form method='post' action='actualizar_usuario.php'>";
        echo "<input type='hidden' name='correo_buscar' value='$correo_buscar'>"; // Enviamos el correo para identificar al usuario

        while ($fila = $resultado_buscar->fetch_assoc()) {
            // Mostrar los campos de usuario como input para actualizar
            foreach ($fila as $campo => $valor) {
                // Evitamos que se pueda modificar el correo electrónico
                if ($campo == 'correo') {
                    echo "<input type='hidden' name='$campo' value='$valor'>";
                } else {
                    echo "<label for='$campo'>$campo:</label>";
                    echo "<input type='text' id='$campo' name='$campo' value='$valor'><br>";
                }
            }
        }

        echo "<input type='submit' value='Actualizar'>";
        echo "</form>";
    } else {
        echo "No se encontraron resultados para el correo electrónico '$correo_buscar'.";
    }
}
?>

<h2>Buscar Usuario por Correo Electrónico</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="correo_buscar">Correo Electrónico:</label>
    <input type="text" id="correo_buscar" name="correo_buscar">
    <input type="submit" value="Buscar">
</form>

<?php
// Cerrar conexión a la base de datos
$db_connection->close();
?>
