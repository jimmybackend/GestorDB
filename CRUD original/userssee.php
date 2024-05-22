<?php
// Conexión a la base de datos
include 'db.php';

// Nombre de la tabla a analizar (usuarios en este caso)
$nombre_tabla = 'Users';

// Consulta SQL para obtener la descripción de la tabla
$query_descripcion = "DESCRIBE $nombre_tabla";
$resultado_descripcion = $db_connection->query($query_descripcion);

// Verificar si la consulta fue exitosa
if ($resultado_descripcion) {
    // Crear un array para almacenar los nombres de los campos
    $campos = array();

    // Recorrer los resultados para obtener los nombres de los campos
    while ($fila = $resultado_descripcion->fetch_assoc()) {
        // Agregar el nombre del campo al array
        $campos[] = $fila['Field'];
    }

    // Construir la consulta SQL para seleccionar todos los usuarios
    $query_usuarios = "SELECT * FROM $nombre_tabla";
    $resultado_usuarios = $db_connection->query($query_usuarios);

    // Verificar si se encontraron usuarios
    if ($resultado_usuarios->num_rows > 0) {
        echo "<h2>Lista de Usuarios</h2>";
        echo "<table border='1'><tr>";

        // Mostrar los encabezados de las columnas basados en los nombres de los campos
        foreach ($campos as $campo) {
            echo "<th>$campo</th>";
        }

        echo "</tr>";

        // Mostrar los datos de cada usuario en una fila de la tabla
        while ($fila = $resultado_usuarios->fetch_assoc()) {
            echo "<tr>";

            // Mostrar los valores de cada campo
            foreach ($campos as $campo) {
                echo "<td>" . $fila[$campo] . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron usuarios.";
    }
} else {
    echo "Error al obtener la descripción de la tabla.";
}

// Cerrar conexión a la base de datos
$db_connection->close();
?>
