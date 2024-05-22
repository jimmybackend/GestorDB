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
    // Construir la consulta SQL sin utilizar una consulta preparada
    $query = "DESCRIBE $tabla";

    // Ejecutar la consulta directamente
    $resultado = $this->conexion->query($query);

    // Verificar si la consulta se ejecutó correctamente
    if ($resultado) {
        // Inicializar un array para almacenar los nombres de los campos de la tabla
        $descripcion = array();
       
        while ($fila = $resultado->fetch_assoc()) {
            $campo = $fila['Field'];
            $tipo = $fila['Type'];
            $nulo = $fila['Null'];
            $clave = $fila['Key'];
            $valor_por_defecto = $fila['Default'];
            $extra = $fila['Extra'];
        
            // Crear un arreglo asociativo con los datos de la fila
            $datos_fila = array(
                'campo' => $campo,
                'tipo' => $tipo,
                'nulo' => $nulo,
                'clave' => $clave,
                'valor_por_defecto' => $valor_por_defecto,
                'extra' => $extra
            );
        
            // Agregar el arreglo de datos de la fila al arreglo $descripcion
            $descripcion[] = $datos_fila;
        }


        // Devolver el array con la descripción de la tabla
        $resultado->close();
        return $descripcion;
    } else {
        // En caso de error al ejecutar la consulta, devolver un array vacío
        return array();
        }
    }
    
    // Método para obtener la descripción de dos campos de una tabla 
    private function obtenerDescripcionTabla2campos($tabla) {
    // Construir la consulta SQL sin utilizar una consulta preparada
    $query = "DESCRIBE $tabla";

    // Ejecutar la consulta directamente
    $resultado = $this->conexion->query($query);

    // Verificar si la consulta se ejecutó correctamente
    if ($resultado) {
        // Inicializar un array para almacenar los nombres de los campos de la tabla
        $descripcion = array();

        // Obtener los nombres de los campos de la tabla
        $i=0;
        while ($fila = $resultado->fetch_assoc()) {
            if($i <= 1)
            $descripcion[] = $fila['Field'];
            $i++;
        }

        // Devolver el array con la descripción de la tabla
        $resultado->close();
        return $descripcion;
    } else {
        // En caso de error al ejecutar la consulta, devolver un array vacío
        return array();
        }
    }
    
    // Método para imprimir en opcion los valores de los registros de dos campos de una tabla  
    private function obtenerCamposReferenciados($campo) {
        // Obtener la tabla referenciada por el campo
        $tabla = $this->obtenerTablaReferenciada($campo);
        
        if ($tabla) {
            // Obtener los campos de la tabla referenciada
            $campos_tabla = $this->obtenerDescripcionTabla2campos($tabla);
            
            // Imprimir la etiqueta y el menú desplegable
           // echo "<label for='$tabla'>$tabla:</label><br>";
           // echo "<select id='$campo' name='$campo' class='form-control'>";
            
            // Obtener los valores de los campos de la tabla referenciada
            $valores = $this->obtenerValoresDeCampos($tabla, $campos_tabla);
    
            // Verificar si se obtuvieron valores
            if (!empty($valores)) {
                // Recorrer los valores y construir las opciones del menú desplegable
                foreach ($valores as $fila) {
                    // Obtener el ID y el campo de la fila
                    $id = $fila[$campos_tabla[0]]; // Suponiendo que el primer campo es el ID
                    $campo2 = $fila[$campos_tabla[1]]; // Suponiendo que el segundo campo es el que se mostrará
                    
                    // Imprimir la opción del menú desplegable
                    echo "<option value='$id'>$campo2</option>";
                }
            } 
            
            // Cerrar el menú desplegable
            //echo '</select>';
        } else {
            // Imprimir un mensaje de error si no se pudo obtener la tabla referenciada
            echo "Error al preparar la consulta para la tabla referenciada: " . $this->conexion->error;
        }
    }
    
    // Método para obtener los registros de dos campos de una tabla  
    private function obtenerValoresDeCampos($tabla, array $campos) {
        // Convertir los nombres de los campos en una lista separada por comas
        $campos_sql = implode(", ", $campos);
    
        // Construir la consulta SQL
        $query = "SELECT $campos_sql FROM $tabla";
    
        // Preparar la consulta
        $stmt = $this->conexion->prepare($query);
    
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener el resultado de la consulta
            $resultado = $stmt->get_result();
    
            // Inicializar un arreglo para almacenar los valores de los campos
            $valores = array();
    
            // Recorrer los resultados y almacenar los valores de los campos en el arreglo
            while ($fila = $resultado->fetch_assoc()) {
                // Agregar la fila completa al arreglo de valores
                $valores[] = $fila;
            }
    
            // Cerrar el statement
            $stmt->close();
    
            // Devolver el arreglo de valores de los campos
            return $valores;
        } else {
            // En caso de error al preparar la consulta, devolver un arreglo vacío
            return array();
        }
    }
    
    // Método para obtener el nomnbre de la tabla apartir del campo index
    private function obtenerTablaReferenciada($campo) {
        // Verificar si los últimos cuatro caracteres del campo son "_id_"
        if (substr($campo, -4) === '_id_') {
            // Obtener el nombre de la tabla referenciada
            return ucfirst(substr($campo, 0, -4)).'s';
        } else {
            return false; // Retornar falso si el campo no termina en "_id_"
        }
    }

    // Método para generar la vista de una tabla
    public function generarVistaTabla_($tabla) {
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
            $stmt->close();
            // Construir la consulta SQL para seleccionar todos los registros de la tabla
            $query_registros = "SELECT * FROM $tabla";
            
            // Ejecutar la consulta de selección de registros
            $resultado = $this->conexion->query($query_registros);
            
            // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
                
                echo "<table class='table table-hover'><tr>";
    
                // Mostrar los encabezados de las columnas basados en los nombres de los campos
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo, 0, 1))) {
                        echo "<th>$campo</th>";
                    }
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {
                        if (ctype_upper(substr($campo, 0, 1))) {
                            if($campo == 'Estado'){
                                
                               
                                
                                if($fila[$campo]=='Abierto'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Activo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Inactivo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='En Progreso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else  if($fila[$campo]=='Cerrado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Pendiente'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='En proceso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Enviado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Entregado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Cancelado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else{
                                    echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>'; 
                                }
                                }else{
                            echo "<td>" . $fila[$campo] . "</td>";
                            }
                        }
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>";
                $resultado->close();
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    }
    
    // Método para generar la vista de la tabla Consultas en tabla html
    public function generarVistaTabla_Consultas($tabla) {
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
        $stmt->close();
        // Construir la consulta SQL para seleccionar todos los registros de la tabla
        $query_registros = "SELECT * FROM $tabla";
        
        // Ejecutar la consulta de selección de registros
        $resultado = $this->conexion->query($query_registros);
        
        // Verificar si se encontraron registros
        if ($resultado->num_rows > 0) {
            
            echo "<table class='table table-hover'><tr>";

            // Mostrar los encabezados de las columnas basados en los nombres de los campos
            foreach ($descripcion as $campo) {
                // Verificar si la primera letra del campo es mayúscula
                if (ctype_upper(substr($campo, 0, 1))) {
                    echo "<th>$campo</th>";
                }
            }

            echo "<th>Acción</th>"; // Encabezado adicional para la columna de acción

            echo "</tr>";

            // Mostrar los datos de cada registro en una fila de la tabla
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";

                // Mostrar los valores de cada campo que cumpla con el criterio
                foreach ($descripcion as $campo) {
                    if (ctype_upper(substr($campo, 0, 1))) {
                        if($campo == 'Estado'){
                            // Aquí se manejarían los estados con badges según lo mostrado en el ejemplo anterior
                        } else {
                            echo "<td>" . $fila[$campo] . "</td>";
                        }
                    }
                }

                // Botón de acción para ejecutar la consulta
                echo '<td>
    <form action="ejecutar.php" method="post">
        <input type="hidden" name="id_" value="' . $fila['id_'] . '">
        <button type="submit" class="btn btn-primary">Generar Reporte</button>
    </form>
</td>';


                echo "</tr>";
            }

            echo "</table>";
            $resultado->close();
        } else {
            echo "No se encontraron registros en la tabla $tabla.";
        }
    } else {
        echo "Error al preparar la consulta: " . $this->conexion->error;
    }
}
    
    // Método para generar la vista de la Consulta del registro Ejecutar Consulta
    public function generarVistaConsultas_($Consulta) {
    // Ejecutar la consulta de selección de registros
    $resultado = $this->conexion->query($Consulta);

    // Verificar si se encontraron registros
    if ($resultado->num_rows > 0) {
        echo "<table class='table table-hover'><tr>";

        // Obtener los nombres de los campos de la tabla
        $descripcion = $resultado->fetch_fields();
        $nombres_campos = array();
        foreach ($descripcion as $campo) {
            $nombres_campos[] = $campo->name;
            // Mostrar los encabezados de las columnas basados en los nombres de los campos
            if (ctype_upper(substr($campo->name, 0, 1))) {
                echo "<th>$campo->name</th>";
            }
        }

        echo "</tr>";

        // Mostrar los datos de cada registro en una fila de la tabla
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";

            // Mostrar los valores de cada campo que cumpla con el criterio
            foreach ($nombres_campos as $campo) {
                if (ctype_upper(substr($campo, 0, 1))) {
                    if ($campo == 'Estado') {
                                if($fila[$campo]=='Abierto'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Activo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Inactivo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='En Progreso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else  if($fila[$campo]=='Cerrado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Pendiente'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='En proceso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Enviado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Entregado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else if($fila[$campo]=='Cancelado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>';   
                                }else{
                                    echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo] .'</span>
                                </div></td>'; 
                                }
                                
                    } else {
                        echo "<td>" . $fila[$campo] . "</td>";
                    }
                }
            }

            echo "</tr>";
        }

        echo "</table>";
        $resultado->close();
    } else {
        echo "No se encontraron registros en la consulta.";
    }
}


   



    // Método para generar la vista de una tabla con su tabla detalle
    public function generarVistaTabla_con_Detalles($tabla) {
       $descripcion = array(); // Inicializa el arreglo de descripción

        // Obtener la descripción de la primera tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt0 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt0) {
            // Ejecutar la consulta
            $stmt0->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt0->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt0->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt0->close();
        }
       
 
       // Obtener la descripción de la segunda tabla
        $tabladetalles = $tabla . '_Detalles';
        $query_descripcion = "DESCRIBE $tabladetalles";
        $stmt1 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt1) {
            // Ejecutar la consulta
            $stmt1->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt1->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt1->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt1->close();
        }
        
        $i=1; 
        $tablasi= $tabla.' AS T1, '.$tabla.'_Detalles AS T2'; 
        $campod=strtolower(substr($tabla, 0, -1));
        $campod=$campod.'_id_';
        $camposi=' T'.$i.'.id_ = T2.'. $campod.' '; 
        $i=3; 

/*echo "<pre>";
var_dump($descripcion);
echo "</pre>";*/

            $query_registros = "SELECT * FROM $tablasi WHERE $camposi";
            
            $resultado = $this->conexion->query($query_registros);

            // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
   
                echo "<table class='table table-hover'><tr>";
    
               // Mostrar los encabezados de las columnas basados en los nombres de los campos de descripción
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo['campo'], 0, 1))) {
                        echo "<th>" . $campo['campo'] . "</th>";
                    }
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {

                        if (ctype_upper(substr($campo['campo'], 0, 1))) {
                            if($campo['campo'] == 'Estado'){
                                if($fila[$campo['campo']]=='Abierto'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Activo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Inactivo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En Progreso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else  if($fila[$campo['campo']]=='Cerrado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Pendiente'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En proceso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Enviado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Entregado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Cancelado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else{
                                    echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>'; 
                                }
                                }else{
                            echo "<td>" . $fila[$campo['campo']] . "</td>";
                            }
                        }
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>";
                $resultado->close();
                return $query_registros;
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        
    }
    
    // Método para generar la vista de una tabla con su tabla detalle de Productos
    public function generarVistaTabla_con_Detalles_Productos($tabla) {
       $descripcion = array(); // Inicializa el arreglo de descripción

        // Obtener la descripción de la primera tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt0 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt0) {
            // Ejecutar la consulta
            $stmt0->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt0->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt0->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt0->close();
        }
       
 
       // Obtener la descripción de la segunda tabla
        $tabladetalles = $tabla . '_Detalles';
        $query_descripcion = "DESCRIBE $tabladetalles";
        $stmt1 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt1) {
            // Ejecutar la consulta
            $stmt1->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt1->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt1->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt1->close();
        }
        
         // Obtener la descripción de la segunda tabla
        $tablap = 'Productos';
        $query_descripcion = "DESCRIBE $tablap";
        $stmt1 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt1) {
            // Ejecutar la consulta
            $stmt1->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt1->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt1->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt1->close();
        }
        
        $i=1; 
        $tablasi= $tabla.' AS T1, '.$tabla.'_Detalles AS T2, Productos AS T3';
        $campod=strtolower(substr($tabla, 0, -1));
        $campod=$campod.'_id_';
        $camposi=' T'.$i.'.id_ = T2.'. $campod.' AND T2.producto_id_ = T3.id_';  
        $i=3; 

/*echo "<pre>";
var_dump($descripcion);
echo "</pre>";*/

            $query_registros = "SELECT * FROM $tablasi WHERE $camposi";
            
            $resultado = $this->conexion->query($query_registros);

            // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
   
                echo "<table class='table table-hover'><tr>";
    
               // Mostrar los encabezados de las columnas basados en los nombres de los campos de descripción
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo['campo'], 0, 1))) {
                        echo "<th>" . $campo['campo'] . "</th>";
                    }
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {

                        if (ctype_upper(substr($campo['campo'], 0, 1))) {
                            if($campo['campo'] == 'Estado'){
                                if($fila[$campo['campo']]=='Abierto'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Activo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Inactivo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En Progreso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else  if($fila[$campo['campo']]=='Cerrado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Pendiente'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En proceso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Enviado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Entregado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Cancelado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else{
                                    echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>'; 
                                }
                                }else{
                            echo "<td>" . $fila[$campo['campo']] . "</td>";
                            }
                        }
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>";
                $resultado->close();
                return $query_registros;
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        
    }
    
    
    
    // Método para generar la vista de una tabla con todos los detalels que tenga en las tablas MAestro y Detalle
    public function generarVistaTabla_con_DetallesAll($tabla) {
       $descripcion = array(); // Inicializa el arreglo de descripción

        // Obtener la descripción de la primera tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt0 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt0) {
            // Ejecutar la consulta
            $stmt0->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt0->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt0->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt0->close();
        }
       
        $i=1;
        $tablasi= $tabla.' AS T1, '.$tabla.'_Detalles AS T2';
        $campod=strtolower(substr($tabla, 0, -1));
        $campod=$campod.'_id_';
        $camposi=' T'.$i.'.id_ = T2.'. $campod.' AND '; 
        $i=3; 
        
        foreach ($descripcion as $campo) {
             if (substr($campo['campo'], -4) === '_id_') {
                $tablax = $this->obtenerTablaReferenciada($campo['campo']);
                $tablasi .= ', '.$tablax.' AS T'.$i;
                $camposi .=' T1.'.$campo['campo'].' =  T'.$i.'.id_ AND';
                $i++;
                $query_descripcion = "DESCRIBE $tablax";
                $stmti = $this->conexion->prepare($query_descripcion);
                if ($stmti) {
                    $stmti->execute();
                    $stmti->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
                    while ($stmti->fetch()) {
                        $resultado = array(
                            'campo' => $campo,
                            'tipo' => $tipo,
                            'nulo' => $nulo,
                            'clave' => $clave,
                            'valor_por_defecto' => $valor_por_defecto,
                            'extra' => $extra
                        );
                        $descripcion[] = $resultado;
                    }
                    $stmti->close();
                }
             }
        }
        
       // Obtener la descripción de la segunda tabla
        $tabladetalles = $tabla . '_Detalles';
        $query_descripcion = "DESCRIBE $tabladetalles";
        $stmt1 = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt1) {
            // Ejecutar la consulta
            $stmt1->execute();
        
            // Vincular el resultado de la consulta a variables
            $stmt1->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
        
            while ($stmt1->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $descripcion[] = $resultado;
            }
            $stmt1->close();
        }
        
        foreach ($descripcion as $campo) {
             if (substr($campo['campo'], -4) === '_id_') {
                $tablax = $this->obtenerTablaReferenciada($campo['campo']);
                
                if (strpos($tablasi, $tablax) === false && strpos($camposi, $campo['campo']) === false) {
                   $tablasi .= ', '.$tablax.' AS T'.$i;
                   $camposi .=' T2.'.$campo['campo'].' =  T'.$i.'.id_ AND';
                   $i++;
                }
                
                $query_descripcion = "DESCRIBE $tablax";
                $stmti = $this->conexion->prepare($query_descripcion);
                if ($stmti) {
                    $stmti->execute();
                    $stmti->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);
                    while ($stmti->fetch()) {
                        $resultado = array(
                            'campo' => $campo,
                            'tipo' => $tipo,
                            'nulo' => $nulo,
                            'clave' => $clave,
                            'valor_por_defecto' => $valor_por_defecto,
                            'extra' => $extra
                        );
                        $descripcion[] = $resultado;
                    }
                    $stmti->close();
                }
             }
        }

/*echo "<pre>";
var_dump($descripcion);
echo "</pre>";*/

          
           $camposi = substr($camposi, 0, -3);
          $query_registros = "SELECT * FROM $tablasi WHERE $camposi";
            
            $resultado = $this->conexion->query($query_registros);

            // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
   
                echo "<table class='table table-hover'><tr>";
    
               // Mostrar los encabezados de las columnas basados en los nombres de los campos de descripción
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo['campo'], 0, 1))) {
                        echo "<th>" . $campo['campo'] . "</th>";
                    }
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {

                        if (ctype_upper(substr($campo['campo'], 0, 1))) {
                            if($campo['campo'] == 'Estado'){
                                if($fila[$campo['campo']]=='Abierto'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Activo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Inactivo'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En Progreso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else  if($fila[$campo['campo']]=='Cerrado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Pendiente'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-danger-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='En proceso'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Enviado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-warning-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Entregado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else if($fila[$campo['campo']]=='Cancelado'){
                             echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-secondary-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>';   
                                }else{
                                    echo '<td><div class="d-flex align-items-center">
                                  <span class="badge badge-md bg-success-lt mr-6">'. $fila[$campo['campo']] .'</span>
                                </div></td>'; 
                                }
                                }else{
                            echo "<td>" . $fila[$campo['campo']] . "</td>";
                            }
                        }
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>";
                $resultado->close();
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        
    }
    



    // Método para generar un formulario de agregar para una tabla respetando el tipo de dato
    public function generarFormularioAgregar($tabla) {
        // Obtener la descripción de la tabla de forma segura utilizando consultas preparadas
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($campo, $tipo, $nulo, $clave, $valor_por_defecto, $extra);

            echo "<form action='procesar.php' method='POST'>";
            echo '<input type="hidden" name="form_type" value="agregar">';
            echo '<input type="hidden" name="tabla" value="'.$tabla.'">';
            
            
            $resultados = array();
            while ($stmt->fetch()) {
                $resultado = array(
                    'campo' => $campo,
                    'tipo' => $tipo,
                    'nulo' => $nulo,
                    'clave' => $clave,
                    'valor_por_defecto' => $valor_por_defecto,
                    'extra' => $extra
                );
                $resultados[] = $resultado;
            }
            $stmt->close();
            

            foreach ($resultados as $fila) {
                
                $campo = $fila['campo'];
                $clave = $fila['clave'];
                $tipo = $fila['tipo'];
                
             if (substr($campo, -4) === '_id_') {
                  // Imprimir la etiqueta y el menú desplegable
                $tablax = $this->obtenerTablaReferenciada($campo);  
                echo "<label for='$tablax'>$tablax:</label><br>";
                echo "<select id='$campo' name='$campo' class='form-control'>";
                $this->obtenerCamposReferenciados($campo);
                echo '</select>';
             } else {
                        if (substr($campo, -1) != '_') {
                            if ($clave === 'UNI') { //$campo === 'PRI' ||  || $valor_por_defecto === 'auto_increment'
                                echo "<input type='hidden' name='$campo' value='$valor'>";
                            } else {
                                
                            preg_match('/^(\w+)/', $tipo, $matches);
                            $tipo2=$matches[1];
                            switch ($tipo2) {
                                    case 'varchar':
                                    if($campo == 'email' || $campo == 'correo' || $campo == 'Email' || $campo == 'Correo'){
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='email' id='$campo' name='$campo' class='form-control' required><br>";
                                    }else if($campo == 'pin' || $campo == 'pass' || $campo == 'Pin' || $campo == 'Pass'){
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='password' id='$campo' name='$campo' class='form-control' required><br>";
                                    }else
                                    {
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='text' id='$campo' name='$campo' class='form-control' required><br>";
                                    }
                                        break;
                                    case 'text':
                                        echo "<label for='$campo'>$campo:</label>";
                                        echo "<textarea id='$campo' name='$campo' class='form-control'></textarea><br>";
                                        break;
                                    case 'enum':
                                    preg_match_all("/'([^']+)'/", $tipo, $matches);
                                    $enum_values = $matches[1];
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    $select_html = "<select name='$campo' class='form-control' >" . '\n';
                                    foreach ($enum_values as $value) {
                                        $select_html .= "  <option value='".$value."'> ".$value." </option>" . '\n';
                                    }
                                    $select_html .= '</select><br>';
                                    echo $select_html;
                                        break;    
                                    case 'int':
                                    case 'bigint':
                                    case 'tinyint':
                                    case 'smallint':
                                    case 'mediumint':
                                    case 'decimal':
                                    case 'float':
                                    case 'double':
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='number' id='$campo' name='$campo' class='form-control' required><br>";
                                        break;
                                    case 'date':
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='date' id='$campo' name='$campo' class='form-control' required><br>";
                                        break;
                                    case 'datetime':
                                    case 'timestamp':
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='datetime-local' id='$campo' name='$campo' class='form-control' required><br>";
                                        break;
                                    default:
                                        echo "<label for='$campo'>$campo:</label><br>";
                                        echo "<input type='text' id='$campo' name='$campo' class='form-control' required><br>";
                                        break;
                                }
                                
                            
                            }
                        }
             }
            }    

            echo "<br><br><input type='submit' value='Guardar' class='btn btn-success'>";
            echo "</form>";
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
       
    }
    
    // Método para generar un formulario de actualizar para una tabla respetando el tipo de dato
    public function generarFormularioActualizar($tabla, $campox, $dato) {

    // Obtener los campos de la tabla referenciada
    $campos_tabla = $this->obtenerDescripcionTabla($tabla);

    // Verificar si la consulta se preparó correctamente
    if (!empty($campos_tabla)) {

        echo "<form action='procesar.php' method='POST'>";
        echo "<input type='hidden' name='form_type' value='actualizar'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        echo "<input type='hidden' name='campo' value='$campox'>";
        echo "<input type='hidden' name='dato' value='$dato'>";

      $id_registro=0;
        $resultados = array();
        foreach ($campos_tabla as $fila) {
            $campo = $fila['campo'];
            $tipo = $fila['tipo'];
            $nulo = $fila['nulo'];
            $clave = $fila['clave'];
            $valor_por_defecto = $fila['valor_por_defecto'];
            $extra = $fila['extra'];
        
            $resultado = array(
                'campo' => $campo,
                'tipo' => $tipo,
                'nulo' => $nulo,
                'clave' => $clave,
                'valor_por_defecto' => $valor_por_defecto,
                'extra' => $extra
            );
        
            $resultados[] = $resultado;
        }

           
                
                // Obtener el registro correspondiente
        $query_buscar = "SELECT * FROM $tabla WHERE $campox = ?";
        $stmt = $this->conexion->prepare($query_buscar);
        if ($stmt) {
            $stmt->bind_param("s", $dato);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
    // Inicializar un arreglo para almacenar los datos
    $datos_arreglo = array();
    
    // Verificar si se obtuvieron resultados
    if ($resultado->num_rows > 0) {
        // Obtener el primer registro
        $registro = $resultado->fetch_assoc();
    
        // Iterar sobre las claves y valores del registro
        foreach ($registro as $campo => $valor) {
            // Agregar cada clave y valor al arreglo
            $datos_arreglo[$campo] = $valor;
        }
        // Liberar el resultado
        $resultado->free();
        $stmt->close();


        foreach ($datos_arreglo as $campo => $valor) {
            // Buscar el campo en la descripción de la tabla
            $descripcion_campo = null;
            foreach ($resultados as $fila) {
                if ($fila['campo'] === $campo) {
                    $descripcion_campo = $fila;
                    break;
                }
            }

            if ($descripcion_campo !== null) {
                $tipo = $descripcion_campo['tipo'];
                $clave = $descripcion_campo['clave'];
                $valor_actual = $valor; 
                // Verificar si el campo es una clave foránea
                if (substr($campo, -4) === '_id_') {
                  $campo_ = str_replace("_id_", "", $campo);
                  $campo_ = ucfirst($campo_);
                  $Tabla = $campo_.'s';
                 
                    $sql = "SELECT * FROM $Tabla WHERE id_ = ?";
                    $stmt = $this->conexion->prepare($sql);
                    if ($stmt === false) {
                        $valor2 = null;
                    }
                    $stmt->bind_param("i", $valor);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    if ($row && count($row) >= 2) {
                        $keys = array_keys($row);
                        $valor2 = $row[$keys[1]];
                    } else {
                        $valor2 = null; 
                    }
                  $stmt->close();
        
                    echo "<label for='$Tabla'>$Tabla:</label><br>";
                    echo "<select id='$campo' name='$campo' class='form-control'>";
                    echo "<option value='$valor'>$valor2</option>";
                    $this->obtenerCamposReferenciados($campo);
                    echo "<select/>";
                } else {
                    if (substr($campo, -1) != '_') {
                            preg_match('/^(\w+)/', $tipo, $matches);
                            $tipo2 = $matches[1];
                            
                            switch ($tipo2) {
                                case 'varchar':
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    echo "<input type='text' id='$campo' name='$campo' class='form-control' value='$valor_actual' required><br>";
                                    break;
                                case 'text':
                                    echo "<label for='$campo'>$campo:</label>";
                                    echo "<textarea id='$campo' name='$campo' class='form-control'>$valor_actual</textarea><br>";
                                    break;
                                case 'enum':
                                    preg_match_all("/'([^']+)'/", $tipo, $matches);
                                    $enum_values = $matches[1];
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    $select_html = "<select name='$campo' class='form-control' >";
                                    foreach ($enum_values as $value) {
                                        $selected = ($value == $valor_actual) ? "selected" : "";
                                        $select_html .= "<option value='$value' $selected>$value</option>";
                                    }
                                    $select_html .= '</select><br>';
                                    echo $select_html;
                                    break;    
                                case 'int':
                                case 'bigint':
                                case 'tinyint':
                                case 'smallint':
                                case 'mediumint':
                                case 'decimal':
                                case 'float':
                                case 'double':
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    echo "<input type='number' id='$campo' name='$campo' class='form-control' value='$valor_actual' required><br>";
                                    break;
                                case 'date':
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    echo "<input type='date' id='$campo' name='$campo' class='form-control' value='$valor_actual' required><br>";
                                    break;
                                case 'datetime':
                                case 'timestamp':
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    echo "<input type='datetime-local' id='$campo' name='$campo' class='form-control' value='$valor_actual' required><br>";
                                    break;
                                default:
                                    echo "<label for='$campo'>$campo:</label><br>";
                                    echo "<input type='text' id='$campo' name='$campo' class='form-control' value='$valor_actual' required><br>";
                                    break;
                            }
                        }
                }
            }
}
echo "<br><br><input type='submit' value='Actualizar' class='btn btn-primary'>";
echo "</form>";


 

       
    } else {
        // No se encontraron registros
        echo "No se encontraron registros para el campo $campox con el valor $dato.";
    }
} else {
    // Error al preparar la consulta
    echo "Error al preparar la consulta: " . $this->conexion->error;
}

        

        
    } else {
        echo "Error al preparar la consulta: " . $this->conexion->error;
    }
}

    // Función para generar un formulario de búsqueda dinámico 
    public function generarFormularioBusqueda_($tabla) {
        echo '<h4>Buscar por campo</h4>';        
        echo "<form action='dashboard.php?f=$tabla-search' method='POST'>";
        echo "<input type='hidden' name='form_type' value='buscar'>";
        echo "<input type='hidden' name='f' value='$tabla-search'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        
        // Obtener la descripción de la tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($nombreCampo, $tipoCampo, $nulo, $clave, $valorPorDefecto, $extra);
            
            // Crear un array para almacenar los campos cuya primera letra sea mayúscula
            $camposMayuscula = [];
    
            // Obtener los campos cuya primera letra sea mayúscula
            while ($stmt->fetch()) {
                // Verificar si la primera letra del campo es mayúscula
                if (ctype_upper($nombreCampo[0])) {
                    // Agregar el campo al array de campos
                    $camposMayuscula[] = $nombreCampo;
                }
            }
    
            // Cerrar el statement
            $stmt->close();
            
            // Mostrar el select con los campos encontrados
            if (!empty($camposMayuscula)) {
                echo "<label for='campo_buscar'>Selecciona un campo:</label><br>";
                echo "<select id='campo_buscar' name='campo' class='form-control'>";
                foreach ($camposMayuscula as $campo) {
                    echo "<option value='$campo'>$campo</option>";
                }
                echo "</select><br>";
            } else {
                echo "No se encontraron campos con la primera letra mayúscula en la tabla '$tabla'.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    
        // Agregar el input para ingresar el dato a buscar
        echo "<label for='dato_buscar'>Ingrese el dato a buscar:</label><br>";
        echo "<input type='text' id='dato' name='dato' class='form-control' required><br><br>";
        
        // Agregar el botón de búsqueda
        echo "<input type='submit' value='Buscar' class='btn btn-success'><br>";
        echo "</form><br>";
    }

    // Función para generar un formulario de búsqueda dinámico
    public function generarFormularioBusquedaActualizacion_($tabla, $campo, $placeholder) {
        echo '<h4>Buscar para Actualizar</h4>';         
        echo "<form action='dashboard.php?f=$tabla-edit' method='POST'>";
        echo "<input type='hidden' name='form_type' value='edit'>";
        echo "<input type='hidden' name='f' value='$tabla-edit'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        
        // Obtener la descripción de la tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($nombreCampo, $tipoCampo, $nulo, $clave, $valorPorDefecto, $extra);
            
            // Crear un array para almacenar los campos cuya primera letra sea mayúscula
            $camposMayuscula = [];
    
            // Obtener los campos cuya primera letra sea mayúscula
            while ($stmt->fetch()) {
                // Verificar si la primera letra del campo es mayúscula
                if (ctype_upper($nombreCampo[0])) {
                    // Agregar el campo al array de campos
                    $camposMayuscula[] = $nombreCampo;
                }
            }
    
            // Cerrar el statement
            $stmt->close();
            
            // Mostrar el select con los campos encontrados
            if (!empty($camposMayuscula)) {
                echo "<label for='campo_buscar'>Selecciona un campo:</label><br>";
                echo "<select id='campo_buscar' name='campo' class='form-control'>";
                foreach ($camposMayuscula as $campo) {
                    echo "<option value='$campo'>$campo</option>";
                }
                echo "</select><br>";
            } else {
                echo "No se encontraron campos con la primera letra mayúscula en la tabla '$tabla'.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    
        // Agregar el input para ingresar el dato a buscar
        echo "<label for='dato_buscar'>Ingrese el dato a buscar:</label><br>";
        echo "<input type='text' id='dato' name='dato' class='form-control' required><br><br>";
        
        // Agregar el botón de búsqueda
        echo "<input type='submit' value='Buscar' class='btn btn-success'><br>";
        echo "</form><br>";
    }
    
    // Función para generar un formulario de búsqueda dinámico
    public function generarFormularioBusquedaBorrar_($tabla) {
        echo '<h4>Buscar para Eliminar</h4>';        
        echo "<form action='dashboard.php?f=$tabla-delete' method='POST'>";
        echo "<input type='hidden' name='f' value='$tabla-delete'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        
        // Obtener la descripción de la tabla
        $query_descripcion = "DESCRIBE $tabla";
        $stmt = $this->conexion->prepare($query_descripcion);
        
        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            // Ejecutar la consulta
            $stmt->execute();
            
            // Vincular el resultado de la consulta a variables
            $stmt->bind_result($nombreCampo, $tipoCampo, $nulo, $clave, $valorPorDefecto, $extra);
            
            // Crear un array para almacenar los campos cuya primera letra sea mayúscula
            $camposMayuscula = [];
    
            // Obtener los campos cuya primera letra sea mayúscula
            while ($stmt->fetch()) {
                // Verificar si la primera letra del campo es mayúscula
                if (ctype_upper($nombreCampo[0])) {
                    // Agregar el campo al array de campos
                    $camposMayuscula[] = $nombreCampo;
                }
            }
    
            // Cerrar el statement
            $stmt->close();
            
            // Mostrar el select con los campos encontrados
            if (!empty($camposMayuscula)) {
                echo "<label for='campo_buscar'>Selecciona un campo:</label><br>";
                echo "<select id='campo_buscar' name='campo' class='form-control'>";
                foreach ($camposMayuscula as $campo) {
                    echo "<option value='$campo'>$campo</option>";
                }
                echo "</select><br><br>";
            } else {
                echo "No se encontraron campos con la primera letra mayúscula en la tabla '$tabla'.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    
        // Agregar el input para ingresar el dato a buscar
        echo "<label for='dato_buscar'>Ingrese el dato a buscar:</label><br>";
        echo "<input type='text' id='dato' name='dato' class='form-control' required><br><br>";
        
        // Agregar el botón de búsqueda
        echo "<input type='submit' value='Buscar' class='btn btn-success'><br>";
        echo "</form><br>";
    }
    
    
    
    
    // Método para procesar los datos del formulario e insertarlos en la tabla
    public function insertarDatos($tabla, $datos) {
        // Filtrar los campos que tienen valores y excluir los campos form_type y tabla
        $camposConValor = array_filter($datos, function($valor, $campo) {
            return !empty($valor) && $campo !== 'form_type' && $campo !== 'tabla';
        }, ARRAY_FILTER_USE_BOTH);
    
        // Verificar si hay campos con valores
        if (!empty($camposConValor)) {
            // Construir la consulta SQL para insertar los datos
            $campos = implode(", ", array_keys($camposConValor));
            $placeholders = implode(', ', array_fill(0, count($camposConValor), '?'));
    
            $query_insert = "INSERT INTO $tabla ($campos) VALUES ($placeholders)";
    
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_insert);
    
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular los parámetros y ejecutar la consulta
                 $tipos = str_repeat('s', count($camposConValor));
                 $valores = array_values($camposConValor);
                 $stmt->bind_param($tipos,  ...$valores);
                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Redireccionar después de la inserción exitosa
                    header("Location: dashboard.php?f=$tabla-see");
                    exit;
                } else {
                    // Manejar errores de ejecución de consulta
                    echo "Error al ejecutar la consulta: " . $stmt->error;
                }
                
                // Cerrar el statement
                $stmt->close(); 
            } else {
                // Manejar errores de preparación de consulta
                echo "Error al preparar la consulta: " . $this->conexion->error;
            }
        } else {
            echo "No hay datos para insertar.";
        }
    }

    // Método para actualizar datos de un usuario
    public function actualizarDatos($tabla, $campox, $dato, $datos) {
        
         // Filtrar los campos que tienen valores y excluir los campos form_type y tabla
        $camposConValor = array_filter($datos, function($valor, $campo) {
            return !empty($valor) && $campo !== 'form_type' && $campo !== 'tabla' && $campo !== 'campo' && $campo !== 'dato';
        }, ARRAY_FILTER_USE_BOTH);
        
        //var_dump($camposConValor);
        
         // Verificar si hay campos con valores
        if (!empty($camposConValor)) {
            // Construir la consulta SQL para insertar los datos
            $campos = implode(", ", array_keys($camposConValor));
            $placeholders = implode(', ', array_fill(0, count($camposConValor), '?'));
            
            // Inicializar la cadena para la cláusula SET de la consulta
            $set_clause = "";
            
            // Inicializar un array para almacenar los valores y tipos de datos para la consulta preparada
            $valores = array();
            $tipos = "";
            // Recorrer los datos recibidos
            foreach ( $camposConValor as $campo => $valor) {
                // Evitar actualizar el correo electrónico
                if ($campo != 'email') {
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
           $query_actualizar = "UPDATE $tabla SET $set_clause WHERE $campox = ?";
 
            // Agregar el correo electrónico al array de valores y determinar su tipo de dato
            $valores[] = $dato;
            $tipos .= "s"; 
            
            // Preparar la consulta
            $stmt = $this->conexion->prepare($query_actualizar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular los parámetros y ejecutar la consulta
                $stmt->bind_param($tipos, ...$valores);
                $stmt->execute();
                $stmt->close();
                header("Location: dashboard.php?f=$tabla-see");
                exit;
            } else {
                echo "Error al preparar la consulta: " . $this->conexion->error;
            }
        
        } else {
            echo "No hay datos para actualizar.";
        }
    }
    
    // Método para eliminar un registro con confirmación
    public function eliminarRegistro_($tabla, $campo, $dato, $confirmar) {
        // Verificar si se recibió la confirmación para eliminar
        
        if ($confirmar == 'true') {
         $query_eliminar = "DELETE FROM $tabla WHERE $campo LIKE ?";
         $stmt = $this->conexion->prepare($query_eliminar);
            // Verificar si la consulta se preparó correctamente
            if ($stmt) {
                // Vincular el parámetro y ejecutar la consulta
                $param = "%$dato%";
                $stmt->bind_param("s", $param);
                $stmt->execute();
                
                // Verificar si la eliminación fue exitosa
                if ($stmt->affected_rows > 0) {
                    $stmt->close();
                    header("Location: dashboard.php?f=$tabla-see");
                    exit;
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
                    echo '<div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">';
                    echo "<h2>Resultado de la Búsqueda</h2>";
                    echo "<div class='col-12'><table border='1'><tr>";
                    
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
                    
                    echo "</table></div></div></div></div></div>";
                    $stmt->close();
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
    public function buscarPorCampo_($tabla, $campox, $dato) {
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
        
            $stmt->close();
            // Construir la consulta preparada para evitar la inyección SQL
            $query_buscar = "SELECT * FROM $tabla WHERE $campox LIKE ?";
            
            // Preparar la consulta
            $stmt0 = $this->conexion->prepare($query_buscar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt0) {
                // Vincular el parámetro y ejecutar la consulta
                $param = "%$dato%";
                $stmt0->bind_param("s", $param);
                $stmt0->execute();
                
        
                // Obtener el resultado de la consulta
                $resultado = $stmt0->get_result();
                
                // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
                echo '<div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-12">';
                echo "<table class='table table-hover'><tr>";
    
                // Mostrar los encabezados de las columnas basados en los nombres de los campos
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo, 0, 1))) {
                        echo "<th>$campo</th>";
                    }
                }
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {
                        if (ctype_upper(substr($campo, 0, 1))) {
                            echo "<td>" . $fila[$campo] . "</td>";
                        }
                    }
    
                    echo "</tr>";
                }
    
                echo "</table>  </div>
                    </div>
                  </div>
                </div>
              </div>";
              $stmt0->close();
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    
        }
        
    }
    
    // Método para buscar un registro por un campo específico y mostrar los resultados en una tabla
    public function buscarPorCampodelete_($tabla, $campox, $dato) {
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
        
            $stmt->close();
            // Construir la consulta preparada para evitar la inyección SQL
            $query_buscar = "SELECT * FROM $tabla WHERE $campox = ?";
            
            // Preparar la consulta
            $stmt0 = $this->conexion->prepare($query_buscar);
            
            // Verificar si la consulta se preparó correctamente
            if ($stmt0) {
                // Vincular el parámetro y ejecutar la consulta
                $stmt0->bind_param("s", $dato);
                $stmt0->execute();
                
        
                // Obtener el resultado de la consulta
                $resultado = $stmt0->get_result();
                
                // Verificar si se encontraron registros
            if ($resultado->num_rows > 0) {
                echo "<table class='table table-hover'><tr>";
    
                // Mostrar los encabezados de las columnas basados en los nombres de los campos
                foreach ($descripcion as $campo) {
                    // Verificar si la primera letra del campo es mayúscula
                    if (ctype_upper(substr($campo, 0, 1))) {
                        echo "<th>$campo</th>";
                    }
                }
                echo "<th>Accion</th>";
    
                echo "</tr>";
    
                // Mostrar los datos de cada registro en una fila de la tabla
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
    
                    // Mostrar los valores de cada campo que cumpla con el criterio
                    foreach ($descripcion as $campo) {
                        if (ctype_upper(substr($campo, 0, 1))) {
                            echo "<td>" . $fila[$campo] . "</td>";
                            
                        }
                    }
                           
        echo "<td><form action='procesar.php' method='POST'>";
        echo "<input type='hidden' name='form_type' value='eliminar'>";
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        echo "<input type='hidden' name='campo' value='$campox'>";
        echo "<input type='hidden' name='dato' value='$dato'>";
        echo "<input type='hidden' name='confirmar' value='true'>";
        echo "<input type='submit' value='Confirmo y Eliminar' class='btn btn-danger'>";
        echo "</form></td>";
                    echo "</tr>";
                }
    
                echo "</table>";
                $stmt0->close();
            } else {
                echo "No se encontraron registros en la tabla $tabla.";
            }
        } else {
            echo "Error al preparar la consulta: " . $this->conexion->error;
        }
    
        }
        
    }
            
           
           
           
          
    // Método para mostrar un formulario para agregar campos a una tabla
    public function mostrarFormularioAgregarCampos($tabla) {
        
        echo "<form action='dashboard.php' method='post'>";
        echo '<input type="hidden" name="form_type" value="agregar_campos_tabla">';
        echo "<input type='hidden' name='tabla' value='$tabla'>";
        echo "<table class='table table-hover'>";
    
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
        echo "<form action='dashboard.php' method='post'>";
        echo '<input type="hidden" name="form_type" value="crear_tabla">';
        echo "<table id='campos_container' class='table table-hover'>";
    
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

}
?>
