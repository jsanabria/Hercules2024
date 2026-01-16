<?php
include 'includes/conexBD.php';
date_default_timezone_set('America/La_Paz');

$username = $_GET["username"];
$reserva = "N";

$sql = "SELECT a.reserva FROM userlevels a JOIN sco_user b ON b.`level` = a.userlevelid WHERE b.username = ?;";
if ($stmt = $link->prepare($sql)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($reserva_db);
    if ($stmt->fetch()) {
        $reserva = $reserva_db; // Asigna el valor obtenido de la base de datos
    }
    $stmt->close();
} else {
    die("Error al preparar la consulta de reserva: " . $link->error);
}

$swmt = isset($_REQUEST["swmt"])?$_REQUEST["swmt"]:"AUTO";
if(isset($_REQUEST["fecha_inicio"])) {
	$fc = explode("/", $_REQUEST["fecha_inicio"]);
	$_fecha = $fc[2] . "-" . $fc[1] . "-" . $fc[0];
}
$fecha_inicio = isset($_REQUEST["fecha_inicio"])?$_fecha:date("Y-m-d");

$fc = explode("-", $fecha_inicio);
$_fecha = $fc[2] . "/" . $fc[1] . "/" . $fc[0];

// Inicializamos el array $bloque_horario para asegurarnos de que siempre esté definido.
$bloque_horario = [];

$sql = "SELECT hora, bloque FROM sco_bloque_horario WHERE servicio_tipo = 'SEPE';";
if ($stmt = $link->prepare($sql)) {
    $stmt->execute();
    $result = $stmt->get_result();

    // Itera sobre los resultados y los almacena en el array asociativo.
    while ($row = $result->fetch_assoc()) {
        $bloque_horario[$row["hora"]] = $row["bloque"];
    }

    // Libera la memoria del resultado.
    $result->free();
    // Cierra el statement.
    $stmt->close();
} else {
    die("Error al preparar la consulta de bloque horario: " . $link->error);
}


// Inicializamos el array $bh para asegurarnos de que siempre esté definido.
$bh = [];

$sql = "SELECT DISTINCT bloque FROM sco_bloque_horario WHERE servicio_tipo = 'SEPE' AND bloque <> 'EXCEP';";
if ($stmt = $link->prepare($sql)) {
    // No hay parámetros para vincular en este caso.
    $stmt->execute();

    // Obtiene el conjunto de resultados.
    $result = $stmt->get_result();

    // Itera sobre los resultados y los almacena en el array.
    while ($row = $result->fetch_assoc()) {
        $bh[] = $row["bloque"];
    }

    // Libera la memoria del resultado.
    $result->free();
    // Cierra el statement.
    $stmt->close();
} else {
    die("Error al preparar la consulta de bloques distintos: " . $link->error);
}
$bh[] = "EXCEP";


// Inicializamos el array $estatus_exp para asegurarnos de que siempre esté definido.
$estatus_exp = [];
$sql = "SELECT Nstatus, color, nombre FROM sco_estatus WHERE activo = 'S' ORDER BY Nstatus;";
if ($stmt = $link->prepare($sql)) {
    // No hay parámetros para vincular en este caso.
    $stmt->execute();

    // Obtiene el conjunto de resultados.
    $result = $stmt->get_result();

    // Itera sobre los resultados y los almacena en el array.
    while ($fila = $result->fetch_assoc()) { // fetch_assoc() ya devuelve un array asociativo
        $estatus_exp[] = $fila;
    }

    // Libera la memoria del resultado.
    $result->free();
    // Cierra el statement.
    $stmt->close();
} else {
    die("Error al preparar la consulta de estatus activos: " . $link->error);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pizarra de Inhumaciones y Exhumaciones</title>
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
			<?php 
			foreach ($estatus_exp as $key => $value) {
				echo '<a href="#" class="easyui-linkbutton" style="width:150px; color:#ffffff; background:' . $value["color"] . ';"><b>' . $value["nombre"] . '</b></a> ';
			}
			?>
			&nbsp;
			<!--<a href="#" class="easyui-linkbutton" style="width:120px; color:#62b0e3; background:#d9edf7;"><b>SIN ESTATUS</b></a>-->
            <input class="easyui-switchbutton" id="sw" name="sw" data-options="onText:'AUTO',offText:'MANU'" value="AUTO" <?php echo ($swmt=="AUTO"?"checked":""); ?>>
            <input type="hidden" id="swmt" name="swmt" size="6" value="<?php echo $swmt ?>" />
            &nbsp; 
            <input id="fecha_inicio" name="fecha_inicio" labelPosition="top" style="width:120px;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo $_fecha; ?>">
            &nbsp;
		</div>
	</div>
    <div id="tt" class="easyui-tabs" style="width:100%;">
    	<!-- Inicio Asignación de Capilla -->
        <div title="Programaci&oacute;n de Inhumaciones y Exhumaciones para el d&iacute;a: <?php echo formatear_fecha($_fecha); ?>" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:1200px;height:100%;"> 
                <div class="right">
				    <div id="dlg" class="easyui-dialog" title="Basic Dialog" data-options="iconCls:'icon-save'" style="width:800px;height:450px;padding:10px">
				        The dialog content.
				    </div>                	
                    <table>
                        <tr>
                            <td class="title"><div style="width:50px"><b>Hora</b></div></td>
                            <td class="title"><div style="width:150px"><b>Nombre Difunto</b></div></td>
                            <td class="title"><div style="width:150px"><b>Apellido Difunto</b></div></td>
                            <td class="title"><div style="width:100px"><b>Servicio</b></div></td>
                            <td class="title"><div style="width:200px"><b>Capilla / Funeraria</b></div></td>
                            <td class="title"><div style="width:100px"><b>Salida/Parcela</b></div></td>
                            <td class="title"><div style="width:150px"><b>Causa Fallecimiento</b></div></td>
                            <td class="title"><div style="width:70px"><b>#Exp.</b></div></td>
                            <td class="title"><div style="width:30px"><b>Nota</b></div></td>
                            <td class="title"><div style="width:30px"><b>Pago</b></div></td>
                        </tr>

                        <?php

                        // --- 1. Obtener la cantidad de bloques xx_cant ---
                        $xx_cant = 0; // Valor por defecto
                        $sql_parametro = "SELECT valor4 AS cantidad FROM sco_parametro WHERE codigo = ?;";
                        if ($stmt_parametro = $link->prepare($sql_parametro)) {
                            $param_codigo = '019';
                            $stmt_parametro->bind_param("s", $param_codigo);
                            $stmt_parametro->execute();
                            $stmt_parametro->bind_result($cantidad_db);
                            if ($stmt_parametro->fetch()) {
                                $xx_cant = (int) $cantidad_db;
                            }
                            $stmt_parametro->close();
                        } else {
                            error_log("Error al preparar la consulta de parámetro '019': " . $link->error);
                        }

                        // --- 2. Consulta Principal y Procesamiento de Datos ---
                        $sql_principal = "
                            SELECT
                                DATE_FORMAT(ord.hora_fin, '%H:%i') AS pauta,
                                ord.Norden,
                                exp.Nexpediente,
                                tis.nombre AS tipo,
                                ser.nombre AS servicio,
                                exp.nombre_contacto,
                                exp.telefono_contacto1,
                                exp.telefono_contacto2,
                                exp.nombre_fallecido,
                                exp.apellidos_fallecido,
                                (SELECT DATE_FORMAT(a.fecha_fin, '%d-%m') FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 0,1) AS fecha_fin,
                                (SELECT DATE_FORMAT(a.hora_fin, '%h:%i%p') FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 0,1) AS hora_fin,
                                IF(ord.espera_cenizas='S','SI','NO') AS espera_cenizas,
                                (SELECT
                                    b.nombre
                                FROM
                                    sco_orden a
                                    JOIN sco_servicio b ON b.Nservicio = a.servicio
                                WHERE
                                    a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 0,1
                                ) AS capilla,
                                pro.nombre AS proveedor,
                                IF(RTRIM(LTRIM(exp.causa_ocurrencia))='OTRO', exp.causa_otro, exp.causa_ocurrencia) AS causa_ocurrencia,
                                fun.nombre AS funeraria,
                                IFNULL(LENGTH(LTRIM(exp.nota)), 0) AS nota,
                                (SELECT COUNT(*) FROM sco_nota WHERE expediente = exp.Nexpediente) AS notas,
                                DATE_FORMAT(ord.hora_fin, '%h:%i:%p') AS hora_servicio,
                                exp.estatus,
                                exp.parcela,
                                IF(LTRIM(RTRIM(IFNULL(exp.factura, ''))) = '', 'NO', IFNULL((SELECT GROUP_CONCAT(factura SEPARATOR ',') FROM sco_expediente_cia WHERE expediente = ord.expediente AND servicio_tipo = 'SEPE'), 'SI')) AS pago,
                                exp.cedula_fallecido
                            FROM
                                sco_orden AS ord
                                JOIN sco_expediente AS exp ON exp.Nexpediente = ord.expediente
                                LEFT OUTER JOIN sco_servicio_tipo AS tis ON tis.Nservicio_tipo = ord.servicio_tipo
                                LEFT OUTER JOIN sco_servicio AS ser ON ser.Nservicio = ord.servicio
                                LEFT OUTER JOIN sco_proveedor AS pro ON pro.Nproveedor = ord.proveedor
                                LEFT OUTER JOIN sco_proveedor AS fun ON fun.Nproveedor = IF(ord.capilla=1,129,ord.capilla)
                            WHERE
                                ord.paso = 2 AND ord.servicio_tipo IN ('SEPE','EXHU') AND
                                DATE_FORMAT(ord.fecha_fin, '%Y-%m-%d') = ?
                            ORDER BY
                                ord.fecha_fin, ord.hora_fin;
                        ";

                        $cremaciones = 0;
                        $ids = []; // Array para almacenar Nexpediente
                        $hora = ""; // Variable para rastrear el bloque horario actual
                        $count = 1; // Contador de elementos dentro de un bloque
                        $blackboard_string = ""; // Cadena HTML para el bloque actual
                        $blackboard = []; // Array asociativo para almacenar las cadenas HTML por cada bloque

                        if ($stmt_principal = $link->prepare($sql_principal)) {
                            $stmt_principal->bind_param("s", $fecha_inicio); // Vincula $fecha_inicio de forma segura
                            $stmt_principal->execute();
                            $result_principal = $stmt_principal->get_result();

                            while ($row = $result_principal->fetch_assoc()) {
                                // --- Escapar todas las salidas de la base de datos para prevenir XSS ---
                                $safe_pauta = htmlspecialchars($row["pauta"]);
                                $safe_Norden = htmlspecialchars($row["Norden"]);
                                $safe_Nexpediente = htmlspecialchars($row["Nexpediente"]);
                                $safe_tipo = htmlspecialchars($row["tipo"] ?? '');
                                $safe_servicio = htmlspecialchars($row["servicio"] ?? '');
                                $safe_nombre_contacto = htmlspecialchars($row["nombre_contacto"] ?? '');
                                $safe_telefono_contacto1 = htmlspecialchars($row["telefono_contacto1"] ?? '');
                                $safe_telefono_contacto2 = htmlspecialchars($row["telefono_contacto2"] ?? '');
                                $safe_nombre_fallecido = htmlspecialchars($row["nombre_fallecido"] ?? '');
                                $safe_apellidos_fallecido = htmlspecialchars($row["apellidos_fallecido"] ?? '');
                                $safe_fecha_fin = htmlspecialchars($row["fecha_fin"] ?? '');
                                $safe_hora_fin = htmlspecialchars($row["hora_fin"] ?? '');
                                $safe_espera_cenizas = htmlspecialchars($row["espera_cenizas"] ?? '');
                                $safe_capilla = htmlspecialchars($row["capilla"] ?? '');
                                $safe_proveedor = htmlspecialchars($row["proveedor"] ?? '');
                                $safe_causa_ocurrencia = htmlspecialchars($row["causa_ocurrencia"] ?? '');
                                $safe_funeraria = htmlspecialchars($row["funeraria"] ?? '');
                                $safe_nota_length = htmlspecialchars($row["nota"] ?? ''); // Es una longitud, ya es seguro
                                $safe_notas_count = htmlspecialchars($row["notas"] ?? ''); // Es un conteo, ya es seguro
                                $safe_hora_servicio = htmlspecialchars($row["hora_servicio"] ?? '');
                                $safe_estatus = htmlspecialchars($row["estatus"] ?? '');
                                $safe_parcela = htmlspecialchars($row["parcela"] ?? '');
                                $safe_pago = htmlspecialchars($row["pago"] ?? '');
                                $safe_cedula_fallecido = htmlspecialchars($row["cedula_fallecido"] ?? '');
                                // ---------------------------------------------------------------------

                                // Lógica para rellenar celdas vacías cuando cambia el bloque horario
                                $current_block_name = $bloque_horario[$safe_pauta] ?? ''; // Manejo de clave no existente
                                if ($hora !== $current_block_name && $hora !== "") {
                                    if ($count <= $xx_cant) {
                                        for ($i = $count; $i <= $xx_cant; $i++) {
                                            $blackboard_string .= '<tr><td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                            $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td></tr>';
                                        }
                                    }
                                    $count = 1;
                                    $blackboard[$hora] = $blackboard_string; // Almacena la cadena del bloque anterior
                                    $blackboard_string = ""; // Reinicia la cadena para el nuevo bloque
                                }

                                // Construye la fila HTML para el registro actual
                                $blackboard_string .= '<tr>';
                                $drop_class = "drop" . $safe_estatus;

                                if ($hora !== $current_block_name) {
                                    $blackboard_string .= '<td class="' . $drop_class . '"><div><b><i>' . $current_block_name . '</i></b></div></td>';
                                    $hora = $current_block_name; // Actualiza el bloque horario actual
                                } else {
                                    $blackboard_string .= '<td class="' . $drop_class . '"><div></div></td>'; // Celda vacía si es el mismo bloque
                                }

                                $blackboard_string .= '<td class="' . $drop_class . '"><div><a onclick="js:alert(\'Hora Servicio: ' . $safe_hora_servicio . '\')"><b><i>' . $safe_nombre_fallecido . "<br>" . $safe_cedula_fallecido . '</i></b></a></div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div><b><i>' . $safe_apellidos_fallecido . "<br>" . $safe_cedula_fallecido . '</i></b></div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div><b><i>' . $safe_servicio . '</i></b></div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div>' . (trim($safe_capilla) === "" ? "<b>" . $safe_funeraria . "</b>" : $safe_capilla) . '</div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div>' . $safe_fecha_fin . " " . $safe_hora_fin . '<br>' . $safe_parcela . '</div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div><b><i>' . $safe_causa_ocurrencia . '</i></b></div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div><a href="../ScoExpedienteList?id_exp=' . $safe_Nexpediente . '" target="_blank">' . $safe_Nexpediente . '</a></div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div>' . (((int)$safe_nota_length > 0 || (int)$safe_notas_count > 0) ? '<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$(\'#dlg\').dialog(\'open\');NoteLoad(' . $safe_Nexpediente . ');">Nota</a>' : '') . '</div></td>';
                                $blackboard_string .= '<td class="' . $drop_class . '"><div><b><i>' . $safe_pago . '</i></b></div></td></tr>';

                                $ids[] = $safe_Nexpediente;
                                $count++;
                                $cremaciones++;
                            }

                            // Libera la memoria del resultado y cierra el statement
                            $result_principal->free();
                            $stmt_principal->close();

                            // --- Relleno final para el último bloque (después de salir del bucle while) ---
                            if ($count <= $xx_cant) {
                                for ($i = $count; $i <= $xx_cant; $i++) {
                                    $blackboard_string .= '<tr><td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td></tr>';
                                }
                            }
                            // Almacena la cadena del último bloque procesado
                            if ($hora !== "") { // Solo si se procesó al menos una fila y $hora fue establecido
                                $blackboard[$hora] = $blackboard_string;
                            }

                        } else {
                            error_log("Error al preparar la consulta principal: " . $link->error);
                        }

                        // --- Generación final del HTML de la pizarra ---
                        // Definición del separador de bloques
                        $blackboard_separator = '<tr><td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                        $blackboard_separator .= '<td class="drop5"><div>--</div></td></tr>';

                        $count = 1; // Reiniciar el contador para este bucle final de renderizado
                        foreach ($bh as $key => $value) {
                            $safe_value = htmlspecialchars($value); // Escapar el nombre del bloque para HTML

                            if (empty($blackboard[$safe_value])) { // Si no hay datos para este bloque en $blackboard
                                if ($count <= $xx_cant) {
                                    for ($i = $count; $i <= $xx_cant; $i++) {
                                        echo '<tr><td class="drop"><div><b><i>' . ($i == 1 ? $safe_value : '&nbsp;') . '</i></b></div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td>';
                                        echo '<td class="drop"><div>&nbsp;</div></td></tr>';
                                    }
                                }
                                $count = 1;
                            } else {
                                echo $blackboard[$safe_value]; // Imprime el HTML pre-generado para el bloque
                            }
                            // Imprime el separador, excepto para el bloque "EXCEP"
                            echo ($safe_value === "EXCEP" ? "" : $blackboard_separator);
                        }
                        ?>

                            <tr><td colspan="10"><b>Total Inhumaciones Programadas: <?php echo $cremaciones; ?></b></td></tr>
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
				<?php 
				foreach ($estatus_exp as $key => $value) {
				?>
				.right td.drop<?php echo $value["Nstatus"]; ?>{
					color:#000000;
				    background:<?php echo $value["color"]; ?>;
				    width:100px;
				}
				<?php 
				}
                ?>
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
					var url = "PizarraInhumaciones.php?swmt=AUTO&username=<?php echo $username; ?>";
					window.location.href = url;
				}
			}
		})

		$('#fecha_inicio').datebox({
			onChange: function(date) {
				var xfecha = $('#fecha_inicio').textbox('getValue');
				var xswmt = $('#swmt').val();
				
				var url = "PizarraInhumaciones.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&username=<?php echo $username; ?>";
				window.location.href = url;
			}
		});

		<?php foreach ($ids as $value) { ?>
			$('#state_<?php echo trim($value); ?>').combobox({
				onSelect: function() {
					var xfecha = $('#fecha_inicio').textbox('getValue');
					var xswmt = $('#swmt').val();

					if(confirm("Seguro que desea cambiar el estatus de INHUMACION del Exp # <?php echo trim($value); ?>")) {
						var url = "sepelio_estatus_actualizar.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&exp=<?php echo trim($value); ?>&sta=" + $("#state_<?php echo trim($value); ?>").combobox('getValue') + "&username=<?php echo $username; ?>";
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
