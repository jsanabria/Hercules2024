<?php

include 'includes/conexBD.php'; // Assume this file establishes $link for mysqli connection

// --- Helper Functions (Potentially moved to a separate 'helpers.php' file) ---

/**
 * Formats a date string to a more readable format in Spanish.
 * @param string $fecha Date in "dd/mm/yyyy" format.
 * @return string Formatted date string (e.g., "Miércoles, 17 de Julio de 2024").
 */
function formatear_fecha($fecha) {
    // Using DateTime object for robust date handling
    $date = DateTime::createFromFormat('d/m/Y', $fecha);
    if (!$date) {
        return "Fecha inválida";
    }

    // Set locale for Spanish date formatting (requires intl extension)
    // Fallback to manual arrays if intl is not available or desired
    if (extension_loaded('intl')) {
        $formatter = new IntlDateFormatter(
            'es_ES',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Caracas', // Or your specific timezone
            IntlDateFormatter::GREGORIAN,
            "EEEE, dd 'de' MMMM 'de' yyyy"
        );
        return $formatter->format($date);
    } else {
        $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $dayOfWeek = (int)$date->format('w'); // 0 for Sunday, 6 for Saturday
        $monthOfYear = (int)$date->format('n') - 1; // 0 for January, 11 for December

        return $dias[$dayOfWeek] . ", " . $date->format('d') . " de " . $meses[$monthOfYear] . " de " . $date->format('Y');
    }
}

// --- Input Handling and Initialization ---
$Nexpediente = isset($_REQUEST["Nexpediente"]) ? (int)$_REQUEST["Nexpediente"] : 0;
$user = $_GET["username"] ?? ''; // Use null coalescing operator for cleaner code
$servicio_tipo = isset($_REQUEST["servicio_tipo"]) ? $_REQUEST["servicio_tipo"] : "CAP0";
$fecha_inicio = isset($_REQUEST["fecha_inicio"]) ? $_REQUEST["fecha_inicio"] : date("d/m/Y");

// Fetch user's reservation permission
$reserva = "N"; // Default
if (!empty($user)) {
    $sql_user_level = "SELECT a.reserva FROM userlevels a JOIN sco_user b ON b.`level` = a.userlevelid WHERE b.username = ?;";
    if ($stmt_user_level = $link->prepare($sql_user_level)) {
        $stmt_user_level->bind_param("s", $user);
        $stmt_user_level->execute();
        $stmt_user_level->bind_result($reserva);
        $stmt_user_level->fetch();
        $stmt_user_level->close();
    } else {
        die("<div class='alert alert-danger' role='alert'>Error al preparar la consulta de nivel de usuario: " . $link->error . "</div>");
    }
}

// Prepare date for database queries
$db_fecha_inicio = DateTime::createFromFormat('d/m/Y', $fecha_inicio)->format('Y-m-d');

// --- Fetch all necessary data for chapel services and reservations in advance ---

$capilla_data = []; // Stores Nservicio and capilla names
$nomnbre_capilla = ""; // Stores the name of the currently selected chapel type
// $sql_capillas_tipos = "SELECT Nservicio_tipo, nombre as capillas FROM sco_servicio_tipo WHERE substring(Nservicio_tipo,1,3) = 'CAP' ORDER BY capillas asc";
$sql_capillas_tipos = "SELECT 
                            DISTINCT a.Nservicio_tipo, a.nombre as capillas 
                        FROM 
                            sco_servicio_tipo AS a 
                            JOIN sco_servicio AS b ON b.tipo = a.Nservicio_tipo AND b.activo = 'S' 
                        WHERE SUBSTRING(a.Nservicio_tipo,1,3) = 'CAP' ORDER BY capillas asc;";
if ($stmt_capillas_tipos = $link->prepare($sql_capillas_tipos)) {
    $stmt_capillas_tipos->execute();
    $stmt_capillas_tipos->bind_result($Nservicio_tipo_res, $capillas_res);
    while ($stmt_capillas_tipos->fetch()) {
        $capilla_data[$Nservicio_tipo_res] = $capillas_res;
        if ($Nservicio_tipo_res == $servicio_tipo) {
            $nomnbre_capilla = $capillas_res;
        }
    }
    $stmt_capillas_tipos->close();
} else {
    die("<div class='alert alert-danger' role='alert'>Error al preparar la consulta de tipos de capilla: " . $link->error . "</div>");
}

$service_chapels = []; // Stores Nservicio and capilla name for active services of the selected type
$cp = []; // Array to store Nservicio for the columns
$sql_active_services = "SELECT Nservicio, nombre as capilla FROM sco_servicio WHERE tipo = ? AND activo = 'S' ORDER BY secuencia asc;";
if ($stmt_active_services = $link->prepare($sql_active_services)) {
    $stmt_active_services->bind_param("s", $servicio_tipo);
    $stmt_active_services->execute();
    $stmt_active_services->bind_result($Nservicio_res, $capilla_name_res);
    while ($stmt_active_services->fetch()) {
        $service_chapels[$Nservicio_res] = $capilla_name_res;
        $cp[] = $Nservicio_res;
    }
    $stmt_active_services->close();
} else {
    die("<div class='alert alert-danger' role='alert'>Error al preparar la consulta de servicios activos: " . $link->error . "</div>");
}

$chapillas = count($cp); // Number of chapel service columns

// Fetch all existing orders (expediente reservations) for the selected date and service type
$existing_orders = [];
$sql_orders = "SELECT
                    expediente.Nexpediente,
                    CONCAT(expediente.nombre_fallecido, ' ',  expediente.apellidos_fallecido) as difunto,
                    orden.Norden,
                    orden.servicio,
                    orden.fecha_inicio,
                    orden.fecha_fin,
                    expediente.unir_con_expediente
                FROM
                    sco_orden as orden
                    JOIN sco_expediente as expediente ON expediente.Nexpediente = orden.expediente
                WHERE
                    orden.paso = '1'
                    AND orden.servicio IN (" . str_repeat('?,', count($cp) - 1) . "?)
                    AND ? BETWEEN DATE(orden.fecha_inicio) AND DATE(orden.fecha_fin + INTERVAL 1 MINUTE);"; 

if ($chapillas > 0 && $stmt_orders = $link->prepare($sql_orders)) {
    $types = str_repeat('s', count($cp)) . 's'; // 's' for each service ID and one 's' for date
    $params = array_merge($cp, [$db_fecha_inicio]);
    $stmt_orders->bind_param($types, ...$params);
    $stmt_orders->execute();
    $result_orders = $stmt_orders->get_result();
    while ($row = $result_orders->fetch_assoc()) {
        $start_dt = new DateTime($row['fecha_inicio']);
        $end_dt = new DateTime($row['fecha_fin']);
        $interval = new DateInterval('PT30M');
        $period = new DatePeriod($start_dt, $interval, $end_dt->modify('+1 minute')); // +1 minute to include the end 30 min slot

        foreach ($period as $dt) {
            $hour_slot = $dt->format('H:i');
            $existing_orders[$row['servicio']][$hour_slot] = [
                'Nexpediente' => $row['Nexpediente'],
                'difunto' => $row['difunto'],
                'Norden' => $row['Norden'],
                'unir_con_expediente' => $row['unir_con_expediente']
            ];
        }
    }
    $stmt_orders->close();
}


// Fetch all existing general reservations for the selected date and chapel types
$existing_reservations = [];
$sql_reservations = "SELECT Nreserva, username, capilla, DATE_FORMAT(hora, '%H:%i') AS hora FROM sco_reserva WHERE capilla IN (" . str_repeat('?,', count($cp) - 1) . "?) AND fecha = ?;";
if ($chapillas > 0 && $stmt_reservations = $link->prepare($sql_reservations)) {
    $types_res = str_repeat('s', count($cp)) . 's';
    $params_res = array_merge($cp, [$db_fecha_inicio]);
    $stmt_reservations->bind_param($types_res, ...$params_res);
    $stmt_reservations->execute();
    $result_reservations = $stmt_reservations->get_result();
    while ($row = $result_reservations->fetch_assoc()) {
        $existing_reservations[$row['capilla']][$row['hora']] = [
            'Nreserva' => $row['Nreserva'],
            'username' => $row['username']
        ];
    }
    $stmt_reservations->close();
}


/**
 * Determines availability based on pre-fetched data.
 * @param array $existing_orders Pre-fetched order data.
 * @param array $existing_reservations Pre-fetched reservation data.
 * @param string $current_hour The hour slot (e.g., "08:00", "08:30").
 * @param string $current_capilla The Nservicio of the current chapel.
 * @return string Formatted string for availability display.
 */
function get_availability_data($existing_orders, $existing_reservations, $current_hour, $current_capilla) {
    // Check for existing order (expediente reservation) first
    if (isset($existing_orders[$current_capilla][$current_hour])) {
        $order_data = $existing_orders[$current_capilla][$current_hour];
        $difunto = $order_data['difunto'];
        $xNexpediente = $order_data['Nexpediente'];
        $xNorden = $order_data['Norden'];

        $disp_class = 'lunch';
        $content_html = '<div class="item assigned2">';
        $content_html .= '<b>' . $difunto;
        if ($order_data['unir_con_expediente'] != 0) {
             $content_html .= ' (compartido)';
        }
        $content_html .= '<br /><a href="../Asistencia?Nexpediente=' . $xNexpediente . '&Norden=' . $xNorden . '" target="_blank">(Exp: ' . $xNexpediente . ')</a></b></div>';
        $id_value = '';
        return $disp_class . ';' . $content_html . ';' . $id_value;

    } else if (isset($existing_reservations[$current_capilla][$current_hour])) {
        // Check for general reservation
        $reservation_data = $existing_reservations[$current_capilla][$current_hour];
        $Nreserva = $reservation_data['Nreserva'];
        $username_res = $reservation_data['username'];
        $disp_class = 'drop';
        $content_html = '<div class="item assigned">Reservado ' . $username_res . '<br />*' . $Nreserva  . '*</div>';
        $id_value = $Nreserva;
        return $disp_class . ';' . $content_html . ';' . $id_value;
    } else {
        // Available
        return 'drop;;'; // Class; content; ID
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Disponibilidad de Capillas</title>
    <link rel="stylesheet" type="text/css" href="jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="jquery/demo/demo.css">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="jquery/locale/easyui-lang-es.js"></script>
    <style type="text/css">
        .left{
            width:150px;
            float:left;
        }
        .left table{
            background:#E0ECFF;
        }
        .left td{
            background:#eee;
        }
        .right{
            float:right;
            width:620px;
        }
        .right table{
            background:#E0ECFF;
            width:35%; /* This might be too small, review the original intent or adjust */
        }
        .right td{
            background:#fafafa;
            color:#444;
            text-align:center;
            padding:2px;
        }
        .right td{
            background:#E0ECFF; /* Overwrites previous background */
        }
        .right td.drop{
            background:#fafafa;
            width:100px;
        }
        .right td.over{
            background:#FBEC88;
        }
        .item{
            text-align:center;
            border:1px solid #499B33;
            background:#FFFFCC;
            color:#444;
            width:160px;
        }
        .assigned{
            border:1px solid #BC2A4D;
            background:#99CC99;
        }
        .assigned2{
            border:1px solid #BC2A4D;
            background:#FFFFCC;
        }
        .trash{
            background-color:red;
        }

        #info_pag {
            background:transparent url(images/logoheader.PNG) no-repeat;
            position: fixed;
            overflow:hidden;
            /*--añade lo que necesites--*/
        }
    </style>
</head>
<body>
    <div id="tt" class="easyui-tabs" style="width:100%;height:600px">
        <div title="Disponibilidad de Capilla" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:800px;">
                <div class="left">
                    <div style="margin-bottom:20px">
                        <label>Capilla:</label>
                        <select class="easyui-combobox" id="servicio_tipo" name="servicio_tipo" label="Capillas:" labelPosition="top" style="width:100%;" data-options="editable:false, panelHeight:'auto'">
                            <?php
                            foreach ($capilla_data as $nserv_tipo => $name) {
                                $selected = ($nserv_tipo == $servicio_tipo) ? 'selected="selected"' : '';
                                echo '<option value="' . htmlspecialchars($nserv_tipo) . '" ' . $selected . '>' . htmlspecialchars($name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div style="margin-bottom:20px">
                        <label>Fecha:</label>
                        <input id="fecha_inicio" name="fecha_inicio" label="Select Date:" labelPosition="top" style="width:100%;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                    </div>
                    <div style="margin-bottom:20px">
                        <a href="../ScoReservaList" target="_parent" id="eliminarReservas" class="easyui-linkbutton" data-options="iconCls:'icon-save'"  style="width:100%;">Eliminar reservas</a>
                    </div>
                    <br />
                    <div style="margin-bottom:20px">
                        <br /><br /><br /><br />
                    </div>
                    <?php for($i=1; $i<=12; $i++) echo "<br />"; ?>

                    <br />
                    <br />
                    <br />
                    <div id="info_pag" style="margin-bottom:20px">
                        <a href="PizarraServicios.php?username=<?php echo htmlspecialchars($user); ?>" target="_blank" id="xPizarra" class="easyui-linkbutton" data-options="iconCls:'icon-reload'" style="width:100%;">Ver Pizarra</a>
                    <?php if($reserva=="N") { ?>
                        <br>
                        <label><center>Arrastre para Reservar:</center></label>
                        <table>
                            <tr>
                                <td><div class="item">Reservado<br />&nbsp;</div></td>
                            </tr>
                        </table>
                    <?php } else { ?>
                        <br>
                        <label><center>Disponibilidad de Capillas</center></label>
                    <?php } ?>
                    </div>
                </div>

                <div class="right">
                    <div id="fecha"><b><?php echo strtoupper(formatear_fecha($fecha_inicio)) . " <i>(" . htmlspecialchars($nomnbre_capilla) . ")</i>"; ?></b></div>
                    <table>
                        <tr>
                            <td class="blank"></td>
                            <?php
                            foreach ($service_chapels as $nservicio => $capilla_name) {
                                echo '<td class="title">' . htmlspecialchars($capilla_name) . '</td>';
                            }
                            ?>
                        </tr>
                        <?php
                        $ii = 6; // Start hour
                        $jj = 23; // End hour (exclusive)

                        for($i=$ii; $i<$jj; $i++) {
                            // Full hour slot
                            $hr_full = str_pad($i, 2, "0", STR_PAD_LEFT).":00";
                            $display_hr_full = date("g:ia", strtotime(date("Y-m-d") . " " . $hr_full));
                            ?>
                            <tr>
                                <td class="time"> <?php echo $display_hr_full; ?></td>
                                <?php
                                for($j=0; $j<$chapillas; $j++) {
                                    $current_capilla_id = $cp[$j];
                                    $data = explode(";", get_availability_data($existing_orders, $existing_reservations, $hr_full, $current_capilla_id));
                                    echo '<td class="'.htmlspecialchars($data[0]).'" id="xy|'.htmlspecialchars($hr_full).'|'.htmlspecialchars($current_capilla_id).'|'.(isset($data[2]) ? htmlspecialchars($data[2]) : '-1').'">'.(isset($data[1]) ? $data[1] : '').'</td>';
                                }
                                ?>
                                <td class="time"> <?php echo $display_hr_full; ?></td>
                            </tr>
                            <?php
                            // Half-hour slot
                            $hr_half = str_pad($i, 2, "0", STR_PAD_LEFT).":30";
                            $display_hr_half = date("g:ia", strtotime(date("Y-m-d") . " " . $hr_half));
                            ?>
                            <tr>
                                <td class="time"> <?php echo $display_hr_half; ?></td>
                                <?php
                                for($j=0; $j<$chapillas; $j++) {
                                    $current_capilla_id = $cp[$j];
                                    $data = explode(";", get_availability_data($existing_orders, $existing_reservations, $hr_half, $current_capilla_id));
                                    echo '<td class="'.htmlspecialchars($data[0]).'" id="xy|'.htmlspecialchars($hr_half).'|'.htmlspecialchars($current_capilla_id).'|'.(isset($data[2]) ? htmlspecialchars($data[2]) : '-1').'">'.(isset($data[1]) ? $data[1] : '').'</td>';
                                }
                                ?>
                                <td class="time"> <?php echo $display_hr_half; ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#qs').val("NO"); // This element doesn't seem to exist in the HTML, might be for another script.
            $('#tt').tabs({
                pill: true,
                justified: true
            });
        });

        function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return (d<10?('0'+d):d)+"/"+(m<10?('0'+m):m)+"/"+y;
        }

        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('/'));
            var d = parseInt(ss[0],10); // Day
            var m = parseInt(ss[1],10); // Month
            var y = parseInt(ss[2],10); // Year
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d); // Correct order for Date constructor (Year, Month-1, Day)
            } else {
                return new Date();
            }
        }

        $('#servicio_tipo').combobox({
            onChange:function(newValue,oldValue) {
                // Use a proper URL parameter for the current date
                var current_fecha_inicio = $('#fecha_inicio').datebox('getValue');
                var url = "DisponibilidadCapillas.php?username=<?php echo htmlspecialchars($user); ?>&servicio_tipo="+encodeURIComponent(newValue)+"&fecha_inicio="+encodeURIComponent(current_fecha_inicio);
                window.location.href = url;
            }
        });

        $('#fecha_inicio').datebox({
            onSelect: function(date) {
                var date_new_str = myformatter(date); // Format the date to "dd/mm/yyyy"
                var current_servicio_tipo = $('#servicio_tipo').combobox('getValue');
                var url = "DisponibilidadCapillas.php?username=<?php echo htmlspecialchars($user); ?>&servicio_tipo="+encodeURIComponent(current_servicio_tipo)+"&fecha_inicio="+encodeURIComponent(date_new_str);
                window.location.href = url;
            }
        });

        // Drag and Drop Logic
        $(function(){
            $('.left .item').draggable({
                revert:true,
                proxy:'clone',
                onDrag:function(e){
                    this.x = e.pageX;
                    this.y = e.pageY;
                }
            });

            $('.right td.drop').droppable({
                accept: '.item',
                onDragEnter:function(){
                    $(this).addClass('over');
                },
                onDragLeave:function(){
                    $(this).removeClass('over');
                },
                onDrop:function(e,source){
                    $(this).removeClass('over');
                    var targetCell = $(this);
                    var currentContent = targetCell.text().trim(); // Get current text, trim whitespace

                    // Logic to handle existing reservation in target cell
                    var existingReservationId = -1;
                    var match = currentContent.match(/\*(\d+)\*/);
                    if (match && match[1]) {
                        existingReservationId = match[1];
                    }

                    // If dropping an existing assigned item from another cell (moving a reservation)
                    if ($(source).hasClass('assigned') || $(source).hasClass('assigned2')) {
                        // Original element being dragged (potentially from another cell)
                        var sourceCellId = $(source).parent().attr('id'); // Get the ID of the source TD
                        var sourceData = sourceCellId ? sourceCellId.split('|') : null;
                        var sourceReservationId = (sourceData && sourceData[3] != '-1') ? sourceData[3] : null;

                        // Remove from original position if it's a move
                        if (sourceCellId) {
                            $('#' + sourceCellId).empty().removeClass('assigned assigned2').addClass('drop');
                            // alert("PASO");
                            // If it was a reservation, send AJAX to delete it
                            if (sourceReservationId && sourceReservationId !== '-1') {
                                $.ajax({
                                    url: "ActualizaReserva.php",
                                    type: "GET",
                                    data: { id: sourceReservationId, action: 'delete' }, // Add an action parameter
                                    success: function(result){
                                        console.log("Deleted old reservation: ", result);
                                    }
                                });
                            }
                        }
                    }

                    // Add the dragged item to the new cell
                    var draggedItem = $(source).clone().addClass('assigned'); // Assuming all drops become 'assigned'
                    targetCell.empty().append(draggedItem);
                    draggedItem.draggable({
                        revert:true
                    });

                    // Update the ID of the target cell to reflect the new reservation ID, if any
                    var newId = (existingReservationId !== -1) ? existingReservationId : -1; // If it was already reserved, keep its ID

                    // Send AJAX to update/create reservation
                    var targetId = targetCell.attr("id");
                    var datos = targetId.split("|");
                    var horas = datos[1];
                    var servicio = datos[2];
                    // The `id` in the original script was `datos[3]`, which was `Nreserva` if it existed, otherwise `-1`.
                    // We need to pass the *newly created* Nreserva back to the client or update the element ID after success.
                    // For now, `newId` is based on if the target *already* had a reservation.
                    // If it's a *new* reservation (dragging from 'Reservado' item, id=-1), then `actualiza_reserva.php` should return the new ID.

                    $.ajax({
                        url: "ActualizaReserva.php",
                        type: "GET",
                        data: {
                            id: newId, // This might be -1 if a new reservation
                            servicio: servicio,
                            username: "<?php echo htmlspecialchars($user); ?>",
                            fecha: "<?php echo htmlspecialchars($fecha_inicio); ?>",
                            horas: horas,
                            action: 'update_or_create' // Indicate action
                        },
                        success: function(result){
                            console.log("Reservation update/create result: ", result);
                            // Assuming 'actualiza_reserva.php' returns the new Nreserva or a confirmation.
                            // If it returns the Nreserva for a *new* reservation, update the cell's ID.
                            // Example: result could be 'OK|NEW_NRESERVA_ID'
                            // alert(result);
                            var rs = result.split("|");
                            if (rs[0] === "OK" && rs[1]) {
                                // Update the ID of the cell with the new reservation ID
                                var updatedId = datos[0] + '|' + datos[1] + '|' + datos[2] + '|' + rs[1];
                                // alert(updatedId);
                                targetCell.attr('id', updatedId);
                                // Also update the content to show the new ID
                                draggedItem.html(draggedItem.html().replace(/\*\-1\*/, '*' + rs[1] + '*'));
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: ", status, error);
                            alert("Error al actualizar la reserva.");
                        }
                    });
                }
            });

            $('.left').droppable({
                accept:'.assigned, .assigned2', // Accept both types to be "trashed"
                onDragEnter:function(e,source){
                    $(source).addClass('trash');
                },
                onDragLeave:function(e,source){
                    $(source).removeClass('trash');
                },
                onDrop:function(e,source){
                    var droppedItemId = $(source).parent().attr('id'); // Get the ID of the TD holding the item
                    var dataParts = droppedItemId.split('|');
                    var reservationIdToDelete = dataParts[3]; // The Nreserva or -1

                    $(source).remove(); // Remove the visual item

                    // If it was a reservation (not -1), send an AJAX call to delete it
                    if (reservationIdToDelete && reservationIdToDelete !== '-1') {
                        $.ajax({
                            url: "actualiza_reserva.php",
                            type: "GET",
                            data: { id: reservationIdToDelete, action: 'delete' }, // Add an action parameter
                            success: function(result){
                                console.log("Reservation deleted: ", result);
                                // After successful deletion, reset the cell's class and content
                                $('#' + droppedItemId).empty().removeClass('assigned assigned2 lunch').addClass('drop').attr('id', dataParts[0] + '|' + dataParts[1] + '|' + dataParts[2] + '|-1');
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX Error during delete: ", status, error);
                                alert("Error al eliminar la reserva.");
                            }
                        });
                    } else {
                        // If it was not a reservation, just clear the cell content and revert its ID state
                        $('#' + droppedItemId).empty().removeClass('assigned assigned2 lunch').addClass('drop').attr('id', dataParts[0] + '|' + dataParts[1] + '|' + dataParts[2] + '|-1');
                    }
                }
            });
        });
    </script>
</body>
</html>