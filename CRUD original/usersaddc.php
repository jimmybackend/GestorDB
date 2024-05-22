<?php
// Conexión a la base de datos
include '../db.php';

// Nombre de la tabla a analizar (puedes cambiarlo según la tabla que desees)
$nombre_tabla = 'usuarios';

// Obtener la descripción de la tabla
$query = "DESCRIBE $nombre_tabla";
$resultado = $db_connection->query($query);

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inicializar un array para almacenar los valores de los campos
    $valores = array();

    // Recorrer los campos de la tabla
    while ($fila = $resultado->fetch_assoc()) {
        $nombre_campo = $fila['Field'];

        // Verificar si el campo existe en los datos POST
        if (isset($_POST[$nombre_campo])) {
            // Agregar el valor del campo al array de valores
            $valores[$nombre_campo] = $_POST[$nombre_campo];
        }
    }

    // Verificar si se recibieron todos los campos necesarios
    if (count($valores) == $resultado->num_rows) {
        // Construir la consulta SQL para insertar los datos
        $campos = implode(", ", array_keys($valores));
        $valores = "'" . implode("', '", array_values($valores)) . "'";
        $query_insert = "INSERT INTO $nombre_tabla ($campos) VALUES ($valores)";

        // Ejecutar la consulta
        if ($db_connection->query($query_insert) === TRUE) {
            echo "Datos insertados correctamente.";
        } else {
            echo "Error al insertar datos: " . $db_connection->error;
        }
    } else {
        echo "No se recibieron todos los campos necesarios.";
    }
}

// Crear el formulario dinámicamente
echo "<form action='' method='post'>";
echo "<h2>Formulario para Insertar Datos en la tabla $nombre_tabla</h2>";

// Volver al inicio del resultado para recorrerlo nuevamente
$resultado->data_seek(0);
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
