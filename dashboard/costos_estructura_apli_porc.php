<?php
/**
 * Script: Actualización masiva de porcentaje en estructura de costos
 * Optimizado para MySQLi y Seguridad
 */

require_once 'includes/conexBD.php'; // Usa la variable $link de conexBD.php

// 1. Obtención y validación de parámetros (Seguridad)
$id   = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$porc = isset($_GET["porc"]) ? floatval($_GET["porc"]) : 0;

if ($id > 0) {
    /**
     * 2. Unificación de Consultas
     * Es más eficiente realizar todos los cálculos en un solo paso.
     * precio_nuevo = precio_actual * (1 + porcentaje/100)
     * monto_iva    = precio_nuevo * (alicuota/100)
     * total        = precio_nuevo + monto_iva
     */
    $sql = "UPDATE sco_costos 
            SET 
                porcentaje_aplicado = ?, 
                precio_nuevo = precio_actual * (1 + (? / 100)),
                monto_iva    = (precio_actual * (1 + (? / 100))) * (alicuota_iva / 100),
                total        = (precio_actual * (1 + (? / 100))) * (1 + (alicuota_iva / 100))
            WHERE id = ?";

    if ($stmt = $link->prepare($sql)) {
        // Pasamos el porcentaje 4 veces (para cada cálculo) y el ID al final
        $stmt->bind_param("ddddi", $porc, $porc, $porc, $porc, $id);
        
        if (!$stmt->execute()) {
            // Error al ejecutar
            error_log("Error en actualización de costos ID $id: " . $stmt->error);
        }
        $stmt->close();
    }
}

$link->close();
?>
<script type="text/javascript">
    window.history.back();
</script>