<?php

namespace PHPMaker2024\hercules;

// Page object
$ListadoMaster = &$Page;
?>
<?php
$Page->showMessage();
?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<?php
// ... [CÓDIGO PHP DE LÓGICA DE SWITCH CASE SE MANTIENE SIN CAMBIOS] ...
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$titulo = '';
$url = "ListadoMasterBuscar"; // URL base para la búsqueda
$graficos = false;
$indicador = '';
$express = '';
$print = '';
$lapidas_options_output = '';

// ... [LÓGICA DE SWITCH CASE AQUÍ] ...

switch($id) {
    case "reclamos":
        $titulo = "Listar Reclamos";
        $graficos = true;
        $indicador = "indicadores_01.php";
        $express = "indicadores_04.php";
        break;
    case "orden_salida":
        $titulo = "Listar Orden Salida de Flotas";
        break;
    case "mttotecnico":
        $titulo = "Listar Mtto Tecnico";
        $graficos = true;
        $indicador = "indicadores_05.php";
        $express = "indicadores_06.php";
        break;
    case "flotas":
        $titulo = "Listar Incidencia Flotas";
        $graficos = true;
        $indicador = "indicadores_10.php";
        $express = "indicadores_11.php";
        break;
    case "lapidas":
        $titulo = "Listar Registro Lapidas";
        $graficos = true;
        $indicador = "indicadores_12.php";
        $express = "indicadores_13.php";

        // Botones de impresión (Iconos actualizados)
        $print = '<button type="button" class="btn btn-primary" id="print" name="print">
            <span class="fa fa-print"></span> Reporte por Fecha Modificación
        </button>&nbsp;';
        $print .= '<button type="button" class="btn btn-primary" id="print2" name="print2">
            <span class="fa fa-print"></span> Reporte por Cambio de Estatus
        </button>';
        
        // REFACTORIZACIÓN DE BASE DE DATOS: Consulta única para obtener todas las opciones
        if (isset($link) && $link instanceof mysqli) {
            $sql_lapidas_all = "SELECT DISTINCT nota AS estatus FROM sco_lapidas_notas WHERE nota LIKE 'Cambio de estatus de%' ORDER BY nota ASC;";
            $result = $link->query($sql_lapidas_all);
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $est = $row["estatus"];
                    $est_display = str_replace("Cambio de estatus de ", "", $est);
                    // Seguridad: Sanitizar para evitar XSS
                    $lapidas_options_output .= '<option value="' . htmlspecialchars($est) . '">' . htmlspecialchars($est_display) . '</option>';
                }
            }
        }
        
        break;
    case "parcelas":
        $titulo = "Listar Compra-Ventas Parcelas";
        $graficos = true;
        $indicador = "indicadores_15.php";
        $express = "indicadores_14.php";
        break;
    case "compras":
        $titulo = "Listar Ordenes de Compra";
        $graficos = true;
        $indicador = "indicadores_20.php";
        $express = "indicadores_20.php";
        break;
    case "otros":
        $graficos = false;
        $titulo = "Listar Otros Registros";
        break;
    default:
        $titulo = "Listar Registros";
}
?>

<h2><?php echo $titulo; ?></h2>

<div class="container" style="margin-top: 15px;">
    
    <form id="search-form" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">
        
        <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
            
            <div class="form-group">
                <label for="fecha_desde" style="margin-right: 5px;">Fecha Desde:</label>
                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" required>
            </div>
            
            <div class="form-group">
                <label for="fecha_hasta" style="margin-right: 5px;">Hasta:</label>
                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" required>
            </div>

            <div class="form-group">
                <label for="tipo_mov" style="margin-right: 5px;">Tipo:</label>
                <select class="form-control" name="tipo_mov" id="tipo_mov">
                    <option value="registro">Fecha Registro</option>
                <?php
                if($id=="parcelas") {
                ?>
                    <option value="compra">Fecha Compra</option>
                    <option value="venta">Fecha Venta</option>
                <?php
                }
                ?>
                <?php
                if($id=="lapidas") {
                    echo $lapidas_options_output;
                }
                ?>
                </select>
            </div>

            <button type="button" class="btn btn-success" id="buscar" name="buscar">
                <span class="fa fa-search"></span> Buscar Registros
            </button>
        </div>

        <?php if($graficos) { ?>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                
                <button type="button" class="btn btn-primary" id="indicadores" name="indicadores">
                    <span class="fa fa-chart-bar"></span> Ver Indicadores
                </button>
                <button type="button" class="btn btn-primary" id="indicadores2" name="indicadores2">
                    <span class="fa fa-bolt"></span> Indicadores Express
                </button>
                <?php echo $print; ?>
            </div>
        <?php } ?>
    </form>
</div>

<div>
    <div id="result">
    </div>
</div>

<script type="text/javascript">
    // ... [CÓDIGO JAVASCRIPT SE MANTIENE SIN CAMBIOS] ...
    $(document).ready(function() {
        
        // Función de validación de fechas consolidada
        function validateDates() {
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            if(fecha_desde === "" || fecha_hasta === "") {
                alert("Por favor, seleccione un rango de fechas correcto.");
                return false;
            }
            return true;
        }

        // Manejador del botón Buscar
        $("#buscar").click(function(){
            if (!validateDates()) {
                return false;
            }
            
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            var tipo_mov = $("#tipo_mov").val();
            var url = "<?php echo $url; ?>";
            var id = '<?php echo $id;?>';

            $.ajax({
              url: url,
              type: "GET",
              data: {id: id, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, tipo_mov: tipo_mov},
              beforeSend: function(){
                // Feedback visual de carga
                $("#result").html('<div class="alert alert-info" role="alert"><span class="fa fa-spinner fa-spin"></span> Cargando datos, por favor espere...</div>');
              }
            })
            .done(function(data) {
                $("#result").html(data);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                // Manejo de error mejorado
                $("#result").html('<div class="alert alert-danger" role="alert"><span class="fa fa-times-circle"></span> Error al buscar registros. Detalle: ' + textStatus + ' - ' + errorThrown + '</div>');
            });
        }); 

        // Manejador de indicadores (Ver Indicadores)
        $("#indicadores").click(function(){
            if (!validateDates()) {
                return false;
            }
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            var tipo_mov = $("#tipo_mov").val();

            var url = "<?php echo $indicador; ?>?fecha_desde=" + fecha_desde + "&fecha_hasta=" + fecha_hasta + "&tipo_mov=" + tipo_mov;
            window.location.href = url;
        }); 

        // Manejador de indicadores (Indicadores Express)
        $("#indicadores2").click(function(){
            if (!validateDates()) {
                return false;
            }
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            var tipo_mov = $("#tipo_mov").val();

            var url = "<?php echo $express; ?>?fecha_desde=" + fecha_desde + "&fecha_hasta=" + fecha_hasta + "&tipo_mov=" + tipo_mov;
            window.location.href = url;
        }); 

        // Manejador de Reporte por Fecha Modificación
        $("#print").click(function(){
            if (!validateDates()) {
                return false;
            }
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();

            window.open("../fpdf_report/rptEstatusLapidas.php?fecha_desde=" + fecha_desde + "&fecha_hasta=" + fecha_hasta, "_blank");
        }); 

        // Manejador de Reporte por Cambio de Estatus
        $("#print2").click(function(){
            if (!validateDates()) {
                return false;
            }
            var fecha_desde = $("#fecha_desde").val();
            var fecha_hasta = $("#fecha_hasta").val();
            var tipo_mov = $("#tipo_mov").val();

            window.open("../fpdf_report/rptEstatusFechaLapidas.php?estatus=" + tipo_mov + "&fecha_desde=" + fecha_desde + "&fecha_hasta=" + fecha_hasta, "_blank");
        }); 
    });
</script>
<?= GetDebugMessage() ?>
