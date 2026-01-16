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
        $reserva = $reserva_db; // Asignar el valor recuperado de la base de datos
    }
    $stmt->close();
} else {
    die("Error al preparar la consulta de reserva de usuario: " . $link->error);
}

$swmt = isset($_REQUEST["swmt"])?$_REQUEST["swmt"]:"AUTO";
if(isset($_REQUEST["fecha_inicio"])) {
	$fc = explode("/", $_REQUEST["fecha_inicio"]);
	$_fecha = $fc[2] . "-" . $fc[1] . "-" . $fc[0];
}
$fecha_inicio = isset($_REQUEST["fecha_inicio"])?$_fecha:date("Y-m-d");

$fc = explode("-", $fecha_inicio);
$_fecha = $fc[2] . "/" . $fc[1] . "/" . $fc[0];


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pizarra de Cremaciones e Mascotas...</title>
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
			$estatus = [];

			// Prepara la consulta para obtener los parámetros de estatus.
			// Usamos prepared statements incluso para consultas estáticas para mantener consistencia y seguridad.
			$sql = "SELECT valor1 AS estatus, valor2 AS nombre, valor4 AS estilo FROM sco_parametro WHERE codigo = ? ORDER BY valor3;";

			if ($stmt = $link->prepare($sql)) {
			    $param_codigo = '026';
			    $stmt->bind_param("s", $param_codigo); // Vincula el código '026' como string.
			    $stmt->execute();

			    $result = $stmt->get_result();

			    while ($row = $result->fetch_assoc()) {
			        // Escapar todas las salidas para prevenir XSS (Cross-Site Scripting)
			        $safe_estatus_val = htmlspecialchars($row["estatus"]);
			        $safe_nombre = htmlspecialchars($row["nombre"]);
			        $safe_estilo = htmlspecialchars($row["estilo"], ENT_QUOTES, 'UTF-8'); // Usar ENT_QUOTES para comillas simples y dobles

			        // Genera el HTML del enlace
			        echo '<a href="#" class="easyui-linkbutton" style="width:120px; ' . $safe_estilo . '"><b>' . $safe_nombre . '</b></a>';

			        // Almacena el estatus y el nombre en el array
			        $estatus[$safe_estatus_val] = $safe_nombre;
			    }

			    $result->free(); // Libera la memoria del resultado
			    $stmt->close(); // Cierra el statement
			} else {
			    die("Error al preparar la consulta de sco_parametro (codigo 026): " . $link->error);
			}
			//print_r($estatus);
			?>
            <input class="easyui-switchbutton" id="sw" name="sw" data-options="onText:'AUTO',offText:'MANU'" value="AUTO" <?php echo ($swmt=="AUTO"?"checked":""); ?>>
            <input type="hidden" id="swmt" name="swmt" size="6" value="<?php echo $swmt ?>" />
            &nbsp; 
            <input id="fecha_inicio" name="fecha_inicio" label="Select Date:" labelPosition="top" style="width:120px;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo $_fecha; ?>">
		</div>
	</div>
    <div id="tt" class="easyui-tabs" style="width:100%;">
    	<!-- Inicio Asignación de Capilla -->
        <div title="Programaci&oacute;n de Cremaciones de Mascotas para el d&iacute;a: <?php echo formatear_fecha($_fecha); ?>" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:1200px;height:100%;"> 
                <div class="right">
				    <div id="dlg" class="easyui-dialog" title="Basic Dialog" data-options="iconCls:'icon-save'" style="width:800px;height:450px;padding:10px">
				        The dialog content.
				    </div>                	
                    <table>
                        <tr>
                            <td class="title"><div style="width:50px"><b>Hora</b></div></td>
                            <td class="title"><div style="width:150px"><b>Nombre Mascota</b></div></td>
                            <td class="title"><div style="width:100px"><b>Raza</b></div></td>
                            <td class="title"><div style="width:100px"><b>Tipo</b></div></td>
                            <td class="title"><div style="width:100px"><b>Color</b></div></td>
                            <td class="title"><div style="width:150px"><b>Procedencia</b></div></td>
                            <td class="title"><div style="width:150px"><b>Due&ntilde;o</b></div></td>
                            <td class="title"><div style="width:50px"><b>Tarifa</b></div></td>
                            <td class="title"><div style="width:50px"><b>Factura...</b></div></td>
                            <td class="title"><div style="width:100px"><b>Estatus</b></div></td>
                            <td class="title"><div style="width:30px"><b>#Exp.</b></div></td>
                            <td class="title"><div style="width:30px"><b>Nota</b></div></td>
                        </tr>

						<?php
						// Asegúrate de que $link es tu objeto de conexión mysqli,
						// y que $fecha_inicio y $estatus (array de estatus) están definidos y listos para usar.

						$cremaciones = 0;
						$ids = []; // Array para almacenar Nmascota
						$hora = ""; // Variable que en el original no se usa mucho aquí, pero la mantengo si tiene algún uso posterior
						$count = 1;
						$blackboard_string_accumulator = ""; // Acumulador para las filas HTML

						// --- 1. Consulta Principal: Obtener datos de mascotas ---
						$sql_mascotas = "
						    SELECT
						        DATE_FORMAT(a.fecha_cremacion, '%d-%m-%Y') AS fecha_cremacion,
						        DATE_FORMAT(a.hora_cremacion, '%H:%i') AS pauta,
						        a.nombre_mascota,
						        a.nombre_contratante,
						        a.raza,
						        IF(a.tipo = 'Otro', a.tipo_otro, a.tipo) AS tipo,
						        a.color,
						        a.procedencia,
						        a.factura,
						        a.estatus, -- Este es el estatus directamente de sco_mascota, pero luego se sobrescribe
						        a.Nmascota,
						        IFNULL(LTRIM(a.nota), '') AS nota,
						        a.tarifa,
						        a.costo
						    FROM
						        sco_mascota a
						    WHERE
						        a.fecha_cremacion <= ? AND IFNULL(a.estatus, 'P1') <> 'AN'
						    ORDER BY a.fecha_cremacion DESC, a.hora_cremacion DESC
						    LIMIT 0, 50;
						";

						if ($stmt_mascotas = $link->prepare($sql_mascotas)) {
						    // Vincula el parámetro para la fecha de forma segura
						    $fecha_fin_param = $fecha_inicio . ' 23:59:59';
						    $stmt_mascotas->bind_param("s", $fecha_fin_param);
						    $stmt_mascotas->execute();
						    $result_mascotas = $stmt_mascotas->get_result();

						    while ($row_mascota = $result_mascotas->fetch_assoc()) {
						        $current_row_html = '<tr>'; // Inicio de la fila HTML para el registro actual

						        // --- 2. Primera Consulta Anidada: Obtener el último estatus de la mascota ---
						        $my_est = ''; // Reinicializar para cada mascota
						        $sql_last_estatus = "SELECT estatus FROM sco_mascota_estatus WHERE mascota = ? ORDER BY fecha_hora DESC LIMIT 0,1;";
						        if ($stmt_last_estatus = $link->prepare($sql_last_estatus)) {
						            $stmt_last_estatus->bind_param("i", $row_mascota["Nmascota"]); // Asume Nmascota es un entero
						            $stmt_last_estatus->execute();
						            $stmt_last_estatus->bind_result($last_estatus_db);
						            if ($stmt_last_estatus->fetch()) {
						                $my_est = $last_estatus_db;
						            }
						            $stmt_last_estatus->close();
						        } else {
						            error_log("Error al preparar la consulta de último estatus para mascota " . $row_mascota["Nmascota"] . ": " . $link->error);
						        }

						        // --- 3. Determinar la clase CSS 'drop' basada en el estatus ---
						        $drop_class = "drop"; // Valor por defecto
						        switch ($my_est) {
						            case "P1":
						                $drop_class = "drop2";
						                break;
						            case "P2":
						                $drop_class = "drop3";
						                break;
						            case "P3":
						                $drop_class = "drop4";
						                break;
						            case "P4":
						                $drop_class = "drop7";
						                break;
						            case "P5":
						                $drop_class = "drop6";
						                break;
						        }

						        // --- 4. Generar celdas HTML con datos escapados para XSS ---
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["fecha_cremacion"] ?? '') . " " . htmlspecialchars($row_mascota["pauta"] ?? '') . '</i></b></div></td>';
						        // 'onclick' debe escapar para JS, json_encode es el método más seguro
						        $onclick_pauta = 'js:alert(\'Hora Servicio: ' . json_encode($row_mascota["pauta"]) . '\')';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><a onclick="' . htmlspecialchars($onclick_pauta) . '"><b><i>' . htmlspecialchars($row_mascota["nombre_mascota"] ?? '') . '</i></b></a></div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["raza"]) . '</i></b></div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div>' . htmlspecialchars($row_mascota["tipo"]) . '</div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div>' . htmlspecialchars($row_mascota["color"]) . '</div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["procedencia"]) . '</i></b></div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["nombre_contratante"]) . '</i></b></div></td>';

						        // Formateo del costo con number_format
						        $formatted_costo = number_format((float)$row_mascota["costo"], 2, ",", ".");
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["tarifa"]) . ' Bs.' . $formatted_costo . '</i></b></div></td>';
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><b><i>' . htmlspecialchars($row_mascota["factura"]) . '</i></b></div></td>';

						        // --- 5. Segunda Consulta Anidada: Obtener otros estatus históricos de la mascota ---
						        $my_ar = [];
						        $sql_other_estatus = "SELECT estatus FROM sco_mascota_estatus WHERE mascota = ? ORDER BY fecha_hora DESC LIMIT 1,10;";
						        if ($stmt_other_estatus = $link->prepare($sql_other_estatus)) {
						            $stmt_other_estatus->bind_param("i", $row_mascota["Nmascota"]); // Asume Nmascota es un entero
						            $stmt_other_estatus->execute();
						            $result_other_estatus = $stmt_other_estatus->get_result();
						            while ($row_other = $result_other_estatus->fetch_assoc()) {
						                $my_ar[] = $row_other["estatus"];
						            }
						            $result_other_estatus->free();
						            $stmt_other_estatus->close();
						        } else {
						            error_log("Error al preparar la consulta de otros estatus para mascota " . $row_mascota["Nmascota"] . ": " . $link->error);
						        }

						        // --- 6. Generar el HTML del Combobox de estatus ---
						        $my_status_html = '<div style="margin-bottom:0px">';
						        $combobox_id = 'state_' . htmlspecialchars($row_mascota["Nmascota"]); // Escapar ID para HTML
						        $my_status_html .= '<select class="easyui-combobox" id="' . $combobox_id . '" name="' . $combobox_id . '" label="State:" labelPosition="top" style="width:95%;" data-options="panelHeight:\'auto\',editable:false">';
						        $my_status_html .= '<option value="" ' . ($my_est === "" ? "selected" : "") . '></option>';

						        foreach ($estatus as $key_est => $value_est) {
						            $sw2 = true; // Reiniciar flag para cada opción
						            foreach ($my_ar as $value_ar) {
						                if (trim($key_est) === trim($value_ar)) {
						                    $sw2 = false;
						                    break;
						                }
						            }
						            if ($sw2) {
						                $selected_attr = (trim($my_est) === trim($key_est) ? "selected" : "");
						                // Escapar key y value para la opción
						                $my_status_html .= '<option value="' . htmlspecialchars($key_est) . '" ' . $selected_attr . '>' . htmlspecialchars($value_est) . '</option>';
						            }
						        }
						        $my_status_html .= '</select>';
						        $my_status_html .= '</div>';

						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div>' . $my_status_html . '</div></td>';

						        // --- 7. Generar enlaces adicionales y cerrar la fila ---
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div><a href="../ScoMascotaList?id_exp=' . htmlspecialchars($row_mascota["Nmascota"]) . '" target="_blank">' . htmlspecialchars($row_mascota["Nmascota"]) . '</a></div></td>';

						        // onclick para la nota, usando json_encode para Nmascota
						        $current_row_html .= '<td class="' . htmlspecialchars($drop_class) . '"><div>' . htmlspecialchars($row_mascota["nota"] ?? '') . '</div></td>';
						        $current_row_html .= '</tr>'; // Cierre de la fila HTML

						        // Añade la fila construida al acumulador
						        $blackboard_string_accumulator .= $current_row_html;

						        $ids[] = $row_mascota["Nmascota"];
						        $count++;
						        $cremaciones++;
						    }

						    $result_mascotas->free();
						    $stmt_mascotas->close();

						} else {
						    error_log("Error al preparar la consulta principal de mascotas: " . $link->error);
						}

						// Finalmente, imprime todas las filas acumuladas
						echo $blackboard_string_accumulator;

						?>

                            <tr><td colspan="12"><b>Total Cremaciones de Mascotas Programadas: <?php echo $cremaciones; ?></b></td></tr>
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
					var url = "PizarraCremacionMascota.php?swmt=AUTO&username=<?php echo $username; ?>";
					window.location.href = url;
				}
			}
		})

		$('#fecha_inicio').datebox({
			onChange: function(date) {
				var xfecha = $('#fecha_inicio').textbox('getValue');
				var xswmt = $('#swmt').val();
				
				var url = "PizarraCremacionMascota.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&username=<?php echo $username; ?>";
				window.location.href = url;
			}
		});

		<?php foreach ($ids as $value) { ?>
			$('#state_<?php echo trim($value); ?>').combobox({
				onSelect: function() {
					var xfecha = $('#fecha_inicio').textbox('getValue');
					var xswmt = $('#swmt').val();

					if(confirm("Seguro que desea cambiar el estatus de CREMACION del Exp # <?php echo trim($value); ?>")) {
						var url = "MascotasEstatusActualizar.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&exp=<?php echo trim($value); ?>&sta=" + $("#state_<?php echo trim($value); ?>").combobox('getValue') + "&username=<?php echo $username; ?>";
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
				url: 'CargarNotas2.php',
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
