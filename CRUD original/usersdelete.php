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
        // Mostrar los datos del usuario encontrado
        echo "<h2>Resultado de la Búsqueda</h2>";
        echo "<table border='1'><tr>";

        // Obtener los nombres de los campos de la tabla
        $fila_descripcion = $resultado_buscar->fetch_fields();
        foreach ($fila_descripcion as $campo) {
            echo "<th>" . $campo->name . "</th>";
        }

        echo "</tr>";

        // Mostrar los datos del usuario en una fila de la tabla
        while ($fila = $resultado_buscar->fetch_assoc()) {
            echo "<tr>";

            // Mostrar los valores de cada campo
            foreach ($fila as $valor) {
                echo "<td>" . $valor . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";

        // Mostrar el formulario de confirmación para eliminar el usuario
        echo "<h2>Confirmar Eliminación</h2>";
        echo "<p>¿Estás seguro de que deseas eliminar este usuario?</p>";
        echo "<form method='post' action='eliminar_usuario.php'>";
        echo "<input type='hidden' name='correo_eliminar' value='$correo_buscar'>";
        echo "<input type='submit' name='confirmar_eliminar' value='Confirmar Eliminación'>";
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
