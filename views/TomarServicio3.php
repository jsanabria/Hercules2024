<?php

namespace PHPMaker2024\hercules;

// Page object
$TomarServicio3 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Inicialización de variables de estado
$form_action_result = null; // null: Carga inicial (GET), true: Éxito (POST), false: Error (POST)
$success_message = "";
$error_message = "";

// Variables requeridas por ambos lados
$Norden = '';
$Nexpediente = '';
$proveedor = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --------------------------------------------------------------------------
    // A. Lógica de tomar_servicio3.php (Procesar Formulario)
    // --------------------------------------------------------------------------
    
    // Obtener datos de POST (Usando el operador de fusión de null para seguridad)
    $Norden = $_POST["Norden"] ?? '';
    $Nexpediente = $_POST["Nexpediente"] ?? '';
    $proveedor = $_POST["proveedor"] ?? '';
    $username = $_POST["username"] ?? '';
    $fecha_fin = $_POST["fecha_fin"] ?? ''; // Fecha en formato DD/MM/YYYY
    $servicio_atendido = $_POST["servicio_atendido"] ?? '';
    
    // Otros campos que podrían haberse enviado, aunque no se usen en el UPDATE:
    $nota_original = $_POST["nota_original"] ?? ''; // Campo oculto para conservar la nota
    
    // Conversión de formato de fecha (DD/MM/YYYY a YYYY-MM-DD para SQL)
    $ff = explode("/", $fecha_fin);
    if (count($ff) === 3) {
        $fecha_fin_sql = $ff[2]."-".$ff[1]."-".$ff[0]; // YYYY-MM-DD
    } else {
        $fecha_fin_sql = $fecha_fin;
    }
    
    // 1. VALIDACIÓN: La validación de tomar_servicio3.php solo comprueba la fecha futura
    $validation_sql = "
        SELECT 
            T1.Norden
        FROM 
            sco_orden AS T1 
        WHERE 
            T1.paso = '1' 
            AND STR_TO_DATE('" . AdjustSql($fecha_fin_sql) . " 00:00:00', '%Y-%m-%d %H:%i:%s') > NOW()
            AND T1.expediente = '" . AdjustSql($Nexpediente) . "'
        LIMIT 1"; 

    $is_date_valid = ExecuteRow($validation_sql); 
    
    // En tomar_servicio3.php original, $sw se usaba para determinar el éxito.
    // Si la consulta devuelve una fila, $sw es true, indicando que la fecha es futura y válida.
    $sw = ($is_date_valid !== false && $is_date_valid !== null);

    if ($sw) {
        // 2. ACTUALIZACIÓN: Ejecutar el UPDATE (Usando Execute)
        if ($servicio_atendido == "L") {
            // Caso: Liberar Servicio
            $update_sql = "
                UPDATE  
                    sco_orden 
                SET 
                    proveedor = '1', 
                    servicio_atendido = 'N' 
                WHERE 
                    Norden = '" . AdjustSql($Norden) . "'";
            $success_message = "El servicio ha sido liberado satisfactoriamente.";
        } else {
            // Caso: Asignar/Actualizar Servicio (sólo fecha y servicio_atendido)
            $update_sql = "
                UPDATE  
                    sco_orden 
                SET 
                    proveedor = '" . AdjustSql($proveedor) . "', 
                    fecha_fin = '" . AdjustSql($fecha_fin_sql) . "', 
                    servicio_atendido = '" . AdjustSql($servicio_atendido) . "'  
                WHERE 
                    Norden = '" . AdjustSql($Norden) . "'";
            $success_message = "Los datos del servicio han sido actualizados satisfactoriamente.";
        }
        
        $result = Execute($update_sql); 
        
        // Verificación de éxito de la actualización
        if ($result !== false) {
             $form_action_result = true; // Éxito
        } else {
             $form_action_result = false; // Error en la ejecución
             $error_message = "Error al intentar actualizar la base de datos.";
        }

    } else {
        // Error de Fechas/Validación (Fecha no es futura o expediente incorrecto)
        $form_action_result = false;
        $error_message = "Error: La fecha de fin del servicio debe ser una fecha futura.";
    }

} else {
    // --------------------------------------------------------------------------
    // B. Lógica de establece_datos3.php (Carga Inicial/GET)
    // --------------------------------------------------------------------------
    
    // Obtener datos de GET
    $proveedor = $_GET["proveedor"] ?? '';
    $Norden = $_GET["Norden"] ?? '';
    $username = $_GET["username"] ?? '';
    $Nexpediente = $_GET["Nexpediente"] ?? '';

    $form_action_result = null; // No hay resultado de acción de formulario
    
    // 1. CONSULTA PRINCIPAL: Obtener datos actuales del servicio (Usando ExecuteRow)
    $initial_sql = "
        SELECT 
            date_format(fecha_fin, '%d/%m/%Y') AS fecha_fin_display, 
            substring(hora_fin, 1, 5) AS hora_fin_display, 
            nota, 
            servicio_atendido,
            servicio 
        FROM 
            sco_orden 
        WHERE 
            Norden = '" . AdjustSql($Norden) . "'
        LIMIT 1";

    $row = ExecuteRow($initial_sql);

    // 2. Asignar variables para el formulario
    $fecha_fin = $row["fecha_fin_display"] ?? '';
    $servicio_atendido = $row["servicio_atendido"] ?? 'N';
    $nota_original = $row["nota"] ?? '';
    $servicio = $row["servicio"] ?? '';

    // 3. CONSULTA SECUNDARIA: Obtener nombre del medio (servicio)
    $medio_sql = "SELECT nombre as medio FROM sco_servicio WHERE Nservicio = '" . AdjustSql($servicio) . "' LIMIT 1";
    $medio_row = ExecuteRow($medio_sql);
    $medio = $medio_row["medio"] ?? '';

    // 4. PARSEO DE LA NOTA (similar a establece_datos3.php original)
    $nombre = $encabezado = $difunto = $texto = $pie = $facturar = $ci = $direccion = $telefono = $aviso = "";
    
    $arr1 = explode("---", $nota_original);
    $data_map = [
        0 => 'nombre', 1 => 'encabezado', 2 => 'difunto', 3 => 'texto', 
        4 => 'pie', 5 => 'facturar', 6 => 'ci', 7 => 'direccion', 
        8 => 'telefono', 9 => 'aviso'
    ];
    
    foreach ($arr1 as $i => $item) {
        if (isset($data_map[$i])) {
            $arr2 = explode("|", $item);
            if (count($arr2) > 1) {
                // Asigna dinámicamente el valor a la variable correspondiente
                ${$data_map[$i]} = trim($arr2[1]);
            }
        }
    }
}

// --------------------------------------------------------------------------------
// 3. PRESENTACIÓN HTML
// --------------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Establece Datos del Servicio</title>
    <!-- Incluir estilos y scripts de jQuery EasyUI -->
    <link rel="stylesheet" type="text/css" href="../jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="../jquery/demo/demo.css">
    <link rel="stylesheet" type="text/css" href="../jquery/themes/color.css">
    <script type="text/javascript" src="../jquery/jquery.js"></script>
    <script type="text/javascript" src="../jquery/jquery.easyui.js"></script>
    <script type="text/javascript" src="../jquery/locale/easyui-lang-es.js"></script>
</head>
<body>
    <?php if ($form_action_result === null): // Muestra el formulario en la carga inicial (GET) ?>
    <h2>Establezca y confirme fecha para prestar el servicio (Medio: <?php echo AdjustSql($medio); ?>)</h2>
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Datos del Servicio" style="width:100%;max-width:400px;padding:30px 60px;">
        <!-- El formulario apunta a sí mismo para el POST -->
        <form id="ff" method="post" action="TomarServicio3?proveedor=<?php echo urlencode($proveedor); ?>&Norden=<?php echo urlencode($Norden); ?>&Nexpediente=<?php echo urlencode($Nexpediente); ?>&username=<?php echo urlencode($username); ?>">
            
            <div style="margin-bottom:20px">
                <input class="easyui-datebox" label="Fecha del Servicio:" labelPosition="top" id="fecha_fin" name="fecha_fin" style="width:100%;" 
                       data-options="formatter:myformatter,parser:myparser,editable:false" 
                       value="<?php echo AdjustSql($fecha_fin); ?>" required>
            </div>
            
            <div style="margin-bottom:20px">
                <select class="easyui-combobox" label="Servicio Atendido:" labelPosition="top" id="servicio_atendido" name="servicio_atendido" panelHeight="auto" style="width:100%;" required>
                    <option value="N" <?php echo ($servicio_atendido=="N"?'selected':''); ?>>Servicio NO Atendido</option>
                    <option value="S" <?php echo ($servicio_atendido=="S"?'selected':''); ?>>Servicio SI Atendido</option>
                    <option value="L" <?php echo ($servicio_atendido=="L"?'selected':''); ?>>Liberar Servicio</option>
                </select> 
            </div>

            <div class="easyui-panel" title="Información Detallada (Nota)" data-options="collapsed:true, collapsible:true" style="padding:10px; margin-top: 20px;">
                <p><strong>Nombre:</strong> <?php echo AdjustSql($nombre); ?></p>
                <p><strong>Encabezado:</strong> <?php echo AdjustSql($encabezado); ?></p>
                <p><strong>Difunto:</strong> <?php echo AdjustSql($difunto); ?></p>
                <p><strong>Texto Esquela:</strong> <?php echo AdjustSql($texto); ?></p>
                <p><strong>Pie:</strong> <?php echo AdjustSql($pie); ?></p>
                <p><strong>Facturar:</strong> <?php echo AdjustSql($facturar); ?></p>
                <p><strong>CI:</strong> <?php echo AdjustSql($ci); ?></p>
                <p><strong>Dirección:</strong> <?php echo AdjustSql($direccion); ?></p>
                <p><strong>Teléfono:</strong> <?php echo AdjustSql($telefono); ?></p>
                <p><strong>Aviso:</strong> <?php echo AdjustSql($aviso); ?></p>
            </div>


            <input type="hidden" name="Norden" value="<?php echo AdjustSql($Norden); ?>">
            <input type="hidden" name="Nexpediente" value="<?php echo AdjustSql($Nexpediente); ?>">
            <input type="hidden" name="proveedor" value="<?php echo AdjustSql($proveedor); ?>"> 
            <input type="hidden" name="username" value="<?php echo AdjustSql($username); ?>">
            <input type="hidden" name="nota_original" value="<?php echo AdjustSql($nota_original); ?>"> <!-- Conservamos la nota original -->
            
            <div style="text-align:center;padding:15px 0 5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton c1" onclick="submitForm()" style="width:80px">Guardar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton c5" onclick="clearForm()" style="width:80px">Cancelar</a>
            </div>
        </form>
    </div>
    
    <?php elseif ($form_action_result === true): // Muestra el mensaje de éxito (POST) ?>
    <div class="easyui-panel" title="Resultado" style="width:100%;max-width:400px;padding:30px 60px; text-align:center;">
        <h2>Proceso Satisfactorio</h2>
        <p><?php echo $success_message; ?></p>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton c8" onclick="exitForm()" style="width:80px">Cerrar</a>
        </div>
    </div>
    
    <?php else: // Muestra el mensaje de error (POST) ?>
    <div class="easyui-panel" title="Resultado" style="width:100%;max-width:400px;padding:30px 60px; text-align:center;">
        <h2>Error en el Proceso</h2>
        <p><?php echo $error_message; ?></p>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton c5" onclick="exitForm()" style="width:80px">Cerrar</a>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Función para enviar el formulario (solo para la carga inicial)
        function submitForm(){
            $('#ff').submit();
        }
        
        // Función para cerrar la ventana/modal
        function exitForm(){
            // Recarga la ventana padre para refrescar la lista
            if (window.opener) {
                window.opener.location.reload();
            }
            // Intenta cerrar la ventana actual
            window.close();
        }
        
        // Función para cancelar y cerrar la ventana
        function clearForm(){
            exitForm();
        }

        // Funciones de formato y parseo de fecha para EasyUI (DD/MM/YYYY)
        function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+"/"+(m<10?('0'+m):m)+"/"+y;
        }
        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('/'));
            var d = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var y = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d); // Formato JS: AAAA, MM-1, DD
            } else {
                return new Date();
            }
        }
    </script>

<?= GetDebugMessage() ?>
