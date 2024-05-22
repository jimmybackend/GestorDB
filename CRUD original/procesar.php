<?php
// Incluye el archivo con la clase del gestor de base de datos
include 'gestor_bd.php'; // Asegúrate de reemplazar 'gestor_bd.php' con el nombre correcto de tu archivo

// Verifica si se han recibido los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determina la acción a realizar según el formulario enviado
    switch ($_POST['form_type']) {
        case 'crear_tabla':
            CrearTabla();
            break;
        case 'agregar_campos_tabla':
            AgregarCampos_tabla();
            break;    
        case 'agregar_datos':
            AgregarDatos();
            break;    
        case 'actualizar_campos':
            ActualizarDatos();
            break;
        case 'buscar':
            buscarDatos();
            break;    
        default:
            echo "Error: Formulario no reconocido.";
    }
} else {
    echo "Error: La página no se ha accedido mediante el método POST.";
}

    // Función para procesar el formulario de creación de una nueva tabla
    function CrearTabla() {
        // Recoge los datos del formulario
        $nombreTabla = $_POST['nombre_tabla'];
        $campos = array();
    
        // Construye el arreglo de campos
        $numCampos = count($_POST['nombre_campo']);
        for ($i = 0; $i < $numCampos; $i++) {
            $campos[] = array(
                'nombre' => $_POST['nombre_campo'][$i],
                'tipo_dato' => $_POST['tipo_dato'][$i],
                'longitud' => $_POST['longitud'][$i],
                'predeterminado' => $_POST['predeterminado'][$i],
                'cotejamiento' => $_POST['cotejamiento'][$i],
                'atributos' => $_POST['atributos'][$i],
                'nulo' => $_POST['nulo'][$i],
                'ajustar_privilegios' => $_POST['ajustar_privilegios'][$i],
                'documentacion' => $_POST['documentacion'][$i],
                'autoincrementable' => $_POST['autoincrementable'][$i],
                'comentarios' => $_POST['comentarios'][$i],
                'virtualidad' => $_POST['virtualidad'][$i],
                'mover_columna' => $_POST['mover_columna'][$i],
            );
        }
    
        // Crea una instancia del gestor de base de datos
        $gestorBD = new GestorBD(); // Asegúrate de usar el nombre correcto de tu clase
    
        // Prepara los datos para la creación de la tabla
        $datosTabla = array(
            'nombre_tabla' => $nombreTabla,
            'campos' => $campos
        );
    
        // Llama a la función para crear la tabla en la base de datos
        $resultado = $gestorBD->CrearTabla($datosTabla);
    
        // Verifica si la operación fue exitosa
        if ($resultado) {
            echo "La tabla $nombreTabla se ha creado correctamente.";
        } else {
            echo "Error al crear la tabla $nombreTabla.";
        }
    }

    // Función para procesar el formulario de agregar campo de una tabla
    function AgregarCampos_tabla(){
        // Recoge el nombre de la tabla
        $tabla = $_POST['tabla'];
        
        // Crea una instancia del gestor de base de datos
        $gestorBD = new GestorBD(); // Asegúrate de usar el nombre correcto de tu clase
        
        // Construye el arreglo de campos
        $campos = array(
            'nombre_campo' => $_POST['nombre_campo'],
            'tipo_dato' => $_POST['tipo_dato'],
            'longitud' => $_POST['longitud'],
            'predeterminado' => $_POST['predeterminado'],
            'cotejamiento' => $_POST['cotejamiento'],
            'atributos' => $_POST['atributos'],
            'nulo' => $_POST['nulo'],
            'ajustar_privilegios' => $_POST['ajustar_privilegios'],
            'documentacion' => $_POST['documentacion'],
            'autoincrementable' => $_POST['autoincrementable'],
            'comentarios' => $_POST['comentarios'],
            'virtualidad' => $_POST['virtualidad'],
            'mover_columna' => $_POST['mover_columna']
        );
        
        // Llama a la función agregarCampos() para agregar los campos a la tabla
        $resultado = $gestorBD->agregarCampos($tabla, $campos);
        
        // Muestra el resultado de la inserción
        echo $resultado;
    }

    // Función para procesar el formulario de agregar campos a una tabla
    function AgregarDatos() {
        // Recoge el nombre de la tabla
        $tabla = $_POST['tabla'];
    
        // Crea una instancia del gestor de base de datos
        $gestorBD = new GestorBD(); // Asegúrate de usar el nombre correcto de tu clase
    
        // Obtener la descripción de la tabla
        $descripcionTabla = $gestorBD->obtenerDescripcionTabla($tabla);
    
        // Verificar si se obtuvo la descripción de la tabla correctamente
        if ($descripcionTabla) {
            // Construye el arreglo de campos
            $campos = array();
            foreach ($descripcionTabla as $campo) {
                $nombreCampo = $campo['Field'];
                $campos[$nombreCampo] = $_POST[$nombreCampo][0]; // Ajustado para agregar dinámicamente los campos
            }
    
            // Llama a la función insertarDatos() para insertar los datos en la tabla
            $resultado = $gestorBD->insertarDatos($tabla, $campos);
    
            // Muestra el resultado de la inserción
            echo $resultado;
        } else {
            echo "Error al obtener la descripción de la tabla.";
        }
    }

    // Función para procesar el formulario de actualización de datos en una tabla
    function ActualizarDatos() {
        // Recoge el nombre de la tabla
        $tabla = $_POST['tabla'];
    
        // Crea una instancia del gestor de base de datos
        $gestorBD = new GestorBD(); // Asegúrate de usar el nombre correcto de tu clase
    
        // Obtener la descripción de la tabla
        $descripcionTabla = $gestorBD->obtenerDescripcionTabla($tabla);
    
        // Verificar si se obtuvo la descripción de la tabla correctamente
        if ($descripcionTabla) {
            // Construye el arreglo de campos a actualizar
            $campos = array();
            foreach ($descripcionTabla as $campo) {
                $nombreCampo = $campo['Field'];
                if (isset($_POST[$nombreCampo])) {
                    $campos[$nombreCampo] = $_POST[$nombreCampo][0]; // Ajustado para agregar dinámicamente los campos
                }
            }
    
            // Llama a la función actualizarDatos() para actualizar los datos en la tabla
            $resultado = $gestorBD->actualizarDatos($campos, $tabla);
    
            // Muestra el resultado de la actualización
            echo $resultado;
        } else {
            echo "Error al obtener la descripción de la tabla.";
        }
    }
    
    // Función para procesar el formulario de actualización de datos en una tabla
    function buscarDatos(){
        // Recoge el nombre de la tabla
        $tabla = 'Users';
        $campo = 'email';
        $dato = $_POST['dato'];
        $gestorBD->buscarPorCampo($tabla, $campo, $dato);
        
    }

?>



