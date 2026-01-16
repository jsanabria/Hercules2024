<?php
include 'includes/conexBD.php'; // Assuming $link is your mysqli connection object
date_default_timezone_set('America/La_Paz');

$fecha_inicio = isset($_REQUEST["fecha_inicio"]) ? str_replace("-", "/", $_REQUEST["fecha_inicio"]) : $fecha_ser;
$fc = explode("/", $fecha_inicio);
$fecha_inicio = $fc[2] . "-" . str_pad($fc[1], 2, "0", STR_PAD_LEFT) . "-" . str_pad($fc[0], 2, "0", STR_PAD_LEFT);

$fc = explode("-", $fecha_inicio);
$_fecha = str_pad($fc[2], 2, "0", STR_PAD_LEFT) . "/" . str_pad($fc[1], 2, "0", STR_PAD_LEFT) . "/" . $fc[0];

// Leo el bloque horario según el servicio
$bloque_horario = [];
$sql_bloque_horario = "SELECT hora, bloque FROM sco_bloque_horario WHERE servicio_tipo = ?;";
if ($stmt = $link->prepare($sql_bloque_horario)) {
    $servicio_tipo = 'SEPE';
    $stmt->bind_param("s", $servicio_tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bloque_horario[$row["hora"]] = $row["bloque"];
    }
    $stmt->close();
} else {
    error_log("Error al preparar la consulta de bloque horario: " . $link->error);
}


$bh = [];
$sql_distinct_bloque = "SELECT DISTINCT bloque FROM sco_bloque_horario WHERE servicio_tipo = ? AND bloque <> 'EXCEP';";
if ($stmt = $link->prepare($sql_distinct_bloque)) {
    $servicio_tipo = 'SEPE';
    $stmt->bind_param("s", $servicio_tipo);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bh[] = $row["bloque"];
    }
    $stmt->close();
} else {
    error_log("Error al preparar la consulta de bloques distintos: " . $link->error);
}
$bh[] = "EXCEP";

$estatus_exp = [];
$sql_estatus = "SELECT Nstatus, color, nombre FROM sco_estatus WHERE activo = 'S' ORDER BY Nstatus;";
if ($stmt = $link->prepare($sql_estatus)) {
    $stmt->execute();
    $result = $stmt->get_result();
    while ($fila = $result->fetch_assoc()) {
        $estatus_exp[] = $fila;
    }
    $stmt->close();
} else {
    error_log("Error al preparar la consulta de estatus: " . $link->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Disponibilidad de Inhumaciones y Exhumaciones</title>
    <link rel="stylesheet" type="text/css" href="jquery/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="jquery/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="jquery/demo/demo.css">
    <link rel="stylesheet" type="text/css" href="jquery/themes/color.css">
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="jquery/jquery.easyui.min.js"></script>
    <script type="text/javascript" src="jquery/locale/easyui-lang-es.js"></script>
    <meta http-equiv="refresh" content="120">
</head>
<body>
    <div id="tt" class="easyui-tabs" style="width:100%;height:430px">
        <div title="Servicios de Inhumaci&oacute;n y Exhumaciones del d&iacute;a: <?php echo htmlspecialchars($_fecha); ?>" style="padding:10px" data-options="iconCls:'icon-ok'">
            <div style="width:100%;height:100%;">
                <div class="right">
                    <table>
                        <tr>
                            <td class="title"><div style="width:50px"><b>Hora</b></div></td>
                            <td class="title"><div style="width:150px"><b>Nombre Difunto</b></div></td>
                            <td class="title"><div style="width:150px"><b>Apellido Difunto</b></div></td>
                            <td class="title"><div style="width:100px"><b>Servicio/Parcela</b></div></td>
                            <td class="title"><div style="width:200px"><b>Capilla/Funeraria</b></div></td>
                            <td class="title"><div style="width:100px"><b>Estatus</b></div></td>
                        </tr>
                        <?php
                        $xx_cant = 0;
                        $sql_param = "SELECT valor4 AS cantidad FROM sco_parametro WHERE codigo = '019';";
                        if ($stmt = $link->prepare($sql_param)) {
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($row = $result->fetch_assoc()) {
                                $xx_cant = (int) $row["cantidad"];
                            }
                            $stmt->close();
                        } else {
                            error_log("Error al preparar la consulta de parámetro: " . $link->error);
                        }

                        $sql_servicios = "SELECT
                                            DATE_FORMAT(ord.hora_fin, '%H:%i') AS pauta,
                                            ord.Norden, exp.Nexpediente,
                                            tis.nombre AS tipo, ser.nombre AS servicio,
                                            exp.nombre_contacto, exp.telefono_contacto1, exp.telefono_contacto2,
                                            exp.nombre_fallecido, exp.apellidos_fallecido,
                                            (SELECT DATE_FORMAT(a.fecha_fin, '%d-%m') AS fecha_fin FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1) AS fecha_fin,
                                            (SELECT DATE_FORMAT(a.hora_fin, '%h:%i%p') AS hora_fin FROM sco_orden a WHERE a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1) AS hora_fin,
                                            IF(ord.espera_cenizas='S','SI','NO') AS espera_cenizas,
                                            (SELECT
                                                b.nombre
                                            FROM
                                                sco_orden a
                                                JOIN sco_servicio b ON b.Nservicio = a.servicio
                                            WHERE
                                                a.expediente = exp.Nexpediente AND a.paso = 1 ORDER BY a.fecha_fin DESC, a.hora_fin DESC LIMIT 1
                                            ) AS capilla,
                                            pro.nombre AS proveedor,
                                            IF(RTRIM(LTRIM(exp.causa_ocurrencia))='OTRO', exp.causa_otro, exp.causa_ocurrencia) AS causa_ocurrencia,
                                            fun.nombre AS funeraria,
                                            IFNULL(LENGTH(LTRIM(exp.nota)), 0) AS nota,
                                            (SELECT COUNT(*) FROM sco_nota WHERE expediente = exp.Nexpediente) AS notas, DATE_FORMAT(ord.hora_fin, '%h:%i:%p') AS hora_servicio, exp.estatus, exp.parcela, ord.capilla
                                        FROM
                                            sco_orden AS ord
                                            JOIN sco_expediente AS exp ON exp.Nexpediente = ord.expediente
                                            LEFT OUTER JOIN sco_servicio_tipo AS tis ON tis.Nservicio_tipo = ord.servicio_tipo
                                            LEFT OUTER JOIN sco_servicio AS ser ON ser.Nservicio = ord.servicio
                                            LEFT OUTER JOIN sco_proveedor AS pro ON pro.Nproveedor = ord.proveedor
                                            LEFT OUTER JOIN sco_proveedor AS fun ON fun.Nproveedor = ord.capilla
                                        WHERE
                                            ord.paso = 2 AND ord.servicio_tipo IN ('SEPE','EXHU') AND
                                            DATE_FORMAT(ord.fecha_fin, '%Y-%m-%d') = ?
                                        ORDER BY
                                            ord.fecha_fin, ord.hora_fin;";
                            $cremaciones = 0; // This variable name might be misleading, as it's for Inhumaciones/Exhumaciones
                            $ids = array();
                            $hora = "";
                            $count = 1;
                            $blackboard_string = "";
                            $blackboard = []; // Initialize blackboard array

                            if ($stmt = $link->prepare($sql_servicios)) {
                                $stmt->bind_param("s", $fecha_inicio);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                while ($row = $result->fetch_assoc()) {
                                    if ($hora != (isset($bloque_horario[$row["pauta"]]) ? $bloque_horario[$row["pauta"]] : null) && $hora != "") {
                                        if ($count <= $xx_cant) {
                                            for ($i = $count; $i <= $xx_cant; $i++) {
                                                $blackboard_string .= '<tr><td class="drop"><div>&nbsp;</div></td>';
                                                $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                                $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                                $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                                $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                                $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td></tr>';
                                            }
                                        }
                                        $count = 1;
                                        $blackboard[$hora] = $blackboard_string;
                                        $blackboard_string = "";
                                    }
                                    $blackboard_string .= '<tr>';
                                    $drop = "drop" . htmlspecialchars($row["estatus"]);

                                    if ($hora != (isset($bloque_horario[$row["pauta"]]) ? $bloque_horario[$row["pauta"]] : null)) {
                                        $blackboard_string .= '<td class="' . $drop . '"><div><b><i>' . (isset($bloque_horario[$row["pauta"]]) ? htmlspecialchars($bloque_horario[$row["pauta"]]) : '') . '</i></b></div></td>';
                                        $hora = (isset($bloque_horario[$row["pauta"]]) ? $bloque_horario[$row["pauta"]] : null);
                                    } else {
                                        $blackboard_string .= '<td class="' . $drop . '"><div></div></td>';
                                    }
                                    $my_estatus = "";
                                    foreach ($estatus_exp as $key => $value) {
                                        if ($value["Nstatus"] == $row["estatus"]) {
                                            $my_estatus = $value["nombre"];
                                            break;
                                        }
                                    }
                                    $blackboard_string .= '<td class="' . $drop . '"><div><b><i>' . htmlspecialchars($row["nombre_fallecido"]) . '</i></b></div></td>';
                                    $blackboard_string .= '<td class="' . $drop . '"><div><b><i>' . htmlspecialchars($row["apellidos_fallecido"]) . '</i></b></div></td>';
                                    $blackboard_string .= '<td class="' . $drop . '"><div><b><i>' . htmlspecialchars($row["servicio"]) . '<br>' . htmlspecialchars($row["parcela"]) . '</i></b></div></td>';
                                    $blackboard_string .= '<td class="' . $drop . '"><div>' . (trim($row["capilla"]) == "" ? "<b>" . htmlspecialchars($row["funeraria"]) . "</b>" : htmlspecialchars($row["capilla"])) . '</div></td>';
                                    $blackboard_string .= '<td class="' . $drop . '"><div><b>' . htmlspecialchars($my_estatus) . '</b></div></td>';
                                    $ids[] = $row["Nexpediente"];

                                    $blackboard_string .= '</tr>';
                                    $cremaciones++;
                                    $count++;
                                }
                                $stmt->close();
                            } else {
                                error_log("Error al preparar la consulta principal de servicios: " . $link->error);
                            }

                            if ($count <= $xx_cant) {
                                for ($i = $count; $i <= $xx_cant; $i++) {
                                    $blackboard_string .= '<tr><td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td>';
                                    $blackboard_string .= '<td class="drop"><div>&nbsp;</div></td></tr>';
                                }
                            }
                            $count = 1;
                            $blackboard[$hora] = $blackboard_string;
                            $blackboard_string = "";

                            $blackboard_separator = '<tr><td class="drop5"><div>--</div></td>';
                            $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                            $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                            $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                            $blackboard_separator .= '<td class="drop5"><div>--</div></td>';
                            $blackboard_separator .= '<td class="drop5"><div>--</div></td></tr>';

                            $count = 1;
                            foreach ($bh as $value) {
                                if (trim(isset($blackboard[$value]) ? $blackboard[$value] : "") == "") {
                                    if ($count <= $xx_cant) {
                                        for ($i = $count; $i <= $xx_cant; $i++) {
                                            echo '<tr><td class="drop"><div><b><i>' . ($i == 1 ? htmlspecialchars($value) : '&nbsp;') . '</i></b></div></td>';
                                            echo '<td class="drop"><div>&nbsp;</div></td>';
                                            echo '<td class="drop"><div>&nbsp;</div></td>';
                                            echo '<td class="drop"><div>&nbsp;</div></td>';
                                            echo '<td class="drop"><div>&nbsp;</div></td>';
                                            echo '<td class="drop"><div>&nbsp;</div></td></tr>';
                                        }
                                    }
                                    $count = 1;
                                } else {
                                    echo $blackboard[$value];
                                }
                                echo ($value == "EXCEP" ? "" : $blackboard_separator);
                            }
                        ?>
                        <tr><td colspan="9"><b>Total Servicios Programados: <?php echo $cremaciones; ?></b></td></tr>
                    </table>
                    <br />
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
                .right td.drop<?php echo htmlspecialchars($value["Nstatus"]); ?>{
                    color:#000000;
                    background:<?php echo htmlspecialchars($value["color"]); ?>;
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
        </div>
    <script type="text/javascript">
        var xstatus = <?php echo(isset($swmt) && $swmt=="AUTO"?"'disable'":"'enable'") ?>;
        $(document).ready(function() {
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
                    var url = "asistencia_005.php?swmt=AUTO&username=<?php echo (isset($username) ? htmlspecialchars($username) : ""); ?>";
                    window.location.href = url;
                }
            }
        })

        $('#fecha_inicio').datebox({
            onChange: function(date) {
                var xfecha = $('#fecha_inicio').textbox('getValue');
                var xswmt = $('#swmt').val();

                var url = "asistencia_005.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&username=<?php echo (isset($username) ? htmlspecialchars($username) : ""); ?>";
                window.location.href = url;
            }
        });

        <?php foreach ($ids as $value) { ?>
            $('#state_<?php echo trim(htmlspecialchars($value)); ?>').combobox({
                onSelect: function() {
                    var xfecha = $('#fecha_inicio').textbox('getValue');
                    var xswmt = $('#swmt').val();

                    if(confirm("Seguro que desea cambiar el estatus del Expediente # <?php echo trim(htmlspecialchars($value)); ?>")) {
                        var url = "cremacion_estatus_actualizar.php?swmt="+xswmt+"&fecha_inicio="+xfecha+"&exp=<?php echo trim(htmlspecialchars($value)); ?>&sta=" + $("#state_<?php echo trim(htmlspecialchars($value)); ?>").combobox('getValue') + "&username=<?php echo (isset($username) ? htmlspecialchars($username) : ""); ?>";
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