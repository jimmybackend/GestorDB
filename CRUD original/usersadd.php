<?php
// Conexión a la base de datos
include 'db.php';

// Nombre de la tabla a analizar (puedes cambiarlo según la tabla que desees)
$nombre_tabla = 'Users';

// Obtener la descripción de la tabla
$query = "DESCRIBE $nombre_tabla";
$resultado = $db_connection->query($query);

// Crear el formulario dinámicamente
echo "<form action='insertar_datos.php' method='post'>";
echo "<h2>Registro de Usuario</h2>";

while ($fila = $resultado->fetch_assoc()) {
    $nombre_campo = $fila['Field'];
    $tipo_dato = $fila['Type'];
    $tipo_dato = explode("(", $tipo_dato)[0]; // Eliminar la longitud del tipo de dato, ej: VARCHAR(100) -> VARCHAR
    $tipo_dato = strtoupper($tipo_dato); // Convertir el tipo de dato a mayúsculas

    // Si el campo es auto_increment o una columna no editable, saltarlo
    if ($fila['Extra'] == 'auto_increment' || $fila['Key'] == 'PRI') {
        continue;
    }

    echo "<label for='$nombre_campo'>$nombre_campo:</label><br>";

    // Generar el campo de entrada dependiendo del tipo de dato
    switch ($tipo_dato) {
        case 'VARCHAR':
            echo "<input type='text' id='$nombre_campo' name='$nombre_campo'><br>";
            break;
        case 'INT':
            echo "<input type='number' id='$nombre_campo' name='$nombre_campo'><br>";
            break;
        case 'DATE':
            echo "<input type='date' id='$nombre_campo' name='$nombre_campo'><br>";
            break;
        // Agregar más casos según sea necesario para otros tipos de datos
        default:
            echo "<input type='text' id='$nombre_campo' name='$nombre_campo'><br>";
            break;
    }
}

echo "<br><input type='submit' value='Insertar Datos'>";
echo "</form>";

// Cerrar conexión a la base de datos
$db_connection->close();
?>
