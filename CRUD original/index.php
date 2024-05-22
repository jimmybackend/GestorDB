<?php
include 'GestorDB.php';
// Uso de la clase GestorBD
$gestorBD = new GestorDB();
// Obtener el nombre de la página actual
$pagina_actual = basename($_SERVER['PHP_SELF'], '.php');

// Definir la tabla que se desea visualizar según el nombre de la página
switch ($pagina_actual) {
    case 'usuarios':
        $tabla = 'Users';
        break;
    // Agregar más casos según sea necesario para otras páginas
    default:
        $tabla = ''; // Establecer un valor predeterminado o mostrar un mensaje de error
        break;
}

// Verificar si se ha definido una tabla válida
if (!empty($tabla)) {
    // Verificar si se recibieron datos por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener el comando y la tabla de la solicitud POST
        $comando = $_POST['comando'];
        $tabla_post = $_POST['tabla'];

        // Verificar si se recibieron el comando y la tabla
        if (!empty($comando) && !empty($tabla_post)) {
            // Dependiendo del comando recibido, realizar la acción correspondiente
            switch ($comando) {
                case 'insert':
                    // Verificar si el comando es para insertar en la tabla definida anteriormente
                    if ($tabla_post == $tabla) {
                        // Insertar datos en la tabla
                        $gestorDB->insertarDatos($tabla, $_POST);
                    } else {
                        echo "La tabla especificada en el formulario no coincide con la tabla definida para esta página.";
                    }
                    break;
                // Agregar más casos según sea necesario para otros comandos
                default:
                    echo "Comando no válido.";
                    break;
            }
        } else {
            echo "Comando o tabla no especificados.";
        }
    } else {
       
     
        $gestorDB->generarFormulario($tabla);
       
       
       
    }
} else {
    //echo "No se ha definido una tabla válida para esta página.";
      $tabla = 'Users';
      $campo='email';
      $correo_buscar='soporte@esforzados.com';
      $placeholder=$campo;

     //$gestorBD->generarVistaTabla($tabla);
    // $gestorBD->generarFormularioBusqueda($tabla, $campo, $placeholder);
    //$gestorBD->insertarDatos($tabla, $datos);
    // $gestorBD->generarFormularioActualizacion($correo_buscar, $tabla);
      //$datos_actualizados = $_POST;
    //    $gestorBD->actualizarDatos($datos_actualizados, $tabla);
    //$gestorBD->eliminarRegistro($tabla, $campo, $dato) 
   //$gestorBD->buscarPorCorreo($correo_buscar, $tabla);
   //$gestorBD->mostrarFormularioAgregarCampos($tabla);
   //$gestorBD->mostrarFormularioCrearTabla(); 
}

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
        echo "<table border='1'><tr>";

        // Obtener los nombres de los campos de la tabla
        $fila_descripcion = $resultado_buscar->fetch_fields();
        foreach ($fila_descripcion as $campo) {
            echo "<th>" . $campo->name . "</th>";
        }

        echo "</tr>";

        // Mostrar los datos del usuario encontrado en una fila de la tabla
        while ($fila = $resultado_buscar->fetch_assoc()) {
            echo "<tr>";

            // Mostrar los valores de cada campo
            foreach ($fila as $valor) {
                echo "<td>" . $valor . "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
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


