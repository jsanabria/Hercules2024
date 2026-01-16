<?php 
$expediente = $_GET["id"];
include 'includes/conexBD.php';
date_default_timezone_set('America/La_Paz');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="bootstrap/css/estilos.css" />
<link rel="shortcut icon" type="image/x-icon" href="../phpimages/icono.ico" />

<script type="text/javascript" src="jquery/jquery.min.js"></script>
<script type="text/javascript" src="jquery/jquery.easyui.min.js"></script>

<title>Funeraria Monumental</title>
</head>

<body>
	<div class="container-fluid">
	<?php
	// Asegúrate de que $link es tu objeto de conexión mysqli y que $expediente está definido.
	// Por ejemplo: $link = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");
	// $expediente = $_GET["id"] ?? ''; // Si viene de la URL, asegúrate de validarlo/sanearlo

	// --- Bloque 1: Obtener la nota principal del expediente ---
	$sql_expediente_nota = "
	    SELECT
	        CONCAT(e.nombre_fallecido, ' ', e.apellidos_fallecido) AS difunto,
	        e.nota,
	        e.user_registra AS usuario,
	        (SELECT nombre FROM sco_user WHERE username = e.user_registra) AS nombre_usuarios,
	        DATE_FORMAT(e.fecha_registro, '%d/%m/%Y %h:%i%p') AS fecha
	    FROM
	        sco_expediente e
	    WHERE
	        e.Nexpediente = ?;
	";

	// Preparar la consulta
	if ($stmt_expediente_nota = $link->prepare($sql_expediente_nota)) {
	    // Vincular el parámetro
	    $stmt_expediente_nota->bind_param("s", $expediente);
	    $stmt_expediente_nota->execute();
	    $result_expediente_nota = $stmt_expediente_nota->get_result();

	    if ($row_expediente_nota = $result_expediente_nota->fetch_assoc()) {
	        // Escapar todas las salidas HTML
	        $safe_expediente = htmlspecialchars($expediente);
	        $safe_difunto = htmlspecialchars($row_expediente_nota["difunto"] ?? '');
	        $safe_usuario_exp = htmlspecialchars($row_expediente_nota["usuario"] ?? '');
	        $safe_nombre_usuarios_exp = htmlspecialchars($row_expediente_nota["nombre_usuarios"] ?? '');
	        $safe_fecha_exp = htmlspecialchars($row_expediente_nota["fecha"] ?? '');
	        $safe_nota_exp = htmlspecialchars($row_expediente_nota["nota"] ?? '');

	        echo '<h2>Notas del Expediente # ' . $safe_expediente . ' <small>Difunto: ' . $safe_difunto . '</small></h2>';

	        if (trim($safe_nota_exp) !== "") { // Usar !== "" para ser más estricto
	            ?>
	            <div class="row">
	                <div class="col-sm-2 col-centered">
	                    <span class="glyphicon glyphicon-user"></span> <?php echo $safe_usuario_exp . ", " . $safe_nombre_usuarios_exp; ?>
	                </div>
	                <div class="col-sm-2 col-centered">
	                    <span class="glyphicon glyphicon-calendar"></span> <?php echo $safe_fecha_exp; ?>
	                </div>
	                <div class="col-sm-8">
	                    <div class="alert alert-danger" role="alert">
	                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> <?php echo $safe_nota_exp; ?>
	                    </div>
	                </div>
	            </div>
	            <?php
	        }
	    }
	    $result_expediente_nota->free();
	    $stmt_expediente_nota->close();
	} else {
	    error_log("Error al preparar la consulta de nota principal del expediente: " . $link->error);
	    // Considera mostrar un mensaje de error al usuario o manejarlo de otra forma
	}

	// --- Bloque 2: Obtener las notas adicionales del expediente ---
	$sql_notas_adicionales = "
	    SELECT
	        e.nota,
	        e.usuario,
	        (SELECT nombre FROM sco_user WHERE username = e.usuario) AS nombre_usuarios,
	        DATE_FORMAT(e.fecha, '%d/%m/%Y %h:%i%p') AS fecha
	    FROM
	        sco_nota e
	    WHERE
	        e.expediente = ?;
	";

	// Preparar la consulta
	if ($stmt_notas_adicionales = $link->prepare($sql_notas_adicionales)) {
	    // Vincular el parámetro
	    $stmt_notas_adicionales->bind_param("s", $expediente);
	    $stmt_notas_adicionales->execute();
	    $result_notas_adicionales = $stmt_notas_adicionales->get_result();

	    while ($row_notas_adicionales = $result_notas_adicionales->fetch_assoc()) {
	        // Escapar todas las salidas HTML
	        $safe_nota_add = htmlspecialchars($row_notas_adicionales["nota"]);
	        $safe_usuario_add = htmlspecialchars($row_notas_adicionales["usuario"]);
	        $safe_nombre_usuarios_add = htmlspecialchars($row_notas_adicionales["nombre_usuarios"]);
	        $safe_fecha_add = htmlspecialchars($row_notas_adicionales["fecha"]);
	        ?>
	        <div class="row">
	            <div class="col-sm-2 col-centered">
	                <span class="glyphicon glyphicon-user"></span> <?php echo $safe_usuario_add . ", " . $safe_nombre_usuarios_add; ?>
	            </div>
	            <div class="col-sm-2 col-centered">
	                <span class="glyphicon glyphicon-calendar"></span> <?php echo $safe_fecha_add; ?>
	            </div>
	            <div class="col-sm-8">
	                <div class="alert alert-info" role="alert">
	                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	                    <span class="sr-only">Nota:</span>
	                    <?php echo $safe_nota_add; ?>
	                </div>
	            </div>
	        </div>
	        <?php
	    }
	    $result_notas_adicionales->free();
	    $stmt_notas_adicionales->close();
	} else {
	    error_log("Error al preparar la consulta de notas adicionales: " . $link->error);
	    // Considera mostrar un mensaje de error al usuario o manejarlo de otra forma
	}
	?>
	</div>


</body>
</html>        