<?php

namespace PHPMaker2024\hercules;

// Page object
$TomarServicio = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Inicialización de variables de estado
$form_action_result = null; // null: Carga inicial (GET), true: Éxito (POST), false: Error (POST)
$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --------------------------------------------------------------------------
    // A. Procesar Formulario
    // --------------------------------------------------------------------------
    
    // Obtener datos de POST
    $proveedor = $_POST["proveedor"] ?? '';
    $Nexpediente = $_POST["Nexpediente"] ?? '';
    $username = $_POST["username"] ?? '';
    $fecha_fin = $_POST["fecha_fin"] ?? '';
    $hora_fin = $_POST["hora_fin"] ?? '';
    $nota = $_POST["nota"] ?? '';
    $servicio_atendido = $_POST["servicio_atendido"] ?? '';

    // Conversión de formato de fecha (DD/MM/YYYY a YYYY-MM-DD para SQL)
    $ff = explode("/", $fecha_fin);
    // Verificar que el array tenga 3 elementos para evitar errores
    if (count($ff) === 3) {
        $fecha_fin_sql = $ff[2]."-".$ff[1]."-".$ff[0]; // YYYY-MM-DD
    } else {
        // En caso de error de formato, asignamos el valor original o un valor seguro
        $fecha_fin_sql = $fecha_fin;
    }
    
    // --- PASO 0: OBTENER VALORES ANTIGUOS (rsold) PARA AUDITORÍA ---
    // Usamos ExecuteRow para obtener el registro actual (el que vamos a modificar).
    $old_data_sql = "
        SELECT 
            Norden, proveedor, fecha_fin, hora_fin, nota, servicio_atendido
        FROM 
            sco_orden 
        WHERE 
            expediente = " . AdjustSql($Nexpediente) . " 
            AND servicio_tipo = 'OFVO'
        LIMIT 1";
    $rsold = ExecuteRow($old_data_sql);

    // Si no se encuentra el registro, se detiene el proceso de POST
    if (!$rsold) {
        $form_action_result = false;
        $error_message = "Error: No se encontró el registro para el expediente " . HtmlEncode($Nexpediente) . ".";
        goto end_of_post_process; // Usamos goto para una salida limpia del bloque POST
    }

    // Normalizar datos de rsold para comparación (hora en formato HH:MM)
    $rsold["hora_fin"] = substr($rsold["hora_fin"], 0, 5); 
    $rsold["fecha_fin"] = date("Y-m-d", strtotime($rsold["fecha_fin"])); // Asegurar formato YYYY-MM-DD
    
    // Preparar nuevos valores (rsnew)
    // Los nuevos valores vienen del POST. Usamos el formato SQL para la fecha.
    $rsnew = [
        "proveedor" => $proveedor,
        "fecha_fin" => $fecha_fin_sql, 
        "hora_fin" => $hora_fin, 
        "nota" => $nota,
        "servicio_atendido" => $servicio_atendido,
        "Norden" => $rsold["Norden"] 
    ];

    // 1. VALIDACIÓN: Verificar solapamiento de servicios (Usando ExecuteRow)
    $validation_sql = "
        SELECT 
            T1.Norden
        FROM 
            sco_orden AS T1 
        WHERE 
            T1.paso = '1' AND
            STR_TO_DATE('" . AdjustSql($fecha_fin_sql) . " " . AdjustSql($hora_fin) . "', '%Y-%m-%d %H:%i:%s')
                BETWEEN 
                    STR_TO_DATE(CONCAT(DATE_FORMAT(T1.fecha_inicio, '%Y-%m-%d'), ' ', DATE_FORMAT(T1.hora_inicio, '%H:%i:%s')), '%Y-%m-%d %H:%i:%s') 
                AND 
                    STR_TO_DATE(CONCAT(DATE_FORMAT(T1.fecha_fin, '%Y-%m-%d'), ' ', DATE_FORMAT(T1.hora_fin, '%H:%i:%s')), '%Y-%m-%d %H:%i:%s')  
            AND T1.expediente = '" . AdjustSql($Nexpediente) . "'
        ORDER BY STR_TO_DATE(CONCAT(DATE_FORMAT(T1.fecha_fin, '%Y-%m-%d'), ' ', DATE_FORMAT(T1.hora_fin, '%H:%i:%s')), '%Y-%m-%d %H:%i:%s') DESC LIMIT 1"; 

    $overlap_check = ExecuteRow($validation_sql); 
    $sw = ($overlap_check !== false && $overlap_check !== null); // sw es true si NO hay solapamiento (o si la lógica original lo permite)

    if ($sw) {
        // 2. ACTUAlIZACIÓN: Ejecutar el UPDATE (Usando Execute)
        $log_fields = [];
        $keyvalue_log = $Nexpediente; // Usamos el expediente como clave

        if ($servicio_atendido == "L") {
            // Caso: Liberar Servicio (valores fijos)
            $update_sql = "
                UPDATE  
                    sco_orden 
                SET 
                    proveedor = '1', 
                    servicio_atendido = 'N'  
                WHERE 
                    expediente = '" . AdjustSql($Nexpediente) . "' 
                    AND paso = '5' 
                    AND servicio_tipo = 'OFVO'";
            $success_message = "El servicio ha sido liberado satisfactoriamente.";

            // Log: proveedor
            if ($rsold["proveedor"] != '1') {
                addAuditTrail("UPDATE", "sco_orden", "proveedor", $keyvalue_log, $rsold["proveedor"], '1');
            }
            
            // Log: servicio_atendido (su 'estatus')
            if ($rsold["servicio_atendido"] != 'N') {
                addAuditTrail("UPDATE", "sco_orden", "servicio_atendido", $keyvalue_log, $rsold["servicio_atendido"], 'N');
            }

        } else {
            // Caso: Asignar/Actualizar Servicio (valores de POST)
            $update_sql = "
                UPDATE  
                    sco_orden 
                SET 
                    proveedor = '" . AdjustSql($proveedor) . "', 
                    fecha_fin = '" . AdjustSql($fecha_fin_sql) . "', 
                    hora_fin = '" . AdjustSql($hora_fin) . "', 
                    nota = '" . AdjustSql($nota) . "',
                    servicio_atendido = '" . AdjustSql($servicio_atendido) . "'  
                WHERE 
                    expediente = '" . AdjustSql($Nexpediente) . "' 
                    AND paso = '5' 
                    AND servicio_tipo = 'OFVO'";
            $success_message = "Los datos del servicio han sido actualizados satisfactoriamente.";
            
            // --- REGISTRO DE BITÁCORA CAMPO POR CAMPO ---
            // Log: proveedor
            if ($rsold["proveedor"] != $rsnew["proveedor"]) {
                addAuditTrail("UPDATE", "sco_orden", "proveedor", $keyvalue_log, $rsold["proveedor"], $rsnew["proveedor"]);
            }
            
            // Log: fecha_fin
            if ($rsold["fecha_fin"] != $rsnew["fecha_fin"]) {
                addAuditTrail("UPDATE", "sco_orden", "fecha_fin", $keyvalue_log, $rsold["fecha_fin"], $rsnew["fecha_fin"]);
            }

            // Log: hora_fin
            if ($rsold["hora_fin"] != $rsnew["hora_fin"]) {
                addAuditTrail("UPDATE", "sco_orden", "hora_fin", $keyvalue_log, $rsold["hora_fin"], $rsnew["hora_fin"]);
            }

            // Log: nota
            if ($rsold["nota"] != $rsnew["nota"]) {
                addAuditTrail("UPDATE", "sco_orden", "nota", $keyvalue_log, $rsold["nota"], $rsnew["nota"]);
            }

            // Log: servicio_atendido (su 'estatus')
            if ($rsold["servicio_atendido"] != $rsnew["servicio_atendido"]) {
                // NOTA: Si el campo en DB se llama 'estatus' en lugar de 'servicio_atendido',
                // reemplace "servicio_atendido" por "estatus" en esta línea.
                addAuditTrail("UPDATE", "sco_orden", "servicio_atendido", $keyvalue_log, $rsold["servicio_atendido"], $rsnew["servicio_atendido"]);
            }
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
        // Error de Fechas/Validación (lógica de solapamiento fallida)
        $form_action_result = false;
        $error_message = "Error: La validación de fechas/solapamiento falló.";
    }

} else {
    // --------------------------------------------------------------------------
    // B. Carga Inicial/GET
    // --------------------------------------------------------------------------
    
    // Obtener datos de GET
    $proveedor = $_GET["proveedor"] ?? '';
    $Nexpediente = $_GET["Nexpediente"] ?? '';
    $username = $_GET["username"] ?? '';

    $form_action_result = null; // No hay resultado de acción de formulario
    
    // 1. CONSULTA: Obtener datos actuales del servicio (Usando ExecuteRow)
    $initial_sql = "
        SELECT 
            date_format(fecha_fin, '%d/%m/%Y') AS fecha_fin_display, 
            substring(hora_fin, 1, 5) AS hora_fin_display, 
            nota, 
            servicio_atendido 
        FROM 
            sco_orden 
        WHERE 
            expediente = '" . AdjustSql($Nexpediente) . "' 
            AND servicio_tipo = 'OFVO'
        LIMIT 1";

    $row = ExecuteRow($initial_sql);

    // 2. Asignar variables para el formulario
    // Usamos el operador de fusión de null (??) para establecer un un valor por defecto si $row es false.
    $fecha_fin = $row["fecha_fin_display"] ?? '';
    $hora_fin = $row["hora_fin_display"] ?? '';
    $nota = $row["nota"] ?? ''; 
    $servicio_atendido = $row["servicio_atendido"] ?? 'N'; 
}

// Etiqueta para la salida limpia del bloque POST
end_of_post_process:

// --------------------------------------------------------------------------------
// 3. PRESENTACIÓN HTML
// --------------------------------------------------------------------------------
?>
    <?php if ($form_action_result === null): // Muestra el formulario en la carga inicial (GET) ?>
    <h2>Establezca y confirme fecha y hora para prestar el servicio</h2>
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Fecha, Hora y Notas" style="width:100%;max-width:400px;padding:30px 60px;">
        <!-- El formulario apunta a sí mismo para el POST -->
        <form id="ff" method="post" action="TomarServicio?proveedor=<?php echo urlencode($proveedor); ?>&Nexpediente=<?php echo urlencode($Nexpediente); ?>&username=<?php echo urlencode($username); ?>">
            
            <div style="margin-bottom:20px">
                <input class="easyui-datebox" label="Fecha del Servicio:" labelPosition="top" id="fecha_fin" name="fecha_fin" style="width:100%;" 
                       data-options="formatter:myformatter,parser:myparser,editable:false" 
                       value="<?php echo HtmlEncode($fecha_fin); ?>" required>
            </div>
            <div style="margin-bottom:20px">
                <select class="easyui-combobox" label="Hora del Servicio:" labelPosition="top" id="hora_fin" name="hora_fin" style="width:100%;" required>
                    <?php
                    for($i=6; $i<22; $i++) {
                        $hr = str_pad($i, 2, "0", STR_PAD_LEFT).":00";
                        // Compara solo la hora (ej: 09:00) con la hora de la DB (ej: 09:00)
                        $selected_hr = substr($hora_fin,0,5);
                        echo '<option value="'.$hr.'" '.($hr==$selected_hr?'selected="selected"':'').'>' . date("g:ia", strtotime(date("Y-m-d") . " " . $hr . ":00")) . '</option>';
                        
                        $hr = str_pad($i, 2, "0", STR_PAD_LEFT).":30";
                        echo '<option value="'.$hr.'" '.($hr==$selected_hr?'selected="selected"':'').'>' . date("g:ia", strtotime(date("Y-m-d") . " " . $hr . ":30")) . '</option>';
                    }
                    ?>
                </select> 
            </div>
            <div style="margin-bottom:20px">
                <input class="easyui-textbox" id="nota" name="nota" style="width:100%;height:60px" data-options="label:'Nota:',multiline:true" value="<?php echo HtmlEncode($nota); ?>">
            </div>

            <div style="margin-bottom:20px">
                <select class="easyui-combobox" label="Servicio Atendido:" labelPosition="top" id="servicio_atendido" name="servicio_atendido" panelHeight="auto" style="width:100%;" required>
                    <option value="N" <?php echo ($servicio_atendido=="N"?'selected':''); ?>>Servicio NO Atendido</option>
                    <option value="S" <?php echo ($servicio_atendido=="S"?'selected':''); ?>>Servicio SI Atendido</option>
                    <option value="L" <?php echo ($servicio_atendido=="L"?'selected':''); ?>>Liberar Servicio</option>
                </select> 
            </div>

            <input type="hidden" name="Nexpediente" value="<?php echo HtmlEncode($Nexpediente); ?>"> 
            <input type="hidden" name="proveedor" value="<?php echo HtmlEncode($proveedor); ?>"> 
            <input type="hidden" name="username" value="<?php echo HtmlEncode($username); ?>">
            
            <div style="text-align:center;padding:5px 0">
                <a href="javascript:void(0)" class="easyui-linkbutton c1" onclick="submitForm()" style="width:80px">Guardar</a>
                <a href="javascript:void(0)" class="easyui-linkbutton c5" onclick="clearForm()" style="width:80px">Cancelar</a>
            </div>
        </form>
    </div>
    
    <?php elseif ($form_action_result === true): // Muestra el mensaje de éxito (POST) ?>
    <div class="easyui-panel" title="Resultado" style="width:100%;max-width:400px;padding:30px 60px; text-align:center;">
        <h2>Proceso Satisfactorio</h2>
        <p><?php echo HtmlEncode($success_message); ?></p>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton c8" onclick="exitForm()" style="width:80px">Cerrar</a>
        </div>
    </div>
    
    <?php else: // Muestra el mensaje de error (POST) ?>
    <div class="easyui-panel" title="Resultado" style="width:100%;max-wixdth:400px;padding:30px 60px; text-align:center;">
        <h2>Error en el Proceso</h2>
        <p><?php echo HtmlEncode($error_message); ?></p>
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
        
        // Función para cancelar y cerrar la ventana (solo para la carga inicial)
        function clearForm(){
            // Recarga la ventana padre y cierra la actual
            if (window.opener) {
                window.opener.location.reload();
            }
            window.close();
        }

        // Función para cerrar la ventana después del POST
        function exitForm(){
            // Recarga la ventana padre y cierra la actual
            if (window.opener) {
                window.opener.location.reload();
            }
            window.close();
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
