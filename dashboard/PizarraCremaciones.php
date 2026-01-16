<?php
include 'includes/conexBD.php';
date_default_timezone_set('America/La_Paz');

$username = $_GET["username"] ?? '';
$sql_user_reserva = "SELECT a.reserva FROM userlevels a JOIN sco_user b ON b.`level` = a.userlevelid WHERE b.username = ?;";
$reserva = "N"; 
if ($username == "Administrator") {
	$reserva = "S";
} 
else {
	if ($stmt = $link->prepare($sql_user_reserva)) {
	    $stmt->bind_param("s", $username);
	    $stmt->execute();
	    $stmt->bind_result($reserva_from_db);
	    if ($stmt->fetch()) {
	        $reserva = $reserva_from_db;
	    } else {
	        die("Usuario '$username' no encontrado o sin nivel de reserva.");
	    }
	    $stmt->close();
	} else {
	    die("Error al preparar la consulta de reserva de usuario: " . $link->error);
	}
}


$swmt = isset($_REQUEST["swmt"])?$_REQUEST["swmt"]:"AUTO";
if(isset($_REQUEST["fecha_inicio"])) {
	$fc = explode("/", $_REQUEST["fecha_inicio"]);
	$_fecha = $fc[2] . "-" . $fc[1] . "-" . $fc[0];
}
$fecha_inicio = isset($_REQUEST["fecha_inicio"])?$_fecha:date("Y-m-d");
$fc = explode("-", $fecha_inicio);
$_fecha = $fc[2] . "/" . $fc[1] . "/" . $fc[0];
// die($_fecha . " " . $fecha_inicio . " " . $_REQUEST["fecha_inicio"]);

$estatus = array(
    "RECEPCION" => "",
    "DOCUMENTOS" => 1,
    "PROCESO" => 2,
    "CREM. ZONA 0" => 3,
    "CREMACION OK" => 4,
    "ENTREGADAS" => 5,
);

$ataud_st = array(
    "RESGUARDO" => "ATAUD EN RESGUARDO",
    "DONACION" => "QUEDO ATAUD PARA DONACION",
    "ENTREGADO" => "SE ENTREGO ATAUD A LA FUNERARIA"
);

// Inicializa el array $bloque_horario
$bloque_horario = [];

$sql_bloque_horario = "SELECT hora, bloque FROM sco_bloque_horario WHERE servicio_tipo = 'CREM';";
$result = $link->query($sql_bloque_horario);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bloque_horario[$row["hora"]] = $row["bloque"];
    }
    $result->free();
} else {
    die("Error al ejecutar la consulta de bloque_horario: " . $link->error);
}

$bh = [];
$sql_bloque_distinto = "SELECT DISTINCT bloque FROM sco_bloque_horario WHERE servicio_tipo = 'CREM' AND bloque <> 'EXCEP';";
$result_bloque_distinto = $link->query($sql_bloque_distinto);
if ($result_bloque_distinto) {
    while ($row = $result_bloque_distinto->fetch_assoc()) {
        $bh[] = $row["bloque"];
    }
    $result_bloque_distinto->free();
} else {
    die("Error al ejecutar la consulta de bloques horarios distintos: " . $link->error);
}

// Añadir 'EXCEP' al final del array, como en el código original
$bh[] = "EXCEP";

///////////

$mascotas = '';
$sql_mascotas = "SELECT COUNT(*) AS cantidad FROM sco_mascota WHERE IFNULL(estatus, 'NW') = 'NW';";
$result_mascotas = $link->query($sql_mascotas);
if ($result_mascotas) {
    $row = $result_mascotas->fetch_assoc();
    $cantidad_mascotas = intval($row["cantidad"]);
    $result_mascotas->free();

    if ($cantidad_mascotas > 0) {
        $safe_username = htmlspecialchars($username);
        $mascotas = '<a href="#" class="easyui-linkbutton" data-options="iconCls:\'icon-tip\'" onClick="js: window.open(\'asistencia_mascota.php?username=' . $username . '\'); ">(' . $mascotas . ') Nuevo(s) Servicio de Mascotas</a>';
    }
} else {
    die("Error al ejecutar la consulta de conteo de mascotas: " . $link->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pizarra de Cremaciones</title>
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
	<div class="row">
		<div>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#f2dede; background:#a94442;"><b>RECEPCION</b></a>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#fcf8e3; background:#8a6d3b;"><b>DOCUMENTOS</b></a>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#dff0d8; background:#3c763d;"><b>PROCESO</b></a>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#ffffff; background:#76abf4;"><b>CREM. ZONA 0</b></a>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#f7d9ca; background:#ff6a1d;"><b>CREMACION OK</b></a>
			<a href="#" class="easyui-linkbutton" style="width:150px; color:#d6cbe3; background:#5c239b;"><b>ENTREGADAS</b></a>
			<!--<a href="#" class="easyui-linkbutton" style="width:120px; color:#62b0e3; background:#d9edf7;"><b>SIN ESTATUS</b></a>-->
			<!--<a href="#" class="easyui-linkbutton" style="width:120px; color:#ffffff; background:#007bff;"><b>ATAUD OK</b></a>-->
            <input class="easyui-switchbutton" id="sw" name="sw" data-options="onText:'AUTO',offText:'MANU'" value="AUTO" <?php echo ($swmt=="AUTO"?"checked":""); ?>>
            <input type="hidden" id="swmt" name="swmt" size="6" value="<?php echo $swmt ?>" />
            &nbsp; 
            <input id="fecha_inicio" name="fecha_inicio" labelPosition="top" style="width:120px;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo $_fecha; ?>">
            &nbsp;
            <!--<a href="asistencia_007.php" class="easyui-linkbutton c1" style="width:200px;" target="_blanck"><b>Pizarra de Inhumaciones</b></a>-->
            <?php echo $mascotas; ?>
		</div>
	</div>
    <div id="tt" class="easyui-tabs" style="width:100%;">
    	<!-- Inicio Asignación de Capilla -->
        <div title="Programaci&oacute;n de Cremaciones para el d&iacute;a: <?php echo formatear_fecha($_fecha); ?>" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:1200px;height:100%;"> 
                <div class="right">
				    <div id="dlg" class="easyui-dialog" title="Basic Dialog" data-options="iconCls:'icon-save'" style="width:800px;height:450px;padding:10px">
				        The dialog content.
				    </div>                	
                    <table>
                        <tr>
                            <td class="title"><div style="width:50px"><b>Hora</b></div></td>
                            <td class="title"><div style="width:140px"><b>Nombre Difunto</b></div></td>
                            <td class="title"><div style="width:140px"><b>Apellido Difunto</b></div></td>
                            <!--<td class="title"><div style="width:200px"><b>Funeraria</b></div></td>-->
                            <td class="title"><div style="width:140px"><b>Capilla / Funeraria</b></div></td>
                            <td class="title"><div style="width:140px"><b>Ataud</b></div></td>
                            <td class="title"><div style="width:100px"><b>Salida</b></div></td>
                            <td class="title"><div style="width:140px"><b>Causa Fallecimiento</b></div></td>
                            <td class="title"><div style="width:100px"><b>Estatus</b></div></td>
                            <td class="title"><div style="width:70px"><b>#Exp.</b></div></td>
                            <td class="title"><div style="width:30px"><b>Nota</b></div></td>
                            <td class="title"><div style="width:50px"><b>Pago</b></div></td>
                        </tr>
                        <?php
///////////////////////

						// --- Consulta 1: Obtener la cantidad del parámetro '019' ---
						$xx_cant = 0; // Valor por defecto
						$sql_parametro = "SELECT valor2 AS cantidad FROM sco_parametro WHERE codigo = '019';";
						$result_parametro = $link->query($sql_parametro);

						if ($result_parametro) {
						    if ($row_parametro = $result_parametro->fetch_assoc()) {
						        $xx_cant = (int) $row_parametro["cantidad"];
						    }
						    $result_parametro->free();
						} else {
						    error_log("Error al consultar sco_parametro: " . $link->error);
						}

						// --- Preparar el string para la cláusula IN de ataud_st ---
						$ataud_st_in_clause = "";
						if (!empty($ataud_st) && is_array($ataud_st)) {
						    $quoted_values = array_map(function($value) use ($link) {
						        return "'" . $link->real_escape_string($value) . "'";
						    }, array_values($ataud_st)); // Usar array_values para obtener los valores directamente
						    $ataud_st_in_clause = implode(",", $quoted_values);
						} else {
						    // Si $ataud_st está vacío o no es un array, asegura que la cláusula IN no cause errores
						    $ataud_st_in_clause = "'INVALID_VALUE_FOR_EMPTY'"; // Usar un valor que no coincida
						}


						// --- Consulta Principal: Obtener datos de cremaciones ---
						$sql_cremaciones = "
						    SELECT
						        DATE_FORMAT(ord.hora_fin, '%H:%i') AS pauta,
						        ord.Norden, exp.Nexpediente,
						        tis.nombre AS tipo, ser.nombre AS servicio,
						        exp.nombre_contacto, exp.telefono_contacto1, exp.telefono_contacto2,
						        exp.nombre_fallecido, exp.apellidos_fallecido,
						        (SELECT date_format(a.fecha_fin, '%d-%m') FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1) AS fecha_fin,
						        (SELECT date_format(a.hora_fin, '%h:%i%p') FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1) AS hora_fin,
						        IF(ord.espera_cenizas='S','SI','NO') AS espera_cenizas,
						        (SELECT b.nombre FROM sco_orden a JOIN sco_servicio b ON b.Nservicio = a.servicio WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1) AS capilla,
						        pro.nombre AS proveedor,
						        IF(RTRIM(LTRIM(exp.causa_ocurrencia))='OTRO', exp.causa_otro, exp.causa_ocurrencia) AS causa_ocurrencia,
						        IF((SELECT DISTINCT servicio_tipo FROM sco_orden WHERE expediente = exp.Nexpediente AND servicio_tipo = 'EXHU') = 'EXHU', 'EXHUMACION/CREMACION', fun.nombre) AS funeraria,
						        IFNULL(LENGTH(TRIM(exp.nota)), 0) AS nota_len,
						        (SELECT COUNT(*) FROM sco_nota WHERE expediente = exp.Nexpediente) AS notas_count,
						        DATE_FORMAT(ord.hora_fin, '%h:%i:%p') AS hora_servicio,
						        IF(TRIM(IFNULL(exp.factura, '')) = '', 'NO', IFNULL((SELECT group_concat(factura SEPARATOR ',') FROM sco_expediente_cia WHERE expediente = ord.expediente AND servicio_tipo = 'CREM'), 'SI')) AS pago,
						        exp.cedula_fallecido
						    FROM
						        sco_orden AS ord
						        JOIN sco_expediente AS exp ON exp.Nexpediente = ord.expediente
						        LEFT OUTER JOIN sco_servicio_tipo AS tis ON tis.Nservicio_tipo = ord.servicio_tipo
						        LEFT OUTER JOIN sco_servicio AS ser ON ser.Nservicio = ord.servicio
						        LEFT OUTER JOIN sco_proveedor AS pro ON pro.Nproveedor = ord.proveedor
						        LEFT OUTER JOIN sco_proveedor AS fun ON fun.Nproveedor = IF(ord.capilla=1,129,ord.capilla)
						    WHERE
						        ord.paso = 2 AND ord.servicio_tipo = 'CREM' AND
						        DATE_FORMAT(ord.fecha_fin, '%Y-%m-%d') = ?
						    ORDER BY
						        ord.fecha_fin, ord.hora_fin;
						";

						$cremaciones = 0;
						$ids = array();
						$hora = "";
						$count = 1;
						$blackboard_string = "";
						$blackboard = []; // Inicializar el array blackboard

						// Preparar la consulta principal
						if ($stmt_principal = $link->prepare($sql_cremaciones)) {
						    // Vincular el parámetro para la fecha_inicio
						    $stmt_principal->bind_param("s", $fecha_inicio);
						    $stmt_principal->execute();
						    $result_principal = $stmt_principal->get_result();

						    while ($row = $result_principal->fetch_assoc()) {
						        // --- Lógica de llenado de celdas vacías por cambio de bloque ---
						        $current_pauta_block = $bloque_horario[$row["pauta"]] ?? ''; // Asegúrate de que $bloque_horario existe y tiene la clave

						        if ($hora != $current_pauta_block && $hora != "") {
						            $current_xx_cant = $xx_cant; // Usar una variable temporal para no modificar la original
						            if ($hora == "EXCEP") $current_xx_cant = 2; // Ajuste para excepciones

						            if ($count <= $current_xx_cant) {
						                for ($i = $count; $i <= $current_xx_cant; $i++) {
						                    $blackboard_string .= '<tr>';
						                    for ($j = 0; $j < 11; $j++) { // 11 columnas como en el original
						                        $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
						                    }
						                    $blackboard_string .= '</tr>';
						                }
						            }
						            $count = 1;
						            $blackboard[$hora] = $blackboard_string;
						            $blackboard_string = "";
						        }

						        // --- Consulta Interna 1: Último estatus de cremación ---
						        $my_est = '';
						        $sql_estatus_exp = "SELECT estatus FROM sco_cremacion_estatus WHERE expediente = ? ORDER BY fecha_hora DESC LIMIT 1;";
						        if ($stmt_estatus = $link->prepare($sql_estatus_exp)) {
						            $stmt_estatus->bind_param("s", $row["Nexpediente"]);
						            $stmt_estatus->execute();
						            $result_estatus = $stmt_estatus->get_result();
						            if ($row_estatus = $result_estatus->fetch_assoc()) {
						                $my_est = $row_estatus["estatus"];
						            }
						            $result_estatus->free();
						            $stmt_estatus->close();
						        } else {
						            error_log("Error al preparar consulta de estatus: " . $link->error);
						        }

						        // --- Lógica para determinar la clase CSS según el estatus ---
						        $drop = "drop";
						        switch ($my_est) {
						            case "RECEPCION":  $drop = "drop2"; break;
						            case "DOCUMENTOS": $drop = "drop3"; break;
						            case "PROCESO":    $drop = "drop4"; break;
						            case "CREMACION OK": $drop = "drop7"; break;
						            case "ENTREGADAS": $drop = "drop6"; break;
						            case "CREM. ZONA 0": $drop = "drop8"; break;
						            default:           $drop = "drop"; break;
						        }

						        $blackboard_string .= '<tr>';
						        if ($hora != $current_pauta_block) {
						            $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($current_pauta_block) . '</i></b></div></td>';
						            $hora = $current_pauta_block;
						        } else {
						            $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div></div></td>';
						        }

						        // --- Generación de celdas de la tabla ---
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><a onclick="js:alert(\'Hora Servicio: ' . htmlspecialchars($row["hora_servicio"]) . '\')"><b><i>' . htmlspecialchars($row["nombre_fallecido"]) . "<br>" . htmlspecialchars($row["cedula_fallecido"]) . '</i></b></a></div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($row["apellidos_fallecido"]) . "<br>" . htmlspecialchars($row["cedula_fallecido"]) . '</i></b></div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . (trim($row["capilla"] ?? '') == "" ? "<b>" . htmlspecialchars($row["funeraria"]) . "</b>" : htmlspecialchars($row["capilla"])) . '</i></b></div></td>';

						        // --- Lógica de devolución de ataud a la funeraria ---
						        $en = "";
						        $sql_nota_ataud = "SELECT nota FROM sco_nota WHERE expediente = ? AND nota IN (" . $ataud_st_in_clause . ") ORDER BY Nnota DESC LIMIT 1;";
						        if ($stmt_nota_ataud = $link->prepare($sql_nota_ataud)) {
						            $stmt_nota_ataud->bind_param("s", $row["Nexpediente"]);
						            $stmt_nota_ataud->execute();
						            $result_nota_ataud = $stmt_nota_ataud->get_result();
						            if ($row_nota_ataud = $result_nota_ataud->fetch_assoc()) {
						                $en = $row_nota_ataud["nota"];
						            }
						            $result_nota_ataud->free();
						            $stmt_nota_ataud->close();
						        } else {
						            error_log("Error al preparar consulta de nota de ataud: " . $link->error);
						        }

						        $entrega = '<div style="margin-bottom:0px">';
						        $entrega .= '<select class="easyui-combobox" id="entrega_' . htmlspecialchars($row["Nexpediente"]) . '" name="entregae_' . htmlspecialchars($row["Nexpediente"]) . '" labelPosition="top" style="width:95%;" data-options="panelHeight:\'auto\',editable:false">';
						        $entrega .= '<option value=""></option>';
						        foreach ($ataud_st as $key => $value) {
						            $entrega .= '<option value="' . htmlspecialchars($value) . '" ' . (trim($en) == trim($value) ? "selected" : "") . '>' . htmlspecialchars($key) . '</option>';
						        }
						        $entrega .= '</select>';
						        $entrega .= '</div>';

						        if ($entrega == '') {
						            $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . (trim($row["capilla"] ?? '') == "" ? "<b>" . htmlspecialchars($row["funeraria"] ?? '') . "</b>" : htmlspecialchars($row["capilla"] ?? '')) . '</div></td>';
						        } else {
						            $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . (trim($row["capilla"] ?? '') == "" ? $entrega : htmlspecialchars($row["capilla"] ?? '')) . '</div></td>';
						        }
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($row["fecha_fin"] ?? '') . " " . htmlspecialchars($row["hora_fin"] ?? '') . '</div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><b><i>' . htmlspecialchars($row["causa_ocurrencia"] ?? '') . '</i></b></div></td>';

						        // --- Consulta Interna 3: Historial de estatus para el ComboBox ---
						        $my_ar = [];
						        $sql_historial_estatus = "SELECT estatus FROM sco_cremacion_estatus WHERE expediente = ? ORDER BY fecha_hora DESC LIMIT 1,10;";
						        if ($stmt_historial = $link->prepare($sql_historial_estatus)) {
						            $stmt_historial->bind_param("s", $row["Nexpediente"]);
						            $stmt_historial->execute();
						            $result_historial = $stmt_historial->get_result();
						            while ($row_historial = $result_historial->fetch_assoc()) {
						                $my_ar[] = $row_historial["estatus"];
						            }
						            $result_historial->free();
						            $stmt_historial->close();
						        } else {
						            error_log("Error al preparar consulta de historial de estatus: " . $link->error);
						        }

						        $my_status = '<div style="margin-bottom:0px">';
						        $my_status .= '<select class="easyui-combobox" id="state_' . htmlspecialchars($row["Nexpediente"]) . '" name="state_' . htmlspecialchars($row["Nexpediente"]) . '" labelPosition="top" style="width:95%;" data-options="panelHeight:\'auto\',editable:false">';
						        $my_status .= '<option value="" ' . (trim($my_est) == "" ? "selected" : "") . '></option>'; // Corregido para que 'selected' funcione con trim
						        foreach ($estatus as $key_estatus => $value_estatus) {
						            $sw2 = true;
						            foreach ($my_ar as $value2_historial) {
						                if ($key_estatus == $value2_historial) {
						                    $sw2 = false;
						                    break;
						                }
						            }
						            if ($sw2) {
						                $my_status .= '<option value="' . htmlspecialchars($key_estatus) . '" ' . (trim($my_est) == trim($key_estatus) ? "selected" : "") . '>' . htmlspecialchars($key_estatus) . '</option>';
						            }
						        }
						        $my_status .= '</select>';
						        $my_status .= '</div>';

						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . $my_status . '</div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div><a href="../ScoExpedienteList?id_exp=' . $row["Nexpediente"] . '" target="_blank">' . htmlspecialchars($row["Nexpediente"]) . '</a></div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . (($row["nota_len"] > 0 || $row["notas_count"] > 0) ? '<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$(\'#dlg\').dialog(\'open\');NoteLoad(' . htmlspecialchars($row["Nexpediente"]) . ');">Nota</a>' : '') . '</div></td>';
						        $blackboard_string .= '<td class="' . htmlspecialchars($drop) . '"><div>' . htmlspecialchars($row["pago"]) . '</div></td>';
						        $blackboard_string .= '</tr>';

						        $ids[] = $row["Nexpediente"];
						        $count++;
						        $cremaciones++;
						    }
						    $result_principal->free();
						    $stmt_principal->close();
						} else {
						    error_log("Error al preparar la consulta principal de cremaciones: " . $link->error);
						    // Aquí puedes añadir un mensaje de error o manejar la situación.
						}

						// --- Llenar celdas vacías al final del último bloque ---
						if ($count <= $xx_cant) {
						    $current_xx_cant = $xx_cant;
						    if (trim($hora) == "EXCEP") $current_xx_cant = 2; // Ajuste para excepciones

						    for ($i = $count; $i <= $current_xx_cant; $i++) {
						        $blackboard_string .= '<tr>';
						        for ($j = 0; $j < 11; $j++) {
						            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
						        }
						        $blackboard_string .= '</tr>';
						    }
						}
						$blackboard[$hora] = $blackboard_string; // Asegúrate de guardar el último bloque
						$blackboard_string = ""; // Reiniciar para el siguiente uso si lo hubiera

						// --- Definir el separador ---
						$blackboard_separator = '<tr><td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td>';
						$blackboard_separator .= '<td class="drop5"><div>--</div></td></tr>';

						// --- Imprimir la pizarra final ---
						$count = 1; // Reiniciar count para esta sección
						foreach ($bh as $key => $value) {
						    $current_xx_cant = $xx_cant;
						    if ($value == "EXCEP") $current_xx_cant = 2;

						    if (trim($blackboard[$value] ?? '') == "") { // Usar ?? '' para evitar errores si la clave no existe
						        if ($count <= $current_xx_cant) {
						            for ($i = $count; $i <= $current_xx_cant; $i++) {
						                echo '<tr><td class="drop"><div><b><i>' . htmlspecialchars(($i == 1 ? $value : '')) . '</i></b></div></td>';
						                for ($j = 0; $j < 10; $j++) { // Las celdas vacías después del bloque
						                    echo '<td class="drop"><div>&nbsp;</div></td>';
						                }
						                echo '</tr>';
						            }
						        }
						        $count = 1;
						    } else {
						        echo $blackboard[$value];
						    }
						    echo ($value == "EXCEP" ? "" : $blackboard_separator);
						}

////////////////////
							?>
                            <tr><td colspan="10"><b>Total Cremaciones Programadas: <?php echo $cremaciones; ?></b></td></tr>
                        </table>
                </div>
                        
            </div>
            <style type="text/css">
                .left{
                    width:100%;
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
                    width:100%;
                }
                .right table{
                    background:#E0ECFF;
                    width:0%;
                }
                .right td{
                    background:#fafafa;
                    color:#444;
                    text-align:center;
                    padding:2px;
                }
                .right td{
                    background:#E0ECFF;
                }
                .right td.drop{
                    background:#fafafa;
                    width:100px;
                }
                .right td.drop2{
                	color:#f2dede;
                    background:#a94442;
                    width:100px;
                }
                .right td.drop3{
                	color:#fcf8e3;
                    background:#8a6d3b;
                    width:100px;
                }
                .right td.drop4{
                	color:#dff0d8;
                    background:#3c763d;
                    width:100px;
                }
                .right td.drop5{
                	color:#62b0e3;
                    background:#d9edf7;
                    width:100px;
                }
                .right td.drop6{
                	color:#d6cbe3;
                    background:#5c239b;
                    width:100px;
                }
                .right td.drop7{
                	color:#f7d9ca;
                    background:#ff6a1d;
                    width:100px;
                }
                .right td.drop8{
                	color:#f7d9ca;
                    background:#76abf4;
                    width:100px;
                }
                .right td.drop220{
                	color:#ffffff;
                    background:#007bff;
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
                    width:130px;
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
                
            </style>
        </div>
    	<!-- Fin Asignación de Capilla -->
    </div> 
    <script type="text/javascript">
		var xstatus = <?php echo($swmt=="AUTO"?"'disable'":"'enable'") ?>;
		$(document).ready(function() { 
			$('#dlg').dialog('close');
			$('#qs').val("NO");
			$('#fecha_inicio').textbox(xstatus);
			$('#tt').tabs({
				pill: true,
				justified: true
			})
		});		

		$('#fecha_inicio').datebox({
			onSelect: function(date){
				var fecha = dia_semana($("#fecha_inicio").datebox('getValue'));

				var fi = $("#fecha_inicio").datebox('getValue').split("/");
				var weekday=new Array();
					weekday['01']="Enero";
					weekday['02']="Febrero";
					weekday['03']="Marzo";
					weekday['04']="Abril";
					weekday['05']="Mayo";
					weekday['06']="Junio";
					weekday['07']="Julio";
					weekday['08']="Agosto";
					weekday['09']="Septiembre";
					weekday['10']="Octubre";
					weekday['11']="Noviembre";
					weekday['12']="Diciembre";
				var dayOfWeek = weekday[fi[1]];
				
				fecha = fecha + ", " +  fi[0] + " de " + dayOfWeek + " de " + fi[2];
				$("#fecha").html(fecha);
				
				var date_new = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
				$('#fecha_fin').datebox('setValue', date_new);
			}
		});
		
		function dia_semana(fecha){ 
			fecha=fecha.split('/');
			if(fecha.length!=3){
					return null;
			}
			//Vector para calcular día de la semana de un año regular.
			var regular =[0,3,3,6,1,4,6,2,5,0,3,5]; 
			//Vector para calcular día de la semana de un año bisiesto.
			var bisiesto=[0,3,4,0,2,5,0,3,6,1,4,6]; 
			//Vector para hacer la traducción de resultado en día de la semana.
			var semana=['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
			//Día especificado en la fecha recibida por parametro.
			var dia=fecha[0];
			//Módulo acumulado del mes especificado en la fecha recibida por parametro.
			var mes=fecha[1]-1;
			//Año especificado por la fecha recibida por parametros.
			var anno=fecha[2];
			//Comparación para saber si el año recibido es bisiesto.
			if((anno % 4 == 0) && !(anno % 100 == 0 && anno % 400 != 0))
				mes=bisiesto[mes];
			else
				mes=regular[mes];
			//Se retorna el resultado del calculo del día de la semana.
			return semana[Math.ceil(Math.ceil(Math.ceil((anno-1)%7)+Math.ceil((Math.floor((anno-1)/4)-Math.floor((3*(Math.floor((anno-1)/100)+1))/4))%7)+mes+dia%7)%7)];
		}		
		 
        function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            //return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
			return (d<10?('0'+d):d)+"/"+(m<10?('0'+m):m)+"/"+y;
        }
        function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('/'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                //return new Date(y,m-1,d);
				return new Date(d,m-1,y);
            } else {
                return new Date();
            }
        }

		$('#sw').switchbutton({
			onChange:function(checked){
				var date = new Date();
				var date_new = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
				if(checked)
					$('#fecha_inicio').datebox('setValue', date_new);
				$('#swmt').val(checked?"AUTO":"MANU");
				$('#fecha_inicio').textbox(checked?'disable':'enable');
			
				if(checked) {
					var url = "PizarraCremaciones.php?swmt=AUTO&username=<?php echo $username; ?>";
					window.location.href = url;
				}
			}
		})

		$('#fecha_inicio').datebox({
			onChange: function(date) {
				var xfecha = $('#fecha_inicio').textbox('getValue');
				var xswmt = $('#swmt').val();
				
				var url = "PizarraCremaciones.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&username=<?php echo $username; ?>";
				window.location.href = url;
			}
		});


		<?php foreach ($ids as $value) { ?>
			$('#state_<?php echo trim($value); ?>').combobox({
				onChange: function() {
					var xfecha = $('#fecha_inicio').textbox('getValue');
					var xswmt = $('#swmt').val();

					if(confirm("Seguro que desea cambiar el estatus de CREMACION del Exp # <?php echo trim($value); ?>")) {
						var url = "CremacionEstatusActualizar.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&exp=<?php echo trim($value); ?>&sta=" + $("#state_<?php echo trim($value); ?>").combobox('getValue') + "&username=<?php echo $username; ?>";
						window.location.href = url;
					}
					else location.reload();
				}
			});
		<?php } ?>
		
		<?php foreach ($ids as $value) { ?>
			$('#entrega_<?php echo trim($value); ?>').combobox({
				onChange: function() {
					var xfecha = $('#fecha_inicio').textbox('getValue');
					var xswmt = $('#swmt').val();

					if($("#entrega_<?php echo trim($value); ?>").combobox('getValue') == "") return false;
					if(confirm("Seguro que desea entregar el Ataud del Exp # <?php echo trim($value); ?> a la funeraria?")) {
						var url = "EntregarAtaud.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&exp=<?php echo trim($value); ?>&sta=" + $("#entrega_<?php echo trim($value); ?>").combobox('getValue') + "&username=<?php echo $username; ?>";
						window.location.href = url;
					}
					else location.reload();
				}
			});
		<?php } ?>
		

		function mostrarHora() {
			var f=new Date();
			var hora=f.getHours();
			var minutos=f.getMinutes();
			var segundos=f.getSeconds();
			var dia = f.getDate();
			var ampm = "";
			//var mes = ("0" + f.getMonth() + 1).slice(-2);
			var mes = f.getMonth() + 1;
			var anho = f.getFullYear();
			
			var stringHora="";
			var horaMostrar=hora;
			var minutosMostrar=minutos;
			var segundosMostrar=segundos;
		
			if (horaMostrar<10) {
				horaMostrar="0"+horaMostrar;
			}
			if (minutosMostrar<10) {
				minutosMostrar="0"+minutosMostrar;
			}
			if (segundosMostrar<10) {
				segundosMostrar="0"+segundosMostrar;
			}
		
			if(horaMostrar >=0 && horaMostrar < 13) {
				ampm = (horaMostrar==12?"PM":"AM");
				horaMostrar = (horaMostrar==0?12:horaMostrar);
			}
			else {
				ampm = "PM";
				horaMostrar = horaMostrar - 12;		
			}
			
			stringHora="Fecha: "+dia+"/"+mes+"/"+anho+" "+horaMostrar+":"+minutosMostrar+":"+segundosMostrar+ampm;
			//stringHora=horaMostrar+":"+minutosMostrar+":"+segundosMostrar;
			$("#Hora").text(stringHora);
		
			setTimeout("mostrarHora()",1000);
		}
		
		function disponer_capilla(accion, capilla, fecha, hora, username) {
			var url = "disponer_capilla.php?accion="+accion+"&capilla="+capilla+"&fecha="+fecha+"&hora="+hora+"&username="+username;
			window.location.href = url;
		}

		function NoteLoad(id) {
			var parametros = {
				"id" : id
			}

			$.ajax({
				data: parametros,
				url: 'CargarNotas.php',
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
function formatear_fecha($fecha) {
	$ff = explode("/", $fecha);
	
	$fecha = mktime(0, 0, 0, (int) $ff[1], (int) $ff[0], (int) $ff[2]);
	$fecha = date("l, d - F - Y", $fecha);
	$fecha = str_replace(" - ", " de ", $fecha);
	
	$dias = array('Domingo', 'Lunes', 'Martes', 'Mi&eacute;rcoles', 'Jueves', 'Viernes', 'S&aacute;bado');
	$days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
	
	$meses =  array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
	$months =  array('January','February','March','April','May','June','July','August','September','October','November','December');
	
	for($i=0; $i<count($dias); $i++) $fecha = str_replace($days[$i], $dias[$i], $fecha);
	for($i=0; $i<count($meses); $i++) $fecha = str_replace($months[$i], $meses[$i], $fecha);
	return $fecha;
}

?>
