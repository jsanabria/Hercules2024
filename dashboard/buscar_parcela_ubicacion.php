<?php
include 'includes/conexBD.php';

// 1. Limpieza de la entrada
$ci_raw = $_REQUEST["ci_difunto"] ?? "";
$ci = strtoupper(trim($ci_raw));
$response = null; // Inicializamos la respuesta como nula

if ($ci !== "") {
    // Lógica de limpieza para sco_parcela (solo números)
    if (strpos($ci, ",")) {
        $ci = substr($ci, 0, strpos($ci, ","));
    }
    
    // Quitar prefijos para la primera búsqueda
    $ci_solo_numeros = $ci;
    if (in_array(substr($ci, 0, 2), ["V-", "E-", "J-", "G-", "M-"])) {
        $ci_solo_numeros = substr($ci, 2);
    }

    // --- PRIMERA BÚSQUEDA: sco_parcela ---
    $sql1 = "SELECT 
    			IF(LTRIM(RTRIM(nac_difunto)) = '' OR nac_difunto IS NULL,
			        LTRIM(RTRIM(ci_difunto)),
			        CONCAT(
			            IF(SUBSTRING(LTRIM(RTRIM(nac_difunto)), 1, 9) = 'VENEZOLAN', 'V-', 'E-'), 
			            LTRIM(RTRIM(IFNULL(REPLACE(REPLACE(ci_difunto, 'V-', ''), 'E-', ''), '')))
			        )
			    ) AS cedula_fallecido,
                CONCAT(RTRIM(LTRIM(IFNULL(nombre1, ''))), ' ', RTRIM(LTRIM(IFNULL(nombre2, ''))), ' ', RTRIM(LTRIM(IFNULL(apellido1, ''))), ' ', RTRIM(LTRIM(IFNULL(apellido2, '')))) AS nombre,  
                seccion, modulo, sub_seccion, parcela, boveda  
            FROM sco_parcela 
            WHERE RTRIM(LTRIM(ci_difunto)) = ? 
            LIMIT 1";

    $stmt = $link->prepare($sql1);
    $stmt->bind_param("s", $ci_solo_numeros);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response = [
        	"cedula"      => trim($row["cedula_fallecido"]),
            "nombre"      => trim($row["nombre"]),
            "seccion"     => trim($row["seccion"]),
            "modulo"      => trim($row["modulo"]),
            "sub_seccion" => trim($row["sub_seccion"]),
            "parcela"     => trim($row["parcela"]),
            "boveda"      => trim($row["boveda"])
        ];
    } else {
        // --- SEGUNDA BÚSQUEDA: sco_expediente (Si la primera falló) ---
        // Usamos $ci_raw tal como viene del request (ej: V-123456)
        $sql2 = "SELECT cedula_fallecido, 
                    CONCAT(IFNULL(nombre_fallecido, ''), ' ', IFNULL(apellidos_fallecido, '')) AS nombre, 
                    '' AS seccion, '' AS modulo, '' AS sub_seccion, '' AS parcela, '' AS boveda 
                FROM sco_expediente 
                WHERE cedula_fallecido = ? 
                LIMIT 1";
        
        $stmt2 = $link->prepare($sql2);
        $stmt2->bind_param("s", $ci_raw);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        if ($row2 = $result2->fetch_assoc()) {
            $response = [
            	"cedula"      => trim($row2["cedula_fallecido"]),
                "nombre"      => trim($row2["nombre"]),
                "seccion"     => "",
                "modulo"      => "",
                "sub_seccion" => "",
                "parcela"     => "",
                "boveda"      => ""
            ];
        }
        $stmt2->close();
    }
    $stmt->close();
}

$link->close();

// 4. Salida siempre en formato JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);
exit();