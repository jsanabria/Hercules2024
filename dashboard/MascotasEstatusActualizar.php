<?php 
include 'includes/conexBD.php';

$swmt = $_REQUEST["swmt"];
$fecha_inicio = $_REQUEST["fecha_inicio"];
$exp = $_REQUEST["exp"];
$sta = $_REQUEST["sta"]; 
$username = $_REQUEST["username"]; 

$ff = explode("/", $fecha_inicio); 
$fecha = $ff[2]."-".$ff[1]."-".$ff[0];

$estatus = [];
$estatus_anterior = [];
$i = 0;

$sql = "SELECT valor1 AS estatus, valor2 AS nombre, valor4 AS estilo FROM sco_parametro WHERE codigo = ? ORDER BY valor3;";
if ($stmt = $link->prepare($sql)) {
    $param_codigo = '026';
    $stmt->bind_param("s", $param_codigo); // Vincula el código '026' como string.
    $stmt->execute();

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $estatus[$row['estatus']] = $i;
        $estatus_anterior[$i] = $row['estatus'];
        $i++; // Incrementa el contador
    }

    $result->free(); // Libera la memoria del resultado
    $stmt->close(); // Cierra el statement
} else {
    die("Error al preparar la consulta de sco_parametro (codigo 026) para estatus: " . $link->error);
}


$sw = false; // Bandera para determinar si se debe realizar la inserción/actualización

// 1. Verificar si el estatus ($sta) ya existe para esta mascota ($exp)
$sql_check_current_status = "SELECT estatus FROM sco_mascota_estatus WHERE mascota = ? AND estatus = ?;";
if ($stmt_check_current = $link->prepare($sql_check_current_status)) {
    // Asumimos $exp es un entero (i) y $sta es una cadena (s)
    $stmt_check_current->bind_param("is", $exp, $sta);
    $stmt_check_current->execute();
    $result_check_current = $stmt_check_current->get_result();
    $status_already_exists = ($result_check_current->num_rows > 0);
    $result_check_current->free();
    $stmt_check_current->close();

    // Solo procedemos si el nuevo estatus NO existe aún para esta mascota
    if (!$status_already_exists) {
        // Verificar si el nuevo estatus es el primero en la secuencia definida ($estatus[$sta] == 0)
        // O si el estatus anterior requerido ya existe para esta mascota
        if (isset($estatus[$sta])) { // Asegurarse de que el estatus $sta exista en el mapeo
            if ($estatus[$sta] == 0) {
                // Si es el primer estatus, y no existe, se puede insertar
                $sw = true;
            } else {
                // Si no es el primer estatus, verificamos que el estatus ANTERIOR exista
                $previous_status_index = $estatus[$sta] - 1;

                if (isset($estatus_anterior[$previous_status_index])) {
                    $required_prev_status = $estatus_anterior[$previous_status_index];

                    $sql_check_previous_status = "SELECT estatus FROM sco_mascota_estatus WHERE mascota = ? AND estatus = ?;";
                    if ($stmt_check_previous = $link->prepare($sql_check_previous_status)) {
                        $stmt_check_previous->bind_param("is", $exp, $required_prev_status);
                        $stmt_check_previous->execute();
                        $result_check_previous = $stmt_check_previous->get_result();
                        $previous_status_exists = ($result_check_previous->num_rows > 0);
                        $result_check_previous->free();
                        $stmt_check_previous->close();

                        // Si el estatus anterior requerido existe, entonces podemos insertar el nuevo estatus
                        if ($previous_status_exists) {
                            $sw = true;
                        }
                    } else {
                        die("Error al preparar la consulta de estatus anterior: " . $link->error);
                    }
                }
            }
        } else {
            // Manejo: El estatus $sta no está definido en el array $estatus, lo que podría indicar un valor inválido.
            die("Estatus '$sta' no encontrado en el array de estatus permitidos.");
        }
    }
} else {
    die("Error al preparar la consulta inicial de verificación de estatus: " . $link->error);
}

// 2. Realizar INSERT y UPDATE si $sw es verdadero
if ($sw) {
    // Inserción en sco_mascota_estatus
    $sql_insert_status = "INSERT INTO sco_mascota_estatus(mascota, estatus, fecha_hora, username) VALUES (?, ?, NOW(), ?)";
    if ($stmt_insert = $link->prepare($sql_insert_status)) {
        // Asumimos $exp es int (i), $sta es string (s), $username es string (s)
        $stmt_insert->bind_param("iss", $exp, $sta, $username);
        if (!$stmt_insert->execute()) {
            die("Error al insertar estatus en sco_mascota_estatus: " . $stmt_insert->error);
        }
        $stmt_insert->close();
    } else {
        die("Error al preparar la consulta de inserción de estatus: " . $link->error);
    }

    // Actualización en sco_mascota
    $sql_update_mascota = "UPDATE sco_mascota SET estatus=? WHERE Nmascota = ?;";
    if ($stmt_update = $link->prepare($sql_update_mascota)) {
        // Asumimos $sta es string (s), $exp es int (i)
        $stmt_update->bind_param("si", $sta, $exp);
        if (!$stmt_update->execute()) {
            die("Error al actualizar estatus en sco_mascota: " . $stmt_update->error);
        }
        $stmt_update->close();
    } else {
        die("Error al preparar la consulta de actualización de mascota: " . $link->error);
    }
}

header("Location: PizarraCremacionMascota.php?swmt=$swmt&fecha_inicio=$fecha_inicio&username=$username");
?>