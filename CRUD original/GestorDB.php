<?php
class GestorDB {
    private $conexion;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        include 'db.php'; // Archivo con la conexión a la base de datos
        $this->conexion = $db_connection;
    }

    // Método para obtener la descripción de una tabla de forma segura utilizando consultas preparadas
    private function obtenerDescripcionTabla($tabla) {
        // Construir la consulta SQL utilizando una consulta preparada
        $query = "DESCRIBE ?";
        $stmt = $this->conexion->prepare($query);
    
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Vincular el parámetro de la tabla a la consulta preparada y ejecutarla
            $stmt->bind_param("s", $tabla);
            $stmt->execute();
    
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
    
            // Inicializar un array para almacenar los nombres de los campos de la tabla
            $descripcion = array();
    
            // Obtener los nombres de los campos de la tabla
            while ($stmt->fetch()) {
                $descripcion[] = $campo;
            }
    
            // Cerrar la consulta preparada
            $stmt->close();
    
            // Devolver el array con la descripción de la tabla
            return $descripcion;
        } else {
            // En caso de error al preparar la consulta, devolver un array vacío
            return array();
        }
    }

    // Método para generar la vista de una tabla
    public function generarVistaTabla($tabla) {
        // Obtener la descripción de la tabla de forma segura utilizando consultas preparadas
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
            
            // Obtener los nombres de los campos de la tabla
            $descripcion = array();
            while ($stmt->fetch()) {
                $descripcion[] = $campo;
            }
            
            // Construir la consulta SQL para seleccionar todos los registros de la tabla
            $query_registros = "SELECT * FROM $tabla";
            
            // Ejecutar la consulta de selección de registros
            $resultado = $this->conexion->query($query_registros);
            
            // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
                echo "<h2>Lista de $tabla</h2>";
                echo "<table border='1'><tr>";
    
                // Mostrar los encabezados de las columnas basados en los nombres de los campos
                foreach ($descripcion as $campo) {
                    echo "<th>$campo</th>";
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo
                    foreach ($descripcion as $campo) {
                        echo "<td>" . $fila[$campo] . "</td>";
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>";
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    }

    // Método para generar un formulario para una tabla específica
    public function generarFormulario($tabla) {
        // Obtener la descripción de la tabla de forma segura utilizando consultas preparadas
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
            
            // Mostrar el formulario
            echo "<h2>Formulario para agregar datos a la tabla $tabla</h2>";
            echo "<form action='procesar.php' method='post'>";
            echo '<input type="hidden" name="form_type" value="agregar_datos">';
            
            // Iterar sobre los resultados de la consulta y generar campos de entrada
            while ($stmt->fetch()) {
                echo "<label for='$campo'>$campo:</label>";
                echo "<input type='text' id='$campo' name='$campo'><br>";
            }
            
            // Cerrar el statement
            $stmt->close();
            
            echo "<input type='submit' value='Enviar'>";
            echo "</form>";
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    }

    // Método para procesar los datos del formulario e insertarlos en la tabla
    public function insertarDatos($tabla, $datos) {
        // Obtener la descripción de la tabla para verificar los campos
        $descripcion = $this->obtenerDescripcionTabla($tabla);
    
        // Verificar si se recibieron todos los campos necesarios
        if (count($datos) == count($descripcion)) {
            // Construir la consulta SQL para insertar los datos
            $campos = implode(", ", array_keys($datos));
            $valores = array_values($datos);
            
            // Construir la cadena de marcadores de posición para la consulta preparada
            $placeholders = implode(', ', array_fill(0, count($valores), '?'));
            $query_insert = "INSERT INTO $tabla ($campos) VALUES ($placeholders)";
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_insert);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular los parámetros y ejecutar la consulta
                $stmt->bind_param(str_repeat('s', count($valores)), ...$valores);
                if ($stmt->execute()) {
                    echo "Datos insertados correctamente.";
                } else {
                    echo "Error al insertar datos: " . $stmt->error;
                }
                // Cerrar el statement
                $stmt->close();
            } else {
                echo "Error al preparar la consulta: " . $this->conexion->error;
            }
        } else {
            echo "No se recibieron todos los campos necesarios.";
        }
    }

    // Método para generar formulario de actualización de usuario
    public function generarFormularioActualizacion($correo_buscar, $tabla) {
        // Preparar la consulta SQL para buscar el correo electrónico en la tabla especificada
        $query_buscar = "SELECT * FROM $tabla WHERE email = ?";
        
        // Preparar la consulta
        $stmt = $this->conexion->prepare($query_buscar);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Vincular el parámetro y ejecutar la consulta
            $stmt->bind_param("s", $correo_buscar);
            $stmt->execute();
            
            // Obtener el resultado de la consulta
            $resultado_buscar = $stmt->get_result();
            
            // Verificar si se encontraron resultados
            if ($resultado_buscar->num_rows > 0) {
                echo "<h2>Resultado de la Búsqueda</h2>";
    
                // Mostrar el formulario para actualizar los datos del usuario encontrado
                echo "<h2>Formulario para actualizar campos a la tabla $tabla</h2>";
                echo "<form action='procesar.php' method='post'>";
                echo '<input type="hidden" name="form_type" value="actualizar_campos">';
                echo "<input type='hidden' name='correo_buscar' value='$correo_buscar'>"; 
    
                while ($fila = $resultado_buscar->fetch_assoc()) {
                    // Mostrar los campos de usuario como input para actualizar
                    foreach ($fila as $campo => $valor) {
                        // Evitar que se pueda modificar el correo electrónico
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
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    }

    // Método para actualizar datos de un usuario
    public function actualizarDatos($datos, $tabla) {
        // Verificar si se recibieron los datos necesarios
        if (!empty($datos) && !empty($tabla)) {
            // Inicializar la cadena para la cláusula SET de la consulta
            $set_clause = "";
            
            // Inicializar un array para almacenar los valores y tipos de datos para la consulta preparada
            $valores = array();
            $tipos = "";
            
            // Recorrer los datos recibidos
            foreach ($datos as $campo => $valor) {
                // Evitar actualizar el correo electrónico
                if ($campo != 'correo') {
                    // Agregar el campo y el valor a la cadena SET
                    $set_clause .= "$campo = ?, ";
                    
                    // Agregar el valor y el tipo de dato a los arrays
                    $valores[] = $valor;
                    
                    // Determinar el tipo de dato
                    if (is_int($valor)) {
                        $tipos .= "i"; // Integer
                    } elseif (is_float($valor)) {
                        $tipos .= "d"; // Double
                    } elseif (is_string($valor)) {
                        $tipos .= "s"; // String
                    } else {
                        $tipos .= "s"; // Default to string
                    }
                }
            }
            
            // Eliminar la coma extra al final de la cadena SET
            $set_clause = rtrim($set_clause, ", ");
            
            // Construir la consulta SQL completa
            $query_actualizar = "UPDATE $tabla SET $set_clause WHERE correo = ?";
            
            // Agregar el correo electrónico al array de valores y determinar su tipo de dato
            $valores[] = $datos['correo'];
            $tipos .= "s"; // String
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_actualizar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular los parámetros y ejecutar la consulta
                $stmt->bind_param($tipos, ...$valores);
                $stmt->execute();
                
                // Verificar si la actualización fue exitosa
                if ($stmt->affected_rows > 0) {
                    echo "Datos actualizados correctamente.";
                } else {
                    echo "No se encontró ningún registro para actualizar.";
                }
            } else {
                echo "Error al preparar la consulta: " . $this->conexion->error;
            }
        } else {
            echo "Datos o tabla no especificados.";
        }
    }
    
    

    // Método para eliminar un registro con confirmación
    public function eliminarRegistro($tabla, $campo, $dato, $confirmar_eliminar) {
        // Verificar si se recibió la confirmación para eliminar
        if ($confirmar_eliminar) {
            // Construir la consulta preparada para evitar la inyección SQL
            $query_eliminar = "DELETE FROM $tabla WHERE $campo = ?";
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_eliminar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular el parámetro y ejecutar la consulta
                $stmt->bind_param("s", $dato);
                $stmt->execute();
                
                // Verificar si la eliminación fue exitosa
                if ($stmt->affected_rows > 0) {
                    echo "El registro con el dato '$dato' se ha eliminado correctamente.";
                } else {
                    echo "No se encontró ningún registro para eliminar.";
                }
            } else {
                echo "Error al preparar la consulta.";
            }
        } else {
            // Manejar el caso en el que no se reciba la confirmación
            echo "La eliminación no ha sido confirmada.";
        }
    }
    
    // Función para generar un formulario de búsqueda dinámico
    public function generarFormularioBusqueda($tabla, $campo, $placeholder) {
        echo "<h2>Buscar en $tabla por $campo</h2>";
        echo "<form action='procesar.php' method='post'>";
        echo "<input type='hidden' name='form_type' value='buscar'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        echo "<input type='hidden' name='campo' value='$campo'>";
        echo "<label for='dato_buscar'>$campo:</label>";
        echo "<input type='text' id='dato' name='dato' placeholder='$placeholder'>";
        echo "<input type='submit' value='Buscar'>";
        echo "</form>";
    }

    // Método para buscar un usuario por correo electrónico y mostrar los resultados en una tabla
    public function buscarPorCorreo($correo_buscar, $tabla) {
        // Verificar si se recibió un correo electrónico para buscar
        if (!empty($correo_buscar) && !empty($tabla)) {
            // Construir la consulta preparada para evitar la inyección SQL
            $query_buscar = "SELECT * FROM $tabla WHERE email = ?";
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_buscar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular el parámetro y ejecutar la consulta
                $stmt->bind_param("s", $correo_buscar);
                $stmt->execute();
                
                // Obtener el resultado de la consulta
                $resultado_buscar = $stmt->get_result();
                
                // Verificar si se encontraron resultados
                if ($resultado_buscar->num_rows > 0) {
                    echo "<h2>Resultado de la Búsqueda</h2>";
                    echo "<table border='1'><tr>";
                    
                    // Mostrar los encabezados de las columnas de la tabla
                    while ($fila_descripcion = $resultado_buscar->fetch_field()) {
                        echo "<th>" . $fila_descripcion->name . "</th>";
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
            } else {
                echo "Error al preparar la consulta.";
            }
        } else {
            echo "Correo electrónico o tabla no especificados.";
        }
    }

    // Método para buscar un registro por un campo específico y mostrar los resultados en una tabla
    public function buscarPorCampo($tabla, $campo, $dato) {
        // Verificar que se proporcionó la tabla y el campo
        if (!empty($tabla) && !empty($campo)) {
            // Construir la consulta preparada para evitar la inyección SQL
            $query_buscar = "SELECT * FROM $tabla WHERE $campo = ?";
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_buscar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular el parámetro y ejecutar la consulta
                $stmt->bind_param("s", $dato);
                $stmt->execute();
                
                // Obtener el resultado de la consulta
                $resultado_buscar = $stmt->get_result();
                
                // Verificar si se encontraron resultados
                if ($resultado_buscar->num_rows > 0) {
                    echo "<h2>Resultado de la Búsqueda</h2>";
                    echo "<table border='1'><tr>";
                    
                    // Mostrar los encabezados de las columnas de la tabla
                    while ($fila_descripcion = $resultado_buscar->fetch_field()) {
                        echo "<th>" . $fila_descripcion->name . "</th>";
                    }
                    
                    echo "</tr>";
                    
                    // Mostrar los datos del registro encontrado en una fila de la tabla
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
                    echo "No se encontraron resultados para el campo '$campo' con el valor '$dato'.";
                }
            } else {
                echo "Error al preparar la consulta.";
            }
        } else {
            echo "Tabla o campo no especificados.";
        }
    }

    // Método para mostrar un formulario para agregar campos a una tabla
    public function mostrarFormularioAgregarCampos($tabla) {
        echo "<h2>Formulario para agregar campos a la tabla $tabla</h2>";
        echo "<form action='procesar.php' method='post'>";
        echo '<input type="hidden" name="form_type" value="agregar_campos_tabla">';
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        echo "<table>";
    
        // Nombres de los campos
        echo "<tr>";
        echo "<td>Nombre del Campo:</td>";
        echo "<td>Tipo de Datos:</td>";
        echo "<td>Longitud/Valores:</td>";
        echo "<td>Predeterminado:</td>";
        echo "<td>Cotejamiento:</td>";
        echo "<td>Atributos:</td>";
        echo "<td>Nulo:</td>";
        echo "<td>Ajustar Privilegios:</td>";
        echo "<td>Documentación:</td>";
        echo "<td>A_I:</td>";
        echo "<td>Comentarios:</td>";
        echo "<td>Virtualidad:</td>";
        echo "<td>Mover Columna:</td>";
        echo "</tr>";
    
        // Contenedores de entrada para cada campo
        echo "<tr>";
        echo "<td><input type='text' id='nombre_campo' name='nombre_campo'></td>";
        // Campo para seleccionar el tipo de datos del nuevo campo
        echo "<td><select id='tipo_dato' name='tipo_dato'>";
        echo "<option value='INT'>INT</option>";
        echo "<option value='TINYINT'>TINYINT</option>";
        echo "<option value='SMALLINT'>SMALLINT</option>";
        echo "<option value='MEDIUMINT'>MEDIUMINT</option>";
        echo "<option value='BIGINT'>BIGINT</option>";
        echo "<option value='FLOAT'>FLOAT</option>";
        echo "<option value='DOUBLE'>DOUBLE</option>";
        echo "<option value='DECIMAL'>DECIMAL</option>";
        echo "<option value='DATE'>DATE</option>";
        echo "<option value='TIME'>TIME</option>";
        echo "<option value='DATETIME'>DATETIME</option>";
        echo "<option value='TIMESTAMP'>TIMESTAMP</option>";
        echo "<option value='YEAR'>YEAR</option>";
        echo "<option value='CHAR'>CHAR</option>";
        echo "<option value='VARCHAR'>VARCHAR</option>";
        echo "<option value='TINYTEXT'>TINYTEXT</option>";
        echo "<option value='TEXT'>TEXT</option>";
        echo "<option value='MEDIUMTEXT'>MEDIUMTEXT</option>";
        echo "<option value='LONGTEXT'>LONGTEXT</option>";
        echo "<option value='BINARY'>BINARY</option>";
        echo "<option value='VARBINARY'>VARBINARY</option>";
        echo "<option value='TINYBLOB'>TINYBLOB</option>";
        echo "<option value='BLOB'>BLOB</option>";
        echo "<option value='MEDIUMBLOB'>MEDIUMBLOB</option>";
        echo "<option value='LONGBLOB'>LONGBLOB</option>";
        echo "<option value='ENUM'>ENUM</option>";
        echo "<option value='SET'>SET</option>";
        echo "</select></td>";
    
        echo "<td><input type='text' id='longitud' name='longitud'></td>";
        echo "<td><input type='text' id='predeterminado' name='predeterminado'></td>";
        echo "<td><input type='text' id='cotejamiento' name='cotejamiento'></td>";
        echo "<td><input type='text' id='atributos' name='atributos'></td>";
        echo "<td><select id='nulo' name='nulo'>";
        echo "<option value='SI'>SI</option>";
        echo "<option value='NO'>NO</option>";
        echo "</select></td>";
        echo "<td><input type='text' id='ajustar_privilegios' name='ajustar_privilegios'></td>";
        echo "<td><input type='text' id='documentacion' name='documentacion'></td>";
        echo "<td><select id='autoincrementable' name='autoincrementable'>";
        echo "<option value='NO'>NO</option>";
        echo "<option value='SI'>SI</option>";
        echo "</select></td>";
        echo "<td><input type='text' id='comentarios' name='comentarios'></td>";
        echo "<td><input type='text' id='virtualidad' name='virtualidad'></td>";
        echo "<td><select id='mover_columna' name='mover_columna'>";
        echo "<option value='NO'>NO</option>";
        echo "<option value='SI'>SI</option>";
        echo "</select></td>";
        echo "</tr>";
    
        // Botón para enviar el formulario
        echo "<tr><td colspan='13' align='center'><input type='submit' value='Agregar Campo'></td></tr>";
    
        // Cierre de la tabla
        echo "</table>";
        echo "</form>";
    }

    // Método para agregar campos a una tabla
    public function agregarCampos($tabla, $campos) {
        // Verificar si se recibió el nombre de la tabla y al menos un campo para agregar
        if (!empty($tabla) && !empty($campos)) {
            // Construir la consulta SQL para alterar la tabla y agregar los campos
            $query = "ALTER TABLE $tabla ";
    
            foreach ($campos as $nombreCampo => $detallesCampo) {
                $tipoDato = $detallesCampo['tipo_dato'];
                $longitud = isset($detallesCampo['longitud']) ? "(" . $detallesCampo['longitud'] . ")" : '';
                $predeterminado = isset($detallesCampo['predeterminado']) ? "DEFAULT '" . $detallesCampo['predeterminado'] . "'" : '';
                $cotejamiento = isset($detallesCampo['cotejamiento']) ? "COLLATE " . $detallesCampo['cotejamiento'] : '';
                $atributos = isset($detallesCampo['atributos']) ? $detallesCampo['atributos'] : '';
                $nulo = isset($detallesCampo['nulo']) && $detallesCampo['nulo'] ? "NULL" : "NOT NULL";
                $ajustarPrivilegios = isset($detallesCampo['ajustar_privilegios']) ? $detallesCampo['ajustar_privilegios'] : '';
                $documentacion = isset($detallesCampo['documentacion']) ? $detallesCampo['documentacion'] : '';
                $autoIncremento = isset($detallesCampo['auto_incremento']) && $detallesCampo['auto_incremento'] ? "AUTO_INCREMENT" : '';
                $comentarios = isset($detallesCampo['comentarios']) ? "COMMENT '" . $detallesCampo['comentarios'] . "'" : '';
                $virtualidad = isset($detallesCampo['virtualidad']) ? $detallesCampo['virtualidad'] : '';
                $moverColumna = isset($detallesCampo['mover_columna']) ? $detallesCampo['mover_columna'] : '';
    
                $query .= "ADD $nombreCampo $tipoDato$longitud $predeterminado $cotejamiento $atributos $nulo $ajustarPrivilegios $documentacion $autoIncremento $comentarios $virtualidad $moverColumna, ";
            }
    
            // Eliminar la coma extra al final de la cadena
            $query = rtrim($query, ", ");
    
            // Ejecutar la consulta
            if ($this->conexion->query($query) === TRUE) {
                echo "Campos agregados correctamente a la tabla $tabla.";
            } else {
                echo "Error al agregar campos: " . $this->conexion->error;
            }
        } else {
            echo "Nombre de tabla o campos para agregar no especificados.";
        }
    }

    // Método para mostrar el formulario para crear una tabla
    public function mostrarFormularioCrearTabla() {
        echo "<h2>Formulario para crear una nueva tabla</h2>";
        echo "<form action='procesar.php' method='post'>";
        echo '<input type="hidden" name="form_type" value="crear_tabla">';
        echo "<table id='campos_container'>";
    
        // Nombres de los campos
        echo "<tr>";
        echo "<td>Nombre del Campo:</td>";
        echo "<td>Tipo de Datos:</td>";
        echo "<td>Longitud/Valores:</td>";
        echo "<td>Predeterminado:</td>";
        echo "<td>Cotejamiento:</td>";
        echo "<td>Atributos:</td>";
        echo "<td>Nulo:</td>";
        echo "<td>Ajustar Privilegios:</td>";
        echo "<td>Documentación:</td>";
        echo "<td>A_I:</td>";
        echo "<td>Comentarios:</td>";
        echo "<td>Virtualidad:</td>";
        echo "<td>Mover Columna:</td>";
        echo "<td>Acciones</td>";
        echo "</tr>";
    
        // JavaScript para agregar y eliminar campos
        echo "<script>";
        echo "let contadorCampos = 2;"; // Empezamos desde 2 porque ya tenemos un campo
        echo "function agregarCampo() {";
        echo "const camposContainer = document.getElementById('campos_container');";
        echo "const nuevoCampo = `<tr id='campo_${contadorCampos}'>";
        // Agrega aquí el HTML para un nuevo campo similar al que se encuentra dentro del bucle for en PHP
        echo "<td><input type='text' name='nombre_campo[]'></td>";
        echo "<td><select name='tipo_dato[]'>";
        echo "<option value='INT'>INT</option>";
        echo "<option value='TINYINT'>TINYINT</option>";
        echo "<option value='SMALLINT'>SMALLINT</option>";
        echo "<option value='MEDIUMINT'>MEDIUMINT</option>";
        echo "<option value='BIGINT'>BIGINT</option>";
        echo "<option value='FLOAT'>FLOAT</option>";
        echo "<option value='DOUBLE'>DOUBLE</option>";
        echo "<option value='DECIMAL'>DECIMAL</option>";
        echo "<option value='DATE'>DATE</option>";
        echo "<option value='TIME'>TIME</option>";
        echo "<option value='DATETIME'>DATETIME</option>";
        echo "<option value='TIMESTAMP'>TIMESTAMP</option>";
        echo "<option value='YEAR'>YEAR</option>";
        echo "<option value='CHAR'>CHAR</option>";
        echo "<option value='VARCHAR'>VARCHAR</option>";
        echo "<option value='TINYTEXT'>TINYTEXT</option>";
        echo "<option value='TEXT'>TEXT</option>";
        echo "<option value='MEDIUMTEXT'>MEDIUMTEXT</option>";
        echo "<option value='LONGTEXT'>LONGTEXT</option>";
        echo "<option value='BINARY'>BINARY</option>";
        echo "<option value='VARBINARY'>VARBINARY</option>";
        echo "<option value='TINYBLOB'>TINYBLOB</option>";
        echo "<option value='BLOB'>BLOB</option>";
        echo "<option value='MEDIUMBLOB'>MEDIUMBLOB</option>";
        echo "<option value='LONGBLOB'>LONGBLOB</option>";
        echo "<option value='ENUM'>ENUM</option>";
        echo "<option value='SET'>SET</option>";
        // Agrega más opciones según sea necesario
        echo "</select></td>";
        echo "<td><input type='text' name='longitud[]'></td>";
        echo "<td><input type='text' name='predeterminado[]'></td>";
        echo "<td><input type='text' name='cotejamiento[]'></td>";
        echo "<td><input type='text' name='atributos[]'></td>";
        echo "<td><select name='nulo[]'>";
        echo "<option value='SI'>SI</option>";
        echo "<option value='NO'>NO</option>";
        echo "</select></td>";
        echo "<td><input type='text' name='ajustar_privilegios[]'></td>";
        echo "<td><input type='text' name='documentacion[]'></td>";
        echo "<td><select name='autoincrementable[]'>";
        echo "<option value='NO'>NO</option>";
        echo "<option value='SI'>SI</option>";
        echo "</select></td>";
        echo "<td><input type='text' name='comentarios[]'></td>";
        echo "<td><input type='text' name='virtualidad[]'></td>";
        echo "<td><select name='mover_columna[]'>";
        echo "<option value='NO'>NO</option>";
        echo "<option value='SI'>SI</option>";
        echo "</select></td>";
        echo "<td><button type='button' onclick='eliminarCampo(${contadorCampos})'>Eliminar Campo</button></td>";
        echo "</tr>`;";
        echo "camposContainer.innerHTML += nuevoCampo;";
        echo "contadorCampos++;";
        echo "}";
        
        echo "function eliminarCampo(idCampo) {";
        echo "const campoAEliminar = document.getElementById(`campo_${idCampo}`);";
        echo "campoAEliminar.remove();";
        echo "}";
        echo "</script>";
    
        // Botón para agregar campo
        echo "<td colspan='14' align='center'><button type='button' onclick='agregarCampo()'>Agregar Campo</button></td>";
    
        // Botón para enviar el formulario
        echo "<td colspan='14' align='center'><input type='submit' value='Crear Tabla'></td>";
    
        // Cierre de la tabla
        echo "</table>";
        echo "</form>";
    }

    // Método para procesar el formulario de creación de tabla
    public function CrearTabla($datosTabla) {
        // Recuperar los datos del formulario
        $nombreTabla = $datosTabla['nombre_tabla'];
        $campos = $datosTabla['nombre_campo'];
        $tiposDatos = $datosTabla['tipo_dato'];
        $longitudes = $datosTabla['longitud'];
        $predeterminados = $datosTabla['predeterminado'];
        $cotejamientos = $datosTabla['cotejamiento'];
        $atributos = $datosTabla['atributos'];
        $nulos = $datosTabla['nulo'];
        $ajustarPrivilegios = $datosTabla['ajustar_privilegios'];
        $documentaciones = $datosTabla['documentacion'];
        $autoincrementables = $datosTabla['autoincrementable'];
        $comentarios = $datosTabla['comentarios'];
        $virtualidades = $datosTabla['virtualidad'];
        $moverColumnas = $datosTabla['mover_columna'];
    
        // Construir la consulta SQL para crear la tabla
        $sql = "CREATE TABLE $nombreTabla (";
    
        // Recorrer cada campo y sus detalles
        foreach ($campos as $indice => $nombreCampo) {
            // Recuperar los detalles del campo
            $tipoDato = $tiposDatos[$indice];
            $longitud = isset($longitudes[$indice]) ? "(" . $longitudes[$indice] . ")" : '';
            $predeterminado = isset($predeterminados[$indice]) ? "DEFAULT '" . $predeterminados[$indice] . "'" : '';
            $cotejamiento = isset($cotejamientos[$indice]) ? "COLLATE " . $cotejamientos[$indice] : '';
            $atributo = isset($atributos[$indice]) ? $atributos[$indice] : '';
            $nulo = isset($nulos[$indice]) && $nulos[$indice] == 'SI' ? "NULL" : "NOT NULL";
            $ajustarPrivilegio = isset($ajustarPrivilegios[$indice]) ? $ajustarPrivilegios[$indice] : '';
            $documentacion = isset($documentaciones[$indice]) ? $documentaciones[$indice] : '';
            $autoincrementable = isset($autoincrementables[$indice]) && $autoincrementables[$indice] == 'SI' ? "AUTO_INCREMENT" : '';
            $comentario = isset($comentarios[$indice]) ? "COMMENT '" . $comentarios[$indice] . "'" : '';
            $virtualidad = isset($virtualidades[$indice]) ? $virtualidades[$indice] : '';
            $moverColumna = isset($moverColumnas[$indice]) ? $moverColumnas[$indice] : '';
    
            // Agregar el campo a la consulta SQL
            $sql .= "$nombreCampo $tipoDato $longitud $predeterminado $cotejamiento $atributo $nulo $ajustarPrivilegio $documentacion $autoincrementable $comentario $virtualidad $moverColumna,"; // Separado por comas para agregar múltiples campos
        }
    
        // Eliminar la última coma de la consulta SQL
        $sql = rtrim($sql, ',');
    
        // Cierre de la consulta SQL
        $sql .= ");";
    
        // Ejecutar la consulta SQL en la base de datos
        // Aquí deberías tener tu lógica para ejecutar consultas SQL, por ejemplo:
        // $this->ejecutarConsulta($sql);
    
        // Ejemplo de ejecución de consulta (descomenta según sea necesario):
        // $this->ejecutarConsulta($sql);
    
        // Aquí podrías añadir más lógica, como redireccionar a otra página o mostrar un mensaje de éxito
    }


    // Destructor de la clase
    public function __destruct() {
        // Cerrar conexión a la base de datos
        $this->conexion->close();
    }
    


    // Otros métodos para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
    // Puedes agregar métodos para realizar operaciones como insertar, actualizar, borrar, etc.
}
?>
