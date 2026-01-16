<?php
// Includes
include 'includes/conexBD.php'; // Assuming this sets up the $link (mysqli object) correctly

// Timezone setup
date_default_timezone_set('America/La_Paz'); // Caracas is in America/Caracas, but La Paz is also -04.

// Input sanitation and variable initialization
$username = $_REQUEST["username"] ?? ''; // Use null coalescing operator for cleaner default
$reserva = "N"; // Default value

// Fetch user's reservation status using prepared statement
$sql_user_reserva = "SELECT a.reserva FROM userlevels a JOIN sco_user b ON b.`level` = a.userlevelid WHERE b.username = ?;";
if ($stmt_user_reserva = $link->prepare($sql_user_reserva)) {
    $stmt_user_reserva->bind_param("s", $username);
    $stmt_user_reserva->execute();
    $stmt_user_reserva->bind_result($reserva_from_db);
    if ($stmt_user_reserva->fetch()) {
        $reserva = $reserva_from_db; // Update $reserva if found in DB
    }
    $stmt_user_reserva->close();
} else {
    // Log error instead of dying directly in a production environment
    error_log("Error al preparar la consulta SELECT de reserva de usuario: " . $link->error);
    // Optionally, display a user-friendly message or set a default value
}

// Initialize request parameters with defaults
$swmt = $_REQUEST["swmt"] ?? "AUTO";
$swmt2 = $_REQUEST["swmt2"] ?? "AUTO";
$fecha_inicio = ($swmt == "AUTO" ? date("d/m/Y") : ($_REQUEST["fecha_inicio"] ?? date("d/m/Y")));
$hora_inicio = ($swmt == "AUTO" ? date("H:i:s") : ($_REQUEST["hora_inicio"] ?? date("H:i:s")));

// Fetch estatus (statuses) data once
$estatus_exp = [];
$sql_estatus = "SELECT Nstatus, color, nombre FROM sco_estatus WHERE activo = 'S' ORDER BY Nstatus;";
$result_estatus = $link->query($sql_estatus);
if ($result_estatus) {
    if ($result_estatus->num_rows > 0) {
        while ($fila = $result_estatus->fetch_assoc()) {
            $estatus_exp[] = $fila;
        }
    } else {
        // More graceful error handling, don't die completely
        error_log("No hay estatus configurados en la base de datos.");
        // Optionally, define a default status or display a message to the user
    }
    $result_estatus->free();
} else {
    error_log("Error en la consulta de estatus: " . $link->error);
    // Handle database error
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
    <link rel="stylesheet" type="text/css" href="jquery/themes/color.css">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="jquery/locale/easyui-lang-es.js"></script>
    <meta http-equiv="refresh" content="120">
</head>
<body onLoad="js:mostrarHora();">
    <div>
        <?php
        foreach ($estatus_exp as $value) {
            echo '<a href="#" class="easyui-linkbutton" style="width:120px; color:#ffffff; background:' . htmlspecialchars($value["color"]) . ';"><b>' . htmlspecialchars($value["nombre"]) . '</b></a>';
        }
        ?>

        <input class="easyui-switchbutton" id="sw" name="sw" data-options="onText:'AUTO',offText:'MANU'" value="AUTO" <?php echo ($swmt == "AUTO" ? "checked" : ""); ?>>
        <input type="hidden" id="swmt" name="swmt" value="<?php echo htmlspecialchars($swmt); ?>" />
        &nbsp;
        <input id="fecha_inicio" name="fecha_inicio" label="Select Date:" labelPosition="top" style="width:120px;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo htmlspecialchars($fecha_inicio); ?>">
        &nbsp;
        <select class="easyui-combobox" id="hora_inicio" name="hora_inicio" label="Hora Velaci&oacute;n:" labelPosition="top" style="width:120px;" data-options="editable:false">
            <?php
            for ($i = 0; $i < 24; $i++) {
                $hr = str_pad($i, 2, "0", STR_PAD_LEFT) . ":00";
                echo '<option value="' . htmlspecialchars($hr) . '" ' . ($hr == substr($hora_inicio, 0, 5) ? 'selected="selected"' : '') . '>' . htmlspecialchars(date("g:ia", strtotime(date("Y-m-d") . " " . $hr . ":00"))) . '</option>';
            }
            ?>
        </select>
        &nbsp;
        <input class="easyui-switchbutton" id="sw2" name="sw2" data-options="onText:'VER',offText:'OCUL'" value="AUTO" <?php echo ($swmt2 == "AUTO" ? "checked" : ""); ?>>
    </div>
    <div id="tt" class="easyui-tabs" style="width:100%;height100%">
        <div title="Monitoreo de Disponibilidad (<?php echo htmlspecialchars(formatear_fecha($fecha_inicio)) . " -- " . htmlspecialchars(($swmt == "AUTO" ? date("h:iA") : date("h:iA", strtotime($_REQUEST["hora_inicio"] ?? date("H:i:s"))))); ?>)" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:800px;">
                <div class="right">
                    <div id="dlg" class="easyui-dialog" title="Basic Dialog" data-options="iconCls:'icon-save'" style="width:800px;height:450px;padding:10px">
                        The dialog content.
                    </div>
                    <?php
                    // --- Primera Consulta (Capillas) ---
                    $sql_capillas = "SELECT
                                        Nservicio_tipo, nombre AS capillas
                                     FROM
                                        sco_servicio_tipo
                                     WHERE
                                        SUBSTRING(Nservicio_tipo,1,3) = 'CAP'
                                     ORDER BY capillas ASC;";

                    $result_capillas = $link->query($sql_capillas);

                    if ($result_capillas) {
                        if ($result_capillas->num_rows > 0) {
                            while ($row01 = $result_capillas->fetch_assoc()) {
                    ?>
                                <div><b><?php echo htmlspecialchars($row01["capillas"]); ?></b></div>
                                <table>
                                    <tr>
                                        <td class="blank"></td>
                                        <td class="title"><div style="width:80px">H. Entrada</div></td>
                                        <td class="title"><div style="width:80px">H. Salida</div></td>
                                        <td class="title"><div style="width:80px">F. Entrada</div></td>
                                        <td class="title"><div style="width:80px">F. Salida</div></td>
                                        <td class="title"><div style="width:150px">Nombre Difunto</div></td>
                                        <td class="title"><div style="width:150px">Apellido Difunto</div></td>
                                        <td class="title"><div style="width:50px">Servicio</div></td>
                                        <td class="title"><div style="width:100px">Seguro</div></td>
                                        <td class="title"><div style="width:50px">Pago</div></td>
                                        <td class="title"><div style="width:50px">Nota</div></td>
                                        <td class="title"><div style="width:100px">Permiso</div></td>
                                    </tr>
                                    <?php
                                    $lines = ($row01["capillas"] == "IGLESIA") ? 12 : 4;
                                    $pass = false;

                                    for ($i = 0; $i < $lines; $i++) {
                                        // --- Segunda Consulta (Servicios por Tipo de Capilla) ---
                                        $sql_servicios = "SELECT
                                                            Nservicio, nombre AS capilla
                                                          FROM
                                                            sco_servicio
                                                          WHERE
                                                            tipo = ? AND activo = 'S'
                                                          ORDER BY secuencia ASC;";

                                        $stmt_servicios = $link->prepare($sql_servicios);
                                        if ($stmt_servicios) {
                                            $stmt_servicios->bind_param("s", $row01["Nservicio_tipo"]);
                                            $stmt_servicios->execute();
                                            $result_servicios = $stmt_servicios->get_result();

                                            if ($result_servicios->num_rows > 0) {
                                                while ($row = $result_servicios->fetch_assoc()) {
                                                    // Pass the $link connection object to disponibilidad()
                                                    $data = disponibilidad($link, $fecha_inicio, $hora_inicio, $row["Nservicio"], $i, $reserva, $username);
                                                    $drop = "drop" . htmlspecialchars($data["estatus"] ?? '');

                                                    if (trim($data["expediente"] ?? '') != "" || $swmt2 != "AUTO") {
                                    ?>
                                                        <tr>
                                                            <td class="time"><div style="width:100px"><?php echo htmlspecialchars(str_replace("MONUMENTAL", "MON.", str_replace("CAPILLA", "", strtoupper($row["capilla"])))); ?></div></td>
                                                            <?php
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($data["hora_inicio"] ?? '') . '</div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($data["hora_fin"] ?? '') . '</div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($data["fecha_inicio"] ?? '') . '</div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($data["fecha_fin"] ?? '') . '</div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i><a href="../sco_expedienteview.php?showdetail=&amp;Nexpediente=' . htmlspecialchars($data["expediente"] ?? '') . '" target="_blank">' . htmlspecialchars($data["nombre_fallecido"] ?? '') . "<br>" . htmlspecialchars($data["cedula_fallecido"] ?? '') . '</a></i></b></div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i><a href="../sco_expedienteview.php?showdetail=&amp;Nexpediente=' . htmlspecialchars($data["expediente"] ?? '') . '" target="_blank">' . htmlspecialchars($data["apellidos_fallecido"] ?? '') . "<br>" . htmlspecialchars($data["cedula_fallecido"] ?? '') . '</a></i></b></div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars(substr($data["servicio"] ?? '', 0, 4)) . "<br>" . htmlspecialchars($data["parcela"] ?? '') . '</i></b></div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($data["seguro"] ?? '') . '</i></b></div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($data["pago"] ?? '') . '</i></b></div></td>';
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . ($data["nota"] ?? '') . '</i></b></div></td>'; // Note HTML is allowed here as per your original code
                                                            echo '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($data["permiso"] ?? '') . '</i></b></div></td>';
                                                            ?>
                                                        </tr>
                                                <?php
                                                        $pass = true;
                                                    }
                                                }
                                            }
                                            $result_servicios->free();
                                            $stmt_servicios->close();
                                        } else {
                                            error_log("Error en la preparación de la segunda consulta: " . $link->error);
                                        }
                                    }
                                    if ($pass) echo '<tr><td colspan="12">&nbsp;</td></tr>';
                                    $pass = false;
                                    ?>
                                </table>
                                <br />
                    <?php
                            }
                        } else {
                            echo "No se encontraron capillas.";
                        }
                        $result_capillas->free();
                    } else {
                        error_log("Error en la primera consulta de capillas: " . $link->error);
                    }

                    $link->close(); // Close the main database connection
                    ?>
                </div>
            </div>
            <style type="text/css">
                .left { width: 100%; float: left; }
                .left table { background: #E0ECFF; }
                .left td { background: #eee; }
                .right { float: right; width: 100%; }
                .right table { background: #E0ECFF; width: 0%; /* This width:0% might cause layout issues. Consider 'auto' or a fixed width */ }
                .right td { background: #fafafa; color: #444; text-align: center; padding: 2px; }
                .right td { background: #E0ECFF; /* This is redundant and overrides the above */ }
                <?php
                foreach ($estatus_exp as $value) {
                ?>
                    .right td.drop<?php echo htmlspecialchars($value["Nstatus"]); ?> {
                        color: #000000;
                        background: <?php echo htmlspecialchars($value["color"]); ?>;
                        width: 100px;
                    }
                <?php
                }
                ?>
                .right td.over { background: #FBEC88; }
                .item { text-align: center; border: 1px solid #499B33; background: #FFFFCC; color: #444; width: 130px; }
                .assigned { border: 1px solid #BC2A4D; background: #99CC99; }
                .assigned2 { border: 1px solid #BC2A4D; background: #FFFFCC; }
                .trash { background-color: red; }
            </style>
        </div>
    </div>
    <script type="text/javascript">
        var xstatus = <?php echo json_encode(($swmt == "AUTO" ? 'disable' : 'enable')); ?>;
        $(document).ready(function() {
            $('#dlg').dialog('close');
            $('#qs').val("NO"); // 'qs' element not found in provided HTML
            $('#fecha_inicio').textbox(xstatus);
            $('#hora_inicio').combobox(xstatus);
            $('#tt').tabs({
                pill: true,
                justified: true
            });
        });

        $('#fecha_inicio').datebox({
            onSelect: function(date) {
                var fecha = dia_semana($("#fecha_inicio").datebox('getValue'));
                var fi = $("#fecha_inicio").datebox('getValue').split("/");
                var weekday = new Array();
                weekday['01'] = "Enero";
                weekday['02'] = "Febrero";
                weekday['03'] = "Marzo";
                weekday['04'] = "Abril";
                weekday['05'] = "Mayo";
                weekday['06'] = "Junio";
                weekday['07'] = "Julio";
                weekday['08'] = "Agosto";
                weekday['09'] = "Septiembre";
                weekday['10'] = "Octubre";
                weekday['11'] = "Noviembre";
                weekday['12'] = "Diciembre";
                var dayOfWeek = weekday[fi[1]];

                fecha = fecha + ", " + fi[0] + " de " + dayOfWeek + " de " + fi[2];
                $("#fecha").html(fecha); // 'fecha' element not found in provided HTML

                var date_new = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
                $('#fecha_fin').datebox('setValue', date_new); // 'fecha_fin' element not found
            }
        });

        function dia_semana(fecha) {
            fecha = fecha.split('/');
            if (fecha.length != 3) {
                return null;
            }
            var regular = [0, 3, 3, 6, 1, 4, 6, 2, 5, 0, 3, 5];
            var bisiesto = [0, 3, 4, 0, 2, 5, 0, 3, 6, 1, 4, 6];
            var semana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
            var dia = parseInt(fecha[0], 10);
            var mes = parseInt(fecha[1], 10) - 1;
            var anno = parseInt(fecha[2], 10);
            if ((anno % 4 == 0) && !(anno % 100 == 0 && anno % 400 != 0))
                mes = bisiesto[mes];
            else
                mes = regular[mes];
            return semana[Math.ceil(Math.ceil(Math.ceil((anno - 1) % 7) + Math.ceil((Math.floor((anno - 1) / 4) - Math.floor((3 * (Math.floor((anno - 1) / 100) + 1)) / 4)) % 7) + mes + dia % 7) % 7)];
        }

        function myformatter(date) {
            var y = date.getFullYear();
            var m = date.getMonth() + 1;
            var d = date.getDate();
            return (d < 10 ? ('0' + d) : d) + "/" + (m < 10 ? ('0' + m) : m) + "/" + y;
        }

        function myparser(s) {
            if (!s) return new Date();
            var ss = (s.split('/'));
            var d = parseInt(ss[0], 10);
            var m = parseInt(ss[1], 10);
            var y = parseInt(ss[2], 10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
                return new Date(y, m - 1, d); // Corrected: new Date(year, monthIndex, day)
            } else {
                return new Date();
            }
        }

        // Common function for switch button change
        function handleSwitchChange(checked) {
            var date = new Date();
            var date_new = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
            if (checked) {
                $('#fecha_inicio').datebox('setValue', date_new);
            }
            // These might not be necessary if the page reloads anyway
            // $('#sw').val(checked ? "AUTO" : "MANU");
            // $('#sw2').val(checked ? "AUTO" : "MANU");
            $('#fecha_inicio').textbox(checked ? 'disable' : 'enable');
            $('#hora_inicio').textbox(checked ? 'disable' : 'enable');

            var mysw = $('#sw').switchbutton('options').checked ? "AUTO" : "MANU"; // Corrected to use 'MANU'
            var mysw2 = $('#sw2').switchbutton('options').checked ? "AUTO" : "OCUL"; // Corrected to use 'OCUL'
            var fecha_inicio = $("#fecha_inicio").datebox('getValue');
            var hora_inicio = $('#hora_inicio').combobox('getValue');

            var url = "PizarraServicos.php?swmt=" + mysw + "&swmt2=" + mysw2 + "&fecha_inicio=" + fecha_inicio + "&hora_inicio=" + hora_inicio + "&username=<?= urlencode($username) ?>";
            window.location.href = url;
        }

        $('#sw').switchbutton({
            onChange: function(checked) {
                handleSwitchChange(checked);
            }
        });

        $('#sw2').switchbutton({
            onChange: function(checked) {
                handleSwitchChange(checked);
            }
        });

        $('#fecha_inicio').datebox({
            onSelect: function(date) {
                var xfecha = $('#fecha_inicio').textbox('getValue');
                var xhora = $('#hora_inicio').textbox('getValue');
                var xswmt = $('#swmt').val();
                var xswmt2 = $('#sw2').switchbutton('options').checked ? "AUTO" : "OCUL"; // Get current state of sw2

                var url = "PizarraServicos.php?swmt=" + xswmt + "&swmt2=" + xswmt2 + "&fecha_inicio=" + xfecha + "&hora_inicio=" + xhora + "&username=<?= urlencode($username) ?>";
                window.location.href = url;
            }
        });

        $('#hora_inicio').combobox({
            onChange: function(newValue, oldValue) {
                var xfecha = $('#fecha_inicio').textbox('getValue');
                var xhora = $('#hora_inicio').combobox('getValue'); // Use combobox for consistency
                var xswmt = $('#swmt').val();
                var xswmt2 = $('#sw2').switchbutton('options').checked ? "AUTO" : "OCUL"; // Get current state of sw2

                var url = "PizarraServicos.php?swmt=" + xswmt + "&swmt2=" + xswmt2 + "&fecha_inicio=" + xfecha + "&hora_inicio=" + xhora + "&username=<?= urlencode($username) ?>";
                window.location.href = url;
            }
        });


        function mostrarHora() {
            var f = new Date();
            var hora = f.getHours();
            var minutos = f.getMinutes();
            var segundos = f.getSeconds();
            var dia = f.getDate();
            var ampm = "";
            var mes = f.getMonth() + 1; // getMonth() is 0-indexed
            var anho = f.getFullYear();

            var stringHora = "";
            var horaMostrar = hora;
            var minutosMostrar = minutos;
            var segundosMostrar = segundos;

            if (horaMostrar < 10) { horaMostrar = "0" + horaMostrar; }
            if (minutosMostrar < 10) { minutosMostrar = "0" + minutosMostrar; }
            if (segundosMostrar < 10) { segundosMostrar = "0" + segundosMostrar; }

            if (horaMostrar >= 0 && horaMostrar < 13) {
                ampm = (horaMostrar == 12 ? "PM" : "AM");
                horaMostrar = (horaMostrar == 0 ? 12 : horaMostrar);
            } else {
                ampm = "PM";
                horaMostrar = horaMostrar - 12;
            }

            stringHora = "Fecha: " + dia + "/" + mes + "/" + anho + " " + horaMostrar + ":" + minutosMostrar + ":" + segundosMostrar + ampm;
            $("#Hora").text(stringHora); // Ensure there's an element with id="Hora" for this to work

            setTimeout("mostrarHora()", 1000);
        }

        function disponer_capilla(accion, capilla, fecha, hora, username) {
            var url = "disponer_capilla.php?accion=" + accion + "&capilla=" + encodeURIComponent(capilla) + "&fecha=" + encodeURIComponent(fecha) + "&hora=" + encodeURIComponent(hora) + "&username=" + encodeURIComponent(username);
            window.location.href = url;
        }

        function NoteLoad(id) {
            var parametros = {
                "id": id
            };

            $.ajax({
                data: parametros,
                url: 'Cargar_Notas.php',
                type: 'get',
                beforeSend: function() {
                    $("#dlg").html('Updating... <img src="../phpimages/ajax-loading.gif" border="0">');
                },
                success: function(response) {
                    var data = response;
                    $("#dlg").html(response);
                }
            });
        }
    </script>
</body>
</html>

<?php
// PHP functions (kept as is, but ensure `conexBD.php` provides a `$link` variable)

// formatear_fecha function remains the same, as it does not interact with the database.
function formatear_fecha($fecha) {
    $ff = explode("/", $fecha);

    // Check if the array has 3 elements to prevent errors
    if (count($ff) !== 3) {
        return "Fecha inválida"; // Or handle the error as appropriate
    }

    $fecha_timestamp = mktime(0, 0, 0, (int) $ff[1], (int) $ff[0], (int) $ff[2]);
    $fecha_formato_en = date("l, d - F - Y", $fecha_timestamp); // Format in English first

    // Arrays for translation
    $dias_es = array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado');
    $days_en = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $meses_es =  array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
    $months_en =  array('January','February','March','April','May','June','July','August','September','October','November','December');

    // Perform translations
    $fecha_traducida = str_replace($days_en, $dias_es, $fecha_formato_en);
    $fecha_traducida = str_replace($months_en, $meses_es, $fecha_traducida);
    $fecha_traducida = str_replace(" - ", " de ", $fecha_traducida);

    return $fecha_traducida;
}


/**
 * Función para obtener la disponibilidad de una capilla en una fecha y hora específicas.
 *
 * @param mysqli $link      Objeto de conexión MySQLi.
 * @param string $fecha     Fecha en formato DD/MM/YYYY.
 * @param string $hora      Hora en formato HH:MM:SS.
 * @param string $capilla   ID o nombre de la capilla.
 * @param int    $vez       Offset para la consulta de la orden (LIMIT $vez, 1).
 * @param string $reserva   Indicador de si se permite la reserva ('S' o 'N').
 * @param string $username  Nombre de usuario actual (usado para bloqueo/desbloqueo).
 * @return array            Array asociativo con los datos de disponibilidad o de reserva.
 */
function disponibilidad($link, $fecha, $hora, $capilla, $vez, $reserva, $username) {
    // Verificar que la conexión sea válida
    if (!$link instanceof mysqli || $link->connect_error) {
        // Podrías lanzar una excepción o registrar un error aquí
        error_log("Error: Conexión MySQLi no válida en la función disponibilidad.");
        return [
            "expediente" => "",
            "nombre_fallecido" => "ERROR: Conexión DB",
            "apellidos_fallecido" => "",
            "fecha_inicio" => "", "hora_inicio" => "", "fecha_fin" => "", "hora_fin" => "",
            "servicio" => "", "seguro" => "", "pago" => "", "nota" => "", "permiso" => "",
            "estatus" => "", "parcela" => "", "cedula_fallecido" => ""
        ];
    }

    $ff = explode("/", $fecha);
    $xfecha = $ff[2] . "-" . $ff[1] . "-" . $ff[0]; // Formato YYYY-MM-DD

    $data = []; // Inicializa el array de datos que se retornará

    // --- Primera Consulta Principal ---
    // Uso de consultas preparadas para mayor seguridad
    $sql_principal = "SELECT
                        DATE_FORMAT(ord.hora_inicio, '%h:%i%p') AS hora_inicio,
                        DATE_FORMAT(ord.hora_fin, '%h:%i%p') AS hora_fin,
                        DATE_FORMAT(ord.fecha_inicio, '%d/%m/%Y') AS fecha_inicio,
                        DATE_FORMAT(ord.fecha_fin, '%d/%m/%Y') AS fecha_fin,
                        exp.nombre_fallecido,
                        exp.apellidos_fallecido,
                        ord.servicio AS cod_capilla,
                        ser.nombre AS capilla,
                        (SELECT DISTINCT sco_servicio_tipo.nombre
                         FROM sco_orden
                         JOIN sco_servicio_tipo ON sco_servicio_tipo.Nservicio_tipo = sco_orden.servicio_tipo
                         WHERE sco_orden.expediente = ord.expediente AND sco_orden.paso = '2' LIMIT 0,1
                        ) AS servicio,
                        ord.expediente,
                        seg.nombre AS seguro,
                        IF(TRIM(IFNULL(exp.factura, '')) = '', 'NO', IFNULL((SELECT GROUP_CONCAT(factura SEPARATOR ',') FROM sco_expediente_cia WHERE expediente = ord.expediente AND servicio_tipo LIKE 'CAP%'), 'SI')) AS pago,
                        IFNULL(LENGTH(TRIM(exp.nota)), 0) AS nota,
                        (SELECT COUNT(*) FROM sco_nota WHERE expediente = exp.Nexpediente) AS notas,
                        exp.permiso,
                        exp.estatus,
                        exp.parcela,
                        exp.cedula_fallecido, ord.fecha_inicio as fecha_para_ordenar
                    FROM
                        sco_orden ord
                        JOIN sco_expediente exp ON exp.Nexpediente = ord.expediente
                        JOIN sco_servicio ser ON ser.Nservicio = ord.servicio
                        JOIN sco_seguro seg ON seg.Nseguro = exp.seguro
                    WHERE
                        ord.paso = '1'
                        AND CONCAT(ord.fecha_fin, ' ', ord.hora_fin) > ? -- Concatenar para comparar fecha y hora
                        AND ord.servicio = ?
                    ORDER BY
                        ord.fecha_inicio ASC
                    LIMIT ?, 1;";

    $stmt_principal = $link->prepare($sql_principal);

    if ($stmt_principal) {
        $datetime_compare = $xfecha . " " . $hora;
        $stmt_principal->bind_param("ssi", $datetime_compare, $capilla, $vez); // 's' para string, 'i' para integer
        $stmt_principal->execute();
        $result_principal = $stmt_principal->get_result();

        if ($row = $result_principal->fetch_assoc()) { // Usar fetch_assoc()
            // --- Sub-consulta para 'compartir' ---
            $sql_compartir = "SELECT
                                IF(IFNULL(nombre_fallecido, '') = '', '', CONCAT(' con ', nombre_fallecido, ' ', apellidos_fallecido)) AS compartir
                              FROM
                                sco_expediente
                              WHERE
                                unir_con_expediente = ?;";

            $stmt_compartir = $link->prepare($sql_compartir);
            $compartir = "";
            if ($stmt_compartir) {
                $stmt_compartir->bind_param("s", $row["expediente"]);
                $stmt_compartir->execute();
                $result_compartir = $stmt_compartir->get_result();

                while ($row001 = $result_compartir->fetch_assoc()) {
                    $compartir .= $row001["compartir"];
                }
                $result_compartir->free();
                $stmt_compartir->close();
            } else {
                error_log("Error en la preparación de la consulta compartir: " . $link->error);
            }

            $data = [
                "expediente" => $row["expediente"],
                "nombre_fallecido" => $row["nombre_fallecido"] . $compartir,
                "apellidos_fallecido" => $row["apellidos_fallecido"],
                "fecha_inicio" => $row["fecha_inicio"],
                "hora_inicio" => $row["hora_inicio"],
                "fecha_fin" => $row["fecha_fin"],
                "hora_fin" => $row["hora_fin"],
                "servicio" => $row["servicio"],
                "seguro" => $row["seguro"],
                "pago" => $row["pago"],
                "nota" => (($row["nota"] > 0 || $row["notas"] > 0) ? '<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$(\'#dlg\').dialog(\'open\');NoteLoad(' . htmlspecialchars($row["expediente"]) . ');">Nota</a>' : ''),
                "permiso" => $row["permiso"],
                "estatus" => $row["estatus"],
                "parcela" => $row["parcela"],
                "cedula_fallecido" => $row["cedula_fallecido"]
            ];
        } else {
            // No se encontraron resultados en la consulta principal
            if ($reserva == "S") {
                $yfecha = $xfecha;
                $yhora = $hora;

                // --- Sub-consulta para buscar fecha y hora del último servicio ---
                $sql_ultimo_servicio = "SELECT
                                            ord.hora_fin,
                                            DATE_FORMAT(ord.fecha_fin, '%Y-%m-%d') AS fecha_fin
                                        FROM
                                            sco_orden ord
                                        WHERE
                                            ord.paso = '1'
                                            AND CONCAT(ord.fecha_fin, ' ', ord.hora_fin) > ?
                                            AND ord.servicio = ?
                                        ORDER BY
                                            ord.fecha_fin DESC
                                        LIMIT 0,1;";

                $stmt_ultimo_servicio = $link->prepare($sql_ultimo_servicio);
                if ($stmt_ultimo_servicio) {
                    $datetime_compare = $xfecha . " " . $hora;
                    $stmt_ultimo_servicio->bind_param("ss", $datetime_compare, $capilla);
                    $stmt_ultimo_servicio->execute();
                    $result_ultimo_servicio = $stmt_ultimo_servicio->get_result();

                    if ($row001 = $result_ultimo_servicio->fetch_assoc()) {
                        $yfecha = $row001["fecha_fin"];
                        $yhora = $row001["hora_fin"];
                    }
                    $result_ultimo_servicio->free();
                    $stmt_ultimo_servicio->close();
                } else {
                    error_log("Error en la preparación de la consulta de último servicio: " . $link->error);
                }

                // --- Sub-consulta para verificar horas reservadas ---
                $sql_reserva = "SELECT fecha, hora, username FROM sco_reserva WHERE capilla = ? AND fecha >= ? AND hora >= ?;";
                $stmt_reserva = $link->prepare($sql_reserva);
                $reservar = '';
                if ($stmt_reserva) {
                    $stmt_reserva->bind_param("sss", $capilla, $yfecha, $yhora);
                    $stmt_reserva->execute();
                    $result_reserva = $stmt_reserva->get_result();

                    if ($row001 = $result_reserva->fetch_assoc()) {
                        $reservar = '<a href="#" class="easyui-linkbutton c5" style="width:180px" onClick="js:disponer_capilla(0,\'' . htmlspecialchars($capilla) . '\',\'' . htmlspecialchars($yfecha) . '\',\'' . htmlspecialchars($yhora) . '\',\'' . htmlspecialchars($row001["username"]) . '\');">Desbloquear (' . htmlspecialchars($row001["username"]) . ')</a>';
                    } else {
                        $reservar = '<a href="#" class="easyui-linkbutton c1" style="width:180px" onClick="js:disponer_capilla(1,\'' . htmlspecialchars($capilla) . '\',\'' . htmlspecialchars($yfecha) . '\',\'' . htmlspecialchars($yhora) . '\',\'' . htmlspecialchars($username) . '\');">Bloquear</a>';
                    }
                    $result_reserva->free();
                    $stmt_reserva->close();
                } else {
                    error_log("Error en la preparación de la consulta de reserva: " . $link->error);
                }
            } else {
                $reservar = '';
            }

            $data = [
                "expediente" => "",
                "nombre_fallecido" => $reservar,
                "apellidos_fallecido" => "",
                "fecha_inicio" => "",
                "hora_inicio" => "",
                "fecha_fin" => "",
                "hora_fin" => "",
                "servicio" => "",
                "seguro" => "",
                "pago" => "",
                "nota" => "",
                "permiso" => "",
                "estatus" => "",
                "parcela" => "", // Default empty string if not found
                "cedula_fallecido" => ""
            ];
        }
        $result_principal->free();
        $stmt_principal->close();
    } else {
        error_log("Error en la preparación de la consulta principal: " . $link->error);
        $data = [
            "expediente" => "",
            "nombre_fallecido" => "ERROR: Consulta principal fallida",
            "apellidos_fallecido" => "",
            "fecha_inicio" => "", "hora_inicio" => "", "fecha_fin" => "", "hora_fin" => "",
            "servicio" => "", "seguro" => "", "pago" => "", "nota" => "", "permiso" => "",
            "estatus" => "", "parcela" => "", "cedula_fallecido" => ""
        ];
    }

    return $data;
}
?>