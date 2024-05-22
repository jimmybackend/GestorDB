<?php
// Conexión a la base de datos
include 'db.php';

// Verificar si se enviaron datos por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el correo electrónico del usuario a actualizar
    $correo_buscar = $_POST['correo_buscar'];

    // Construir la consulta SQL para describir la tabla de usuarios
    $query_descripcion = "DESCRIBE usuarios";
    $resultado_descripcion = $db_connection->query($query_descripcion);

    // Verificar si la consulta fue exitosa
    if ($resultado_descripcion) {
        // Inicializar un array para almacenar los pares campo-valor a actualizar
        $campos_actualizar = array();

        // Recorrer los resultados para obtener los nombres de los campos
        while ($fila = $resultado_descripcion->fetch_assoc()) {
            $nombre_campo = $fila['Field'];

            // Verificar si el campo se envió por el formulario de actualización
            if (isset($_POST[$nombre_campo])) {
                // Agregar el par campo-valor al array de campos a actualizar
                $valor_campo = $_POST[$nombre_campo];
                // Escapar caracteres especiales para evitar inyección SQL
                $valor_campo = $db_connection->real_escape_string($valor_campo);
                $campos_actualizar[] = "$nombre_campo = '$valor_campo'";
            }
        }

        // Verificar si se recibieron campos para actualizar
        if (!empty($campos_actualizar)) {
            // Construir la consulta SQL para actualizar los datos del usuario
            $campos_actualizar_str = implode(", ", $campos_actualizar);
            $query_actualizar = "UPDATE usuarios SET $campos_actualizar_str WHERE correo = '$correo_buscar'";

            // Ejecutar la consulta de actualización
            if ($db_connection->query($query_actualizar) === TRUE) {
                echo "Los datos del usuario con correo electrónico '$correo_buscar' se actualizaron correctamente.";
            } else {
                echo "Error al actualizar los datos del usuario: " . $db_connection->error;
            }
        } else {
            echo "No se recibieron campos para actualizar.";
        }
    } else {
        echo "Error al describir la tabla de usuarios.";
    }
}

// Cerrar conexión a la base de datos
$db_connection->close();
?>
