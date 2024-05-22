<?php include 'main00.php'; ?>
<!DOCTYPE html>
<html lang="ES">
<head>
  <meta charset="utf-8" />
  <title>Tienda en Línea | Esforzados</title>
  <meta name="description" content="Plataforma integral de gestión para tiendas en línea. Optimiza ventas, inventario y relaciones con clientes. ¡Impulsa tu negocio hoy!" />
<?php include 'main0.php'; ?>
</head>

<body class="layout-column">
  <div id="main-page">
<?php include 'main01.php'; ?>
    <div id="main" class="layout-row flex">
<?php include 'main05.php'; ?>
      <div id="content" class="flex animate fadeInLeft">
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['f'])) {
        $valor_f = $_GET['f'];
        $partes = explode('-', $valor_f);
        if (count($partes) == 2) {
            $tabla1 = $partes[0];
            $accion1 = $partes[1];
           
            if($accion1=='see')
            echo '<h2>Ver '.$tabla1.'</h2>';
            if($accion1=='edit')
            echo '<h2>Actualizar '.$tabla1.'</h2>';
            if($accion1=='search')
            echo '<h2>Buscar '.$tabla1.'</h2>';
            if($accion1=='add')
            echo '<h2>Agregar '.$tabla1.'</h2>';
            if($accion1=='delete')
            echo '<h2>Eliminar '.$tabla1.'</h2>';
             if($accion1=='seeConsulta')
            echo '<h2>Reportes</h2>';
        }
    }
}
?>
        <div class="flex">
          <div class="padding">
              <div class="card-body">
                 
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['f'])) {
        $valor_f = $_GET['f'];
        $partes = explode('-', $valor_f);
        if($valor_f=='dashboard'){
            echo '<div class="d-flex flex-column flex">
  <div>
    <div class="p-3 p-md-5">
      <div class="card p-0 col-lg-8 offset-lg-2">
          <div class="row no-gutters">
            <div class="col-md-6 bg-success r-l" style="">
              <div class="p-4 d-flex flex-column h-100">
                <h4 class="mb-3 text-white">Plataforma integral de gestión para tiendas en línea.</h4>
                <div class="text-fade">Optimiza ventas, inventario y relaciones con clientes.</div>
                <div class="text-fade">¡Impulsa tu negocio hoy!</div>
                
                <div class="d-flex flex align-items-center justify-content-center">
                	<div class="animate fadeIn"><br> <br> 
                	    <img src="assets/img/logo/tiendaenlinea.png" width="202px" alt=""> 
                	    <br> 
                	 </div>
                </div>
                <div class="text-right text-inherit"><a href="https://esforzados.com/projects.php" class="text-fade">Acerca de</a></div>
              </div>
            </div>
           
          </div>
      </div>
    </div>
  </div>
</div>';
       
        }

        if (count($partes) == 2) {
            $tabla = $partes[0];
            $accion = $partes[1];

            include 'GestorDB.php';
            $gestorBD = new GestorDB();

            switch ($accion) {
                case 'see':
                     $gestorBD->generarVistaTabla_($tabla);
                    if($tabla == 'Productos' || $tabla == 'Pedidos'  || $tabla == 'Compras' || $tabla == 'Producciones' || $tabla == 'SupportTickets' ){   
                    echo '<div class="col-12 mb-3 d-flex">
                <a class="text-primary mr-3 animation-icon d-flex" data-toggle="modal" data-target="#import-modal" id="import-start">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/installing-updates/installing-updates.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/installing-updates/installing-updates.gif" class="play" alt="">
                  </div>
                  Import CSV
                </a>
                <a href="javascript:void(0);" onclick="window.open(\'exportcsv.php?f='.$tabla1.'\')" class="text-primary mr-3 animation-icon d-flex">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.gif" class="play" alt="">
                  </div>
                  Exportar CSV
                </a>
                <a href="javascript:void(0);" onclick="window.open(\'imprimirpdf.php?f='.$tabla1.'\')" class="text-primary animation-icon d-flex d-flex align-items-center">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/print/print.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/print/print.gif" class="play" alt="">
                  </div>
                  Imprimir PDF
                </a>
              </div>';
                    }
                   
                    break;
                case 'seedetails':
                    
                    $sql = $gestorBD->generarVistaTabla_con_Detalles($tabla);
                    if($tabla == 'Productos' || $tabla == 'Pedidos'  || $tabla == 'Compras' || $tabla == 'Producciones' || $tabla == 'SupportTickets' ){   
                echo '<div class="col-12 mb-3 d-flex">
                
                <a href="javascript:void(0);" onclick="window.open(\'exportdetailscsv.php?f='.$tabla1.'&sql='.$sql.'\')" class="text-primary mr-3 animation-icon d-flex">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.gif" class="play" alt="">
                  </div>
                  Exportar CSV
                </a>
                <a href="javascript:void(0);" onclick="window.open(\'imprimirdetailspdf.php?f='.$tabla1.'&sql='.$sql.'\')" class="text-primary animation-icon d-flex d-flex align-items-center">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/print/print.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/print/print.gif" class="play" alt="">
                  </div>
                  Imprimir PDF
                </a>
              </div>';
                    }
                    break; 
                case 'seedetailsProductos':
                    $sql = $gestorBD->generarVistaTabla_con_Detalles_Productos($tabla);
                    if($tabla == 'Productos' || $tabla == 'Pedidos'  || $tabla == 'Compras' || $tabla == 'Producciones' || $tabla == 'SupportTickets' ){   
                echo '<div class="col-12 mb-3 d-flex">
                
                <a href="javascript:void(0);" onclick="window.open(\'exportdetailsProductoscsv.php?f='.$tabla1.'&sql='.$sql.'\')" class="text-primary mr-3 animation-icon d-flex">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.gif" class="play" alt="">
                  </div>
                  Exportar CSV
                </a>
                <a href="javascript:void(0);" onclick="window.open(\'imprimirdetailsProductospdf.php?f='.$tabla1.'&sql='.$sql.'\')" class="text-primary animation-icon d-flex d-flex align-items-center">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/print/print.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/print/print.gif" class="play" alt="">
                  </div>
                  Imprimir PDF
                </a>
              </div>';
                    }
                    
                    break;
                case 'seeConsulta':
                    $gestorBD->generarVistaTabla_Consultas($tabla);
                    break;    
                case 'add':
                    echo '<div class="col-12 d-flex justify-content-between"><h4>Formulario para Agregar</h4></div> <div class="col-6">'; 
                    $gestorBD->generarFormularioAgregar($tabla);
                    echo '</div>';
                    break;
                case 'edit':
                    //$gestorBD->generarVistaTabla_($tabla);
                    break;
                case 'search':
                    $campox='Correo';
                    $placeholder='Correo';
                    '<div class="col-6">';
                    $gestorBD->generarFormularioBusqueda_($tabla, $campox, $placeholder);
                    echo '</div>';
                    break;
                case 'delete':
                    '<div class="col-6">';
                    $gestorBD->generarFormularioBusquedaBorrar_($tabla);
                    echo '</div>';
                    break;
                case 'Configsee':
                    echo '<div class="col-12 d-flex justify-content-between"><h4>Formulario para crear una nueva tabla</h4></div> <div class="col-6">'; 
                    $gestorBD->mostrarFormularioCrearTabla();
                    echo '</div></div>';
                    echo '<div class="col-12 d-flex justify-content-between"><h4>Formulario para agregar campos a la tabla $tabla</h4></div> <div class="col-6">'; 
                    $gestorBD->mostrarFormularioAgregarCampos('Tiendas');
                    echo '</div></div>';
                    break;    
                    
                
                default:
                    // Acción no válida
                    echo "Acción no válida.";
                    break;
            }
        } 
    } 
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['f'])) {
        $valor_f = $_POST['f'];
        $partes = explode('-', $valor_f);
        if (count($partes) == 2) {
            $tabla = $partes[0];
            $accion = $partes[1];

            include 'GestorDB.php';
            $gestorBD = new GestorDB();

            switch ($accion) {
                case 'search':
                    $campox='Correo';
                    $placeholder='Correo';
                    echo '<div class="col-6">'; 
                    $gestorBD->generarFormularioBusqueda_($tabla, $campox, $placeholder);
                    echo '</div>';
                    $tabla = $_POST['tabla'];
                    $campox = $_POST['campo'];  
                    $dato = $_POST['dato'];
                    echo '<div class="col-6">';
                    $gestorBD->buscarPorCampo_($tabla, $campox, $dato);
                    echo '</div>';
                    break;
                case 'delete':
                    echo '<div class="col-6">'; 
                    $gestorBD->generarFormularioBusquedaBorrar_($tabla);
                    echo '</div>';
                    $tabla = $_POST['tabla'];
                    $campox = $_POST['campo'];  
                    $dato = $_POST['dato'];
                    if($dato != null){
                    echo '<div class="col-6">';     
                    $gestorBD->buscarPorCampodelete_($tabla, $campox, $dato);
                    echo '</div>';
                    }
                    break;
                case 'edit':
                    $dato = $_POST['dato'];
                    $campox = $_POST['campo'];
                    $placeholder=$_POST['placeholder'];
                    echo '<div class="col-6">'; 
                    $gestorBD->generarFormularioBusquedaActualizacion_($tabla, $campox, $placeholder);
                     echo '</div>';
                    echo '<div class="col-12 d-flex justify-content-between"><h4>Formulario para Actualizar</h4></div> <div class="col-6">'; 
                    $gestorBD->generarFormularioActualizar($tabla, $campox, $dato);
                    echo '</div>';
                    break;
                case 'seeConsulta':
                    echo '<h2>Reporte</h2>';
                    if (isset($_POST['Consulta'])) {
                     $Consulta = $_POST['Consulta'];
                     $Consulta= urldecode($Consulta);
                    $gestorBD->generarVistaConsultas_($Consulta);
                    $Consulta=urlencode($Consulta);
                      
                echo '<div class="col-12 mb-3 d-flex">
                <a href="javascript:void(0);" onclick="exportConsultaCsv(\''.$Consulta.'\')" class="text-primary mr-3 animation-icon d-flex">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/uninstalling-updates/uninstalling-updates.gif" class="play" alt="">
                  </div>
                  Exportar CSV
                </a>
                <a href="javascript:void(0);" onclick="imprimirConsultaCsv(\''.$Consulta.'\')" class="text-primary animation-icon d-flex d-flex align-items-center">
                  <div class="mr-2">
                    <img src="assets/img/animated-icons/print/print.svg" class="stop" alt="">
                    <img src="assets/img/animated-icons/print/print.gif" class="play" alt="">
                  </div>
                  Imprimir PDF
                </a>
               </div>';
                    }
                    break;    
                default:
                    // Acción no válida
                    //echo "Acción no válida.";
                    break;
            }
        } 
    } 
} 
?> 

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['f'])) {
        $valor_f = $_GET['f'];
        $partes = explode('-', $valor_f);
        if (count($partes) == 2) {
            $tabla = $partes[0];
            $accion = $partes[1];

            switch ($accion) {
                case 'edit':
                    $campox='Correo';
                    $placeholder='Correo';
                    echo '<div class="col-6">'; 
                    $gestorBD->generarFormularioBusquedaActualizacion_($tabla, $campox, $placeholder);
                    echo '</div>';
                    break;
                case 'see':
                    $campox='Correo';
                    $placeholder='Correo';
                    echo '<br><br><div class="col-6">'; 
                    $gestorBD->generarFormularioBusqueda_($tabla, $campox, $placeholder);
                    echo '</div>';
                    break;
                default:
                    // Acción no válida
                    //echo "Acción no válida.";
                    break;
            }
        } 
    } 
}
        if($tabla=='Tiendas'){
        echo '<br><br><li> <a href="tienda.php" target= "_blank"><span class="nav-text">Ejemplo de Tienda en  Linea</span></a></li>';
        }
?> 
                     
              </div></div></div></div>
                  
              </div>
        
        


<!-- HTML del formulario con Dropzone -->
<div id="import-modal" class="modal fade" data-backdrop="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <div class="step-1">Importar productos desde CSV</div>
                </h5>
            </div>
            <div class="modal-body p-lg">
                <div class="step-1">
                    <div class="row">
                        <p class="px-3">Descargue una <a href="export.csv">plantilla CSV de muestra</a> para ver un ejemplo del formato requerido.</p>
                        <div class="col-12 animation-icon">
                           <form action="importcsv.php" method="post" enctype="multipart/form-data" id="dropzoneForm">
                            <!-- Campo de entrada de archivo CSV -->
                            <div class="form-group">
                                <label for="csv_file">Seleccionar archivo CSV:</label>
                                <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
                            </div>
                            <div class="col-12">
                            <div class="form-group">
                                <label for="sobrescribir">Sobrescribir productos existentes con el mismo identificador:</label>
                                <input type="checkbox" id="sobrescribir" name="sobrescribir">
                            </div>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="step-1 text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Subir y continuar</button>
                            </div>
                        </form>

                        </div>
                        
                    </div>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div>
</div>




   
    </div>

   
  </div>
<?php include 'main06.php'; ?>
<script>
    function exportConsultaCsv(consulta) {
        // Crear un formulario oculto
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "exportConsultacsv.php");

        // Crear campo oculto para Consulta
        var fieldConsulta = document.createElement("input");
        fieldConsulta.setAttribute("type", "hidden");
        fieldConsulta.setAttribute("name", "sql");
        fieldConsulta.setAttribute("value", consulta);

        // Agregar los campos al formulario
        form.appendChild(fieldConsulta);

        // Agregar el formulario al cuerpo del documento y enviarlo
        document.body.appendChild(form);
        form.submit();
    }
</script>
<script>
    function imprimirConsultaCsv(consulta) {
        // Crear un formulario oculto
        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", "imprimirConsultaCsv.php");
        form.setAttribute("target", "_blank");

        // Crear campo oculto para Consulta
        var fieldConsulta = document.createElement("input");
        fieldConsulta.setAttribute("type", "hidden");
        fieldConsulta.setAttribute("name", "sql");
        fieldConsulta.setAttribute("value", consulta);

        // Agregar los campos al formulario
        form.appendChild(fieldConsulta);

        // Agregar el formulario al cuerpo del documento y enviarlo
        document.body.appendChild(form);
        form.submit();
    }
</script>

<?php include 'main07.php'; ?>
</body>
</html>