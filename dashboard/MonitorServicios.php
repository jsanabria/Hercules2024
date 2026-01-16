<?php
include 'includes/conexBD.php';
date_default_timezone_set('America/La_Paz');


$swmt = isset($_REQUEST["swmt"])?$_REQUEST["swmt"]:"AUTO";
$fecha_inicio = ($swmt=="AUTO"?date("d/m/Y"):(isset($_REQUEST["fecha_inicio"])?$_REQUEST["fecha_inicio"]:date("d/m/Y")));
$hora_inicio = ($swmt=="AUTO"?date("H:i:s"):(isset($_REQUEST["hora_inicio"])?$_REQUEST["hora_inicio"]:date("H:i:s")));

//die("$swmt $fecha_inicio $hora_inicio");
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
    <meta http-equiv="refresh" content="120">
</head>
<body onLoad="js:mostrarHora();">
<?php echo '<div style="background-color:#123E1C; color:#ffffff; text-align:right; width:100%;"><b><div id="Hora"></div></b></div>'; ?>
    <div id="tt" class="easyui-tabs" style="width:100%;height100%">
    	<!-- Inicio Asignación de Capilla -->
        <div title="Monitoreo de Servicios (<?php echo formatear_fecha($fecha_inicio) . " -- " . ($swmt=="AUTO"?date("h:iA"):date("h:iA", strtotime($_REQUEST["hora_inicio"]))); ?>)" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:800px;"> 
                <div class="right">
					<?php
					// First Query: Get Chapel Types
					$sql_capillas = "SELECT
					                     Nservicio_tipo, nombre AS capillas
					                 FROM
					                     sco_servicio_tipo
					                 WHERE
					                     SUBSTRING(Nservicio_tipo,1,3) = 'CAP'
					                 ORDER BY capillas ASC;";

					$result_capillas = $link->query($sql_capillas); // Execute query using MySQLi POO

					if ($result_capillas) { // Check if query was successful
					    while($row01 = $result_capillas->fetch_assoc()) { // Fetch results as an associative array
					?>
					        <div><b><?php echo htmlspecialchars($row01["capillas"]); ?></b></div>
					        <table>
					            <tr>
					                <td class="blank"></td>
					                <td class="title"><div style="width:80px">Tipo Solicitud</div></td>
					                <td class="title"><div style="width:100px"><b>Nombre</b></div></td>
					                <td class="title"><div style="width:100px"><b>Apellido</b></div></td>
					                <td class="title"><div style="width:90px">D&iacute;a Inicio Velaci&oacute;n</div></td>
					                <td class="title"><div style="width:50px">Hora</td>
					                <td class="title"><div style="width:90px">D&iacute;a Fin Velaci&oacute;n</div></td>
					                <td class="title"><div style="width:50px">Hora</div></td>
					                <td class="title"><div style="width:80px">Oficio R</div></td>
					                <td class="title"><div style="width:80px"><b>Servicio</b></div></td>
					                <td class="title"><div style="width:80px"><b>Fecha Servicio</b></div></td>
					                <td class="title"><div style="width:100px">Permisos</div></td>
					            </tr>
					            <?php
					            // Second Query (inside loop): Get Services for the current Chapel Type
					            // Use prepared statements for security, even if input comes from DB
					            $sql_servicios = "SELECT
					                                  Nservicio, nombre AS capilla
					                              FROM
					                                  sco_servicio
					                              WHERE
					                                  tipo = ? AND activo = 'S'
					                              ORDER BY secuencia ASC;";

					            // Prepare the statement
					            if ($stmt_servicios = $link->prepare($sql_servicios)) {
					                // Bind the parameter: 's' for string, $row01["Nservicio_tipo"] is the value
					                $stmt_servicios->bind_param("s", $row01["Nservicio_tipo"]);
					                $stmt_servicios->execute();          // Execute the prepared statement
					                $result_servicios = $stmt_servicios->get_result(); // Get the result set

					                while($row = $result_servicios->fetch_assoc()) { // Fetch results as an associative array
					            ?>
					                    <tr>
					                        <td class="time"><div style="width:80px"><?php echo htmlspecialchars(str_replace("MONUMENTAL", "MON.", str_replace("CAPILLA", "", strtoupper($row["capilla"])))); ?></div></td>
					                        <?php
					                        // Assuming disponibilidad() function is defined elsewhere and takes $link as a parameter
					                        // (As per previous refactorings, $link should be the first argument to disponibilidad)
					                        $data = disponibilidad($link, $fecha_inicio, $hora_inicio, $row["Nservicio"]); // Added missing parameters based on previous context

					                        echo '<td class="drop"><div>' . htmlspecialchars($data["TipoSolicitud"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div><b><i><a href="../ScoExpedienteList?id_exp=' . $data["expediente"] . '" target="_blank">' . htmlspecialchars($data["nombre_fallecido"] ?? '') . '</a></i></b></div></td>';
					                        echo '<td class="drop"><div><b><i><a href="../ScoExpedienteList?id_exp=' . $data["expediente"] . '" target="_blank">' . htmlspecialchars($data["apellidos_fallecido"] ?? '') . '</a></i></b></div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["fecha_inicio"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["hora_inicio"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["fecha_fin"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["hora_fin"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["oficio_r"] ?? '') . '</div></td>';
					                        echo '<td class="drop"><div><b><i>' . htmlspecialchars(substr($data["servicio"] ?? '', 0, 4)) . "<br>" . htmlspecialchars($data["parcela"] ?? '') . '</i></b></div></td>';
					                        echo '<td class="drop"><div><b><i>' . htmlspecialchars($data["sepelio_cremacion"] ?? '') . '</i></b></div></td>';
					                        echo '<td class="drop"><div>' . htmlspecialchars($data["permiso"] ?? '') . '</div></td>';
					                        ?>
					                    </tr>
					            <?php
					                }
					                $result_servicios->free(); // Free the result set memory
					                $stmt_servicios->close();  // Close the prepared statement
					            } else {
					                error_log("Error al preparar la consulta de servicios: " . $link->error);
					                echo "<tr><td colspan='12'>Error al cargar servicios.</td></tr>";
					            }
					            ?>
					        </table>
					        <br />
					<?php
					    }
					    $result_capillas->free(); // Free the result set memory
					} else {
					    error_log("Error en la consulta de capillas: " . $link->error);
					    die("<p>No se pudieron cargar las capillas.</p>");
					}


					?>
                </div>
                        <input class="easyui-switchbutton" id="sw" name="sw" data-options="onText:'AUTO',offText:'MANU'" value="AUTO" <?php echo ($swmt=="AUTO"?"checked":""); ?>>
                        <input type="hidden" id="swmt" name="swmt" size="6" value="<?php echo $swmt ?>" />
                        &nbsp; 
                        <input id="fecha_inicio" name="fecha_inicio" label="Select Date:" labelPosition="top" style="width:120px;" data-options="formatter:myformatter,parser:myparser,editable:false," value="<?php echo $fecha_inicio; ?>">
                        &nbsp;
                        <select class="easyui-combobox" id="hora_inicio" name="hora_inicio" label="Hora Velaci&oacute;n:" labelPosition="top" style="width:120px;" data-options="editable:false">
                        	<!--<option value=""></option>-->
                        	<?php
							for($i=0; $i<24; $i++) {
								$hr = str_pad($i, 2, "0", STR_PAD_LEFT).":00";
								echo '<option value="'.$hr.'" '.($hr==substr($hora_inicio,0,5)?'selected="selected"':'').'>' . date("g:ia", strtotime(date("Y-m-d") . " " . $hr . ":00")) . '</option>';
							}
							?>
                        </select> 
                        
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
			$('#qs').val("NO");
			$('#fecha_inicio').textbox(xstatus);
			$('#hora_inicio').combobox(xstatus);
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
				$('#hora_inicio').textbox(checked?'disable':'enable');
				
				if(checked) {
					var url = "MonitorServicios.php?swmt=AUTO";
					window.location.href = url;
				}
			}
		})

		$('#fecha_inicio').datebox({
			onSelect: function(date) {
				var xfecha = $('#fecha_inicio').textbox('getValue');
				var xhora = $('#hora_inicio').textbox('getValue');
				var xswmt = $('#swmt').val();
				
				var url = "MonitorServicios.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&hora_inicio="+xhora;
				window.location.href = url;
			}
		});

		$('#hora_inicio').combobox({
			onChange:function(newValue,oldValue) {
				var xfecha = $('#fecha_inicio').textbox('getValue');
				var xhora = $('#hora_inicio').textbox('getValue');
				var xswmt = $('#swmt').val();
				
				var url = "MonitorServicios.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&hora_inicio="+xhora;
				window.location.href = url;
			}
		});

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

/**
 * Función para obtener información detallada de disponibilidad de un expediente
 * basado en capilla, fecha y hora.
 *
 * @param mysqli $link      Objeto de conexión MySQLi.
 * @param string $fecha     Fecha en formato DD/MM/YYYY.
 * @param string $hora      Hora en formato HH:MM:SS.
 * @param string $capilla   ID o nombre de la capilla (Nservicio).
 * @return array            Array asociativo con los datos del expediente o valores vacíos si no se encuentra.
 */
function disponibilidad(mysqli $link, string $fecha, string $hora, string $capilla): array
{
    // Validar la conexión a la base de datos
    if ($link->connect_error) {
        error_log("Error: Conexión MySQLi no válida en la función disponibilidad: " . $link->connect_error);
        return [
            "TipoSolicitud" => "", "nombre_fallecido" => "ERROR: Conexión DB", "apellidos_fallecido" => "",
            "cedula_fallecido" => "", "fecha_inicio" => "", "hora_inicio" => "",
            "fecha_fin" => "", "hora_fin" => "", "servicio" => "",
            "oficio_r" => "", "sepelio_cremacion" => "", "permiso" => "",
            "expediente" => "0", "parcela" => ""
        ];
    }

    // Formatear la fecha para la consulta SQL
    $ff = explode("/", $fecha);
    $xfecha_sql = $ff[2] . "-" . $ff[1] . "-" . $ff[0];
    $datetime_compare = $xfecha_sql . " " . $hora; // Combinar fecha y hora para la comparación

    // Consulta principal optimizada con LEFT JOINs y GROUP_CONCAT
    $sql_principal = "
        SELECT
            exp.Nexpediente,
            seg.nombre AS TipoSolicitud,
            exp.nombre_fallecido,
            exp.apellidos_fallecido,
            exp.cedula_fallecido,
            DATE_FORMAT(ord.fecha_inicio, '%d/%m/%Y') AS fecha_inicio,
            DATE_FORMAT(ord.hora_inicio, '%h:%i%p') AS hora_inicio,
            DATE_FORMAT(ord.fecha_fin, '%d/%m/%Y') AS fecha_fin,
            DATE_FORMAT(ord.hora_fin, '%h:%i%p') AS hora_fin,
            exp.permiso,
            sst.nombre AS servicio, -- Directamente del LEFT JOIN para servicio
            CONCAT(DATE_FORMAT(ord_oficio.fecha_fin, '%d/%m/%Y'), ' ', DATE_FORMAT(ord_oficio.hora_fin, '%h:%i%p')) AS oficio_r,
            CONCAT(DATE_FORMAT(ord_sepelio.fecha_fin, '%d/%m/%Y'), ' ', DATE_FORMAT(ord_sepelio.hora_fin, '%h:%i%p')) AS sepelio_cremacion,
            exp.parcela,
            GROUP_CONCAT(
                IF(exp_c.nombre_fallecido IS NOT NULL AND TRIM(exp_c.nombre_fallecido) != '', CONCAT(' con ', exp_c.nombre_fallecido, ' ', exp_c.apellidos_fallecido), NULL)
                SEPARATOR ''
            ) AS compartir_nombres -- Consolidado con GROUP_CONCAT para 'compartir'
        FROM
            sco_orden AS ord
        JOIN
            sco_expediente AS exp ON exp.Nexpediente = ord.expediente
        JOIN
            sco_seguro AS seg ON seg.Nseguro = exp.seguro
        LEFT JOIN
            sco_servicio_tipo AS sst ON sst.Nservicio_tipo = ord.servicio_tipo AND ord.paso = '2'
        LEFT JOIN
            sco_orden AS ord_oficio
            JOIN sco_servicio AS serv_oficio ON serv_oficio.Nservicio = ord_oficio.servicio AND ord_oficio.paso = '5' AND serv_oficio.tipo = 'RELI'
        ON
            ord_oficio.expediente = exp.Nexpediente
        LEFT JOIN
            sco_orden AS ord_sepelio
            JOIN sco_servicio AS serv_sepelio ON serv_sepelio.Nservicio = ord_sepelio.servicio AND ord_sepelio.paso = '2'
        ON
            ord_sepelio.expediente = exp.Nexpediente
        LEFT JOIN
            sco_expediente AS exp_c ON exp_c.unir_con_expediente = exp.Nexpediente
        WHERE
            ord.paso = '1'
            AND ord.servicio = ?
            AND ? BETWEEN ord.fecha_inicio AND ord.fecha_fin
        GROUP BY
            exp.Nexpediente, seg.nombre, exp.nombre_fallecido, exp.apellidos_fallecido, exp.cedula_fallecido,
            ord.fecha_inicio, ord.hora_inicio, ord.fecha_fin, ord.hora_fin, exp.permiso, sst.nombre, exp.parcela,
            ord_oficio.fecha_fin, ord_oficio.hora_fin, ord_sepelio.fecha_fin, ord_sepelio.hora_fin
        LIMIT 1; -- Asegurarse de que solo se obtiene un resultado si la lógica lo requiere
    ";

    $stmt_principal = $link->prepare($sql_principal);

    if ($stmt_principal) {
        // 'ss' indica que se esperan dos parámetros de tipo string
        $stmt_principal->bind_param("ss", $capilla, $datetime_compare);
        $stmt_principal->execute();
        $result_principal = $stmt_principal->get_result();

        if ($row = $result_principal->fetch_assoc()) {
            $data = [
                "TipoSolicitud" => $row["TipoSolicitud"],
                "nombre_fallecido" => $row["nombre_fallecido"] . ($row["compartir_nombres"] ?? ''), // Concatenar nombres compartidos
                "apellidos_fallecido" => $row["apellidos_fallecido"],
                "cedula_fallecido" => $row["cedula_fallecido"],
                "fecha_inicio" => $row["fecha_inicio"],
                "hora_inicio" => $row["hora_inicio"],
                "fecha_fin" => $row["fecha_fin"],
                "hora_fin" => $row["hora_fin"],
                "servicio" => $row["servicio"],
                "oficio_r" => $row["oficio_r"],
                "sepelio_cremacion" => $row["sepelio_cremacion"],
                "permiso" => $row["permiso"],
                "expediente" => $row["Nexpediente"],
                "parcela" => $row["parcela"]
            ];
        } else {
            // Si no se encuentran resultados, retornar un array con valores vacíos
            $data = [
                "TipoSolicitud" => "", "nombre_fallecido" => "", "apellidos_fallecido" => "",
                "cedula_fallecido" => "", "fecha_inicio" => "", "hora_inicio" => "",
                "fecha_fin" => "", "hora_fin" => "", "servicio" => "",
                "oficio_r" => "", "sepelio_cremacion" => "", "permiso" => "",
                "expediente" => "0", "parcela" => ""
            ];
        }

        $result_principal->free();   // Liberar el resultado
        $stmt_principal->close();    // Cerrar el statement preparado
    } else {
        error_log("Error al preparar la consulta principal en disponibilidad: " . $link->error);
        $data = [
            "TipoSolicitud" => "", "nombre_fallecido" => "ERROR: Consulta principal fallida", "apellidos_fallecido" => "",
            "cedula_fallecido" => "", "fecha_inicio" => "", "hora_inicio" => "",
            "fecha_fin" => "", "hora_fin" => "", "servicio" => "",
            "oficio_r" => "", "sepelio_cremacion" => "", "permiso" => "",
            "expediente" => "0", "parcela" => ""
        ];
    }

    return $data;
}
?>