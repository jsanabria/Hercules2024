<?php 
include 'includes/conexBD.php';

$swmt = $_REQUEST["swmt"];
$fecha_inicio = $_REQUEST["fecha_inicio"];
$exp = $_REQUEST["exp"];
$sta = $_REQUEST["sta"]; 
$username = $_REQUEST["username"]; 

$ff = explode("/", $fecha_inicio); 
$fecha = $ff[2]."-".$ff[1]."-".$ff[0];

$estatus = array(
    "RECEPCION" => 0,
    "DOCUMENTOS" => 1,
    "PROCESO" => 2,
    "CREMACION OK" => 3,
    "ENTREGADAS" => 4
);

$estatus_anterior = array(
    0 => "RECEPCION",
    1 => "DOCUMENTOS",
    2 => "PROCESO",
    3 => "CREMACION OK",
    4 => "ENTREGADAS"
);

$sw = false; // Variable para controlar si se debe insertar el nuevo estatus

// --- Paso 1: Verificar si el estatus actual ($sta) ya existe para el expediente ---
$sql_check_current_status = "SELECT estatus FROM sco_cremacion_estatus WHERE expediente = ? AND estatus = ?;";
if ($stmt_check_current = $link->prepare($sql_check_current_status)) {
    $stmt_check_current->bind_param("ss", $exp, $sta);
    $stmt_check_current->execute();
    $result_check_current = $stmt_check_current->get_result();

    $status_exists = ($result_check_current->num_rows > 0);

    $result_check_current->free();
    $stmt_check_current->close();

    // Si el estatus $sta NO existe para el expediente, entonces procedemos con la lógica condicional
    if (!$status_exists) {
        // --- Paso 2: Determinar si se permite la inserción del nuevo estatus ---
        // Lógica original: si el estatus es el inicial (0), se permite la inserción
        if (($estatus[$sta] ?? -1) == 0) { // Usar ?? -1 para evitar error si $sta no está en $estatus
            $sw = true;
        }
        // Lógica original: si el estatus no es el inicial, se debe verificar el estatus anterior
        else {
            $previous_status_level = ($estatus[$sta] ?? -1) - 1;
            // Asegúrate de que $estatus_anterior tiene la clave numérica antes de acceder
            if (isset($estatus_anterior[$previous_status_level])) {
                $previous_sta_name = $estatus_anterior[$previous_status_level];

                // Verificar si el estatus anterior existe para el expediente
                $sql_check_previous_status = "SELECT estatus FROM sco_cremacion_estatus WHERE expediente = ? AND estatus = ?;";
                if ($stmt_check_previous = $link->prepare($sql_check_previous_status)) {
                    $stmt_check_previous->bind_param("ss", $exp, $previous_sta_name);
                    $stmt_check_previous->execute();
                    $result_check_previous = $stmt_check_previous->get_result();

                    $previous_status_exists = ($result_check_previous->num_rows > 0);

                    $result_check_previous->free();
                    $stmt_check_previous->close();

                    // Si el estatus anterior existe, entonces permitimos la inserción del nuevo estatus
                    if ($previous_status_exists) {
                        $sw = true;
                    }
                } else {
                    error_log("Error al preparar la consulta de verificación de estatus anterior: " . $link->error);
                }
            } else {
                // Manejar el caso donde el nivel de estatus anterior no es válido o no existe en $estatus_anterior
                error_log("Nivel de estatus anterior no encontrado para el estatus '$sta'.");
            }
        }

        // --- Paso 3: Realizar la inserción si $sw es verdadero ---
        if ($sw) {
            $sql_insert_status = "INSERT INTO sco_cremacion_estatus(expediente, estatus, fecha_hora, username) VALUES (?, ?, NOW(), ?)";
            if ($stmt_insert = $link->prepare($sql_insert_status)) {
                $stmt_insert->bind_param("sss", $exp, $sta, $username);
                if (!$stmt_insert->execute()) {
                    error_log("Error al insertar estatus en sco_cremacion_estatus: " . $stmt_insert->error);
                    // Puedes lanzar una excepción o manejar este error de otra forma
                }
                $stmt_insert->close();
            } else {
                error_log("Error al preparar la consulta de inserción de estatus: " . $link->error);
            }
        }
    }
} else {
    error_log("Error al preparar la consulta de verificación de estatus actual: " . $link->error);
}


header("Location: PizarraCremaciones.php?swmt=$swmt&fecha_inicio=$fecha_inicio&username=$username");
?>