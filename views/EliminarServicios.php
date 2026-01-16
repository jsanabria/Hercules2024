<?php

namespace PHPMaker2024\hercules;

// Page object
$EliminarServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php 
$expediente = $_REQUEST["expediente"];
$user = $_REQUEST["user"]; 

$sql = "SELECT exp.estatus FROM sco_expediente exp WHERE exp.Nexpediente = '$expediente';";

if($row = ExecuteRow($sql)) {
	if(strval($row["estatus"]) <= 2) {
		$sql = "SELECT o.servicio FROM sco_orden o WHERE o.expediente = '$expediente' AND o.paso = '3';"; 
		if($row = ExecuteRow($sql)) {
			$articulo = $row["servicio"];
			/* Se suma el artículo al inventario */
			$sql = "INSERT INTO sco_entrada_salida
						(Nentrada_salida, tipo_doc, proveedor, clasificacion, documento, fecha, nota, username, monto, registro)
					VALUES (NULL, 'EXIN', -1, 'EXPE', '$expediente', NOW(), 'ENTRADA AUTOMATICA POR APAGAR TODOS LOS SERVICIOS EN Exp.: $expediente', '', 0, now())"; 
			Execute($sql);
            $sql = "SELECT LAST_INSERT_ID();";
			$idENT = ExecuteScalar($sql);
			
			$sql = "INSERT INTO sco_entrada_salida_detalle
						(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
					VALUES (NULL, $idENT, 'EXIN', -1, '$articulo', 1, 0, 0)";
			Execute($sql);
		}

		$sql = "INSERT INTO sco_orden_offall
					(id, fecha_hora, username, Norden, expediente, servicio_tipo, servicio, proveedor, responsable_servicio, paso, fecha_inicio, hora_inicio, horas, fecha_fin, hora_fin, capilla, cantidad, costo, total, nota, referencia_ubicacion, anulada, user_registra, fecha_registro, media_hora, espera_cenizas, adjunto, llevar_a, servicio_atendido, ministro)
				SELECT NULL, '" . date("Y-m-d H:i:s") . "', '$user', Norden, expediente, servicio_tipo, servicio, proveedor, responsable_servicio, paso, fecha_inicio, hora_inicio, horas, fecha_fin, hora_fin, capilla, cantidad, costo, total, nota, referencia_ubicacion, anulada, user_registra, fecha_registro, media_hora, espera_cenizas, adjunto, llevar_a, servicio_atendido, ministro
					FROM sco_orden WHERE expediente = '$expediente';";
		Execute($sql); 

		$sql = "DELETE FROM sco_orden WHERE expediente = '$expediente';";
		Execute($sql); 

		$sql = "UPDATE sco_expediente_cia SET estatus = 1 WHERE expediente = '$expediente';";
		Execute($sql); 

		// Se registra la traza de apagar todos los servicios 
		$sql = "INSERT INTO audittrail(id, datetime, script, user, `action`, `table`, field, keyvalue, oldvalue, newvalue)
				VALUES (NULL, '" . date("Y-m-d H:i:s") . "', 'eliminar_servicios.php', '$user', 'D', 'sco_orden', 'expediente/servicio', '$expediente', '$expediente', 'APAGAR TODOS LOS SERVICIOS EXP: $expediente');";
		Execute($sql);

		$accion = 1;
	} 
	else $accion = 2;
} 
else $accion = 0;

header("Location: EliminarServiciosEng?expediente=$expediente&user=$user&accion=$accion");
?>
<?= GetDebugMessage() ?>
