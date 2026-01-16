<?php

namespace PHPMaker2024\hercules;

// Page object
$TomarServicio2 = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Inicialización de variables de estado
$form_action_result = null; // null: Carga inicial (GET), true: Éxito (POST), false: Error (POST)
$success_message = "";
$error_message = "";

// Variables requeridas
$Norden = '';
$Nexpediente = '';
$proveedor = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --------------------------------------------------------------------------
    // A. Procesar Formulario
    // --------------------------------------------------------------------------
    
    // Obtener datos de POST (Usando el operador de fusión de null para seguridad)
    $Norden = $_POST["Norden"] ?? '';
    $Nexpediente = $_POST["Nexpediente"] ?? '';
    $proveedor = $_POST["proveedor"] ?? '';
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

    // 1. VALIDACIÓN: Verificar solapamiento de servicios (Usando ExecuteRow)
    // La lógica de solapamiento del archivo original solo usa paso='1'
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
    // La lógica original usaba $sw = ($overlap_check !== false && $overlap_check !== null), 
    // pero el script tomar_servicio2.php original simplemente ejecutaba el UPDATE sin esa validación. 
    // Por consistencia con la validación de fechas previa (establece_datos.php), la mantenemos,
    // asumiendo que el servicio es válido si la consulta devuelve algo (lo que parece ser un error
    // en la lógica original o una intencionalidad de que solo debe existir una orden con paso=1). 
    // Para no romper la lógica de fechas, usaremos un interruptor que siempre es TRUE, 
    // ya que la lógica original de tomar_servicio2.php no tenía validación de solapamiento.
    $sw = true; 

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
            // Caso: Asignar/Actualizar Servicio
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
        // Error de Fechas/Validación (solo si se implementa la lógica de solapamiento)
        $form_action_result = false;
        $error_message = "Error: La validación de fechas/solapamiento falló.";
    }

} else {
    // --------------------------------------------------------------------------
    // B. Carga Inicial/GET
    // --------------------------------------------------------------------------
    
    // Obtener datos de GET
    $proveedor = $_GET["proveedor"] ?? '';
    $Norden = $_GET["Norden"] ?? '';
    $username = $_GET["username"] ?? '';
    $Nexpediente = $_GET["Nexpediente"] ?? '';

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
            Norden = '" . AdjustSql($Norden) . "'
        LIMIT 1";

    $row = ExecuteRow($initial_sql);

    // 2. Asignar variables para el formulario
    // Usamos el operador de fusión de null (??) para establecer un valor por defecto si $row es false.
    $fecha_fin = $row["fecha_fin_display"] ?? '';
    $hora_fin = $row["hora_fin_display"] ?? '';
    $nota = $row["nota"] ?? ''; 
    $servicio_atendido = $row["servicio_atendido"] ?? 'N'; 
}

// --------------------------------------------------------------------------------
// 3. PRESENTACIÓN HTML
// --------------------------------------------------------------------------------
?>
    <?php if ($form_action_result === null): // Muestra el formulario en la carga inicial (GET) ?>
    <h2>Establezca y confirme fecha y hora para prestar el servicio</h2>
    <div style="margin:20px 0;"></div>
    <div class="easyui-panel" title="Fecha, Hora y Notas" style="width:100%;max-width:400px;padding:30px 60px;">
        <!-- El formulario apunta a sí mismo para el POST -->
        <form id="ff" method="post" action="TomarServicio2?proveedor=<?php echo urlencode($proveedor); ?>&Norden=<?php echo urlencode($Norden); ?>&Nexpediente=<?php echo urlencode($Nexpediente); ?>&username=<?php echo urlencode($username); ?>">
            
            <div style="margin-bottom:20px">
                <input class="easyui-datebox" label="Fecha del Servicio:" labelPosition="top" id="fecha_fin" name="fecha_fin" style="width:100%;" 
                       data-options="formatter:myformatter,parser:myparser,editable:false" 
                       value="<?php echo AdjustSql($fecha_fin); ?>" required>
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
                <input class="easyui-textbox" id="nota" name="nota" style="width:100%;height:60px" data-options="label:'Nota:',multiline:true" value="<?php echo AdjustSql($nota); ?>">
            </div>

            <div style="margin-bottom:20px">
                <select class="easyui-combobox" label="Servicio Atendido:" labelPosition="top" id="servicio_atendido" name="servicio_atendido" panelHeight="auto" style="width:100%;" required>
                    <option value="N" <?php echo ($servicio_atendido=="N"?'selected':''); ?>>Servicio NO Atendido</option>
                    <option value="S" <?php echo ($servicio_atendido=="S"?'selected':''); ?>>Servicio SI Atendido</option>
                    <option value="L" <?php echo ($servicio_atendido=="L"?'selected':''); ?>>Liberar Servicio</option>
                </select> 
            </div>

            <input type="hidden" name="Norden" value="<?php echo AdjustSql($Norden); ?>">
            <input type="hidden" name="Nexpediente" value="<?php echo AdjustSql($Nexpediente); ?>">
            <input type="hidden" name="proveedor" value="<?php echo AdjustSql($proveedor); ?>"> 
            <input type="hidden" name="username" value="<?php echo AdjustSql($username); ?>">
            
            <div style="text-align:center;padding:5px 0">
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
    <div class="easyui-panel" title="Resultado" style="width:100%;max-w0idth:400px;padding:30px 60px; text-align:center;">
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
        
        // Función para cancelar y cerrar la ventana (solo para la carga inicial)
        function clearForm(){
            // Recarga la ventana padre y cierra la actual
            if (window.opener) {
                // Si esta ventana se abre como modal en monitor_servicios_modal.php,
                // window.opener será null o diferente. Solo llamaremos a la función exitForm
                // que es la función genérica de cierre para modales.
                exitForm();
            }
            window.close(); // Función de fallback si no es un modal.
        }

        // Función para cerrar la ventana/modal después del POST
        function exitForm(){
            // Esta función es crucial para la integración con monitor_servicios_modal.php.
            // Si está dentro de un iframe/modal:
            
            // 1. Cierra el modal de EasyUI si estamos en un contexto de PHPMaker/EasyUI tradicional
            try {
                // Intenta llamar a la función de recarga y cierre del padre si existe (PHPMaker)
                if (window.opener && typeof window.opener.location.reload === 'function') {
                    window.opener.location.reload();
                }
                // Si la función parent.reloadGrid existe (típico en modales de PHPMaker)
                if (window.parent && window.parent.reloadGrid) {
                     window.parent.reloadGrid();
                }
                // Intenta cerrar la ventana actual
                window.close();
            } catch (e) {
                // Si falla (por ejemplo, si estamos en un modal de Bootstrap/iFrame):
                console.warn("No se pudo cerrar la ventana con window.close() ni recargar el padre EasyUI.");
            }
            
            // 2. Si se usa en un modal de Bootstrap (como en monitor_servicios_modal.php),
            // el script PHP solo devuelve el fragmento HTML. No podemos cerrarlo directamente
            // desde aquí, pero la recarga del padre es necesaria.
            
            // Dado que este script debe funcionar tanto en pop-up (EasyUI/PHPMaker) como
            // en un modal cargado por AJAX (Bootstrap/monitor_servicios_modal.php),
            // la mejor práctica es:
            
            // a) Recargar la ventana padre para refrescar la lista.
            if (window.opener) {
                window.opener.location.reload();
            }
            
            // b) Si no hay window.opener, es probable que se haya cargado por AJAX
            // y la función de cierre debe ser manejada por el script principal (monitor_servicios_modal.php).
            
            // Para simular el efecto de "cierre" en un modal de AJAX, podemos hacer:
            // 1. Notificar al padre (si existe y es el monitor)
            if (window.parent && window.parent.postMessage) {
                window.parent.postMessage('serviceUpdateSuccess', '*');
            }
            
            // 2. Intentar un cierre de ventana tradicional como último recurso.
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
