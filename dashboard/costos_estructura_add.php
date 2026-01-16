<?php
/**
 * Script: Generación de Nueva Estructura de Costos
 * Actualizado a MySQLi y Consultas Preparadas
 */

require_once 'includes/conexBD.php'; // Usa la variable $link de tipo mysqli
date_default_timezone_set('America/Caracas');

try {
    // 1. Iniciar transacción para asegurar integridad de los datos masivos
    $link->begin_transaction();

    // 2. Obtener el próximo ID correlativo
    $sqlId = "SELECT COALESCE(MAX(id), 0) + 1 AS proximo_id FROM sco_costos";
    $resId = $link->query($sqlId);
    $rowId = $resId->fetch_assoc();
    $nuevoId = $rowId['proximo_id'];

    // 3. Obtener el valor del IVA desde parámetros
    $sqlIva = "SELECT valor1 FROM sco_parametro WHERE codigo = '002' LIMIT 1";
    $resIva = $link->query($sqlIva);
    $rowIva = $resIva->fetch_assoc();
    
    // Validamos que exista el parámetro del IVA, si no, usamos 0 o lanzamos error
    if (!$rowIva) {
        throw new Exception("No se encontró el parámetro de IVA (código 002) en la base de datos.");
    }
    $ivaFactor = floatval($rowIva['valor1']); // Ejemplo: 16.00

    /**
     * 4. Inserción Masiva
     * Calculamos los precios en el SQL para mayor velocidad:
     * precio_nuevo = precio + (precio * (variacion/100))
     * monto_iva = precio_nuevo * (iva/100)
     * total = precio_nuevo + monto_iva
     */
    $sqlInsert = "INSERT INTO sco_costos (
                    Ncostos, 
                    tipo, 
                    costos_articulos, 
                    id, 
                    fecha, 
                    precio_actual, 
                    precio_nuevo, 
                    alicuota_iva, 
                    monto_iva, 
                    total, 
                    porcentaje_aplicado, 
                    cerrado
                  )
                  SELECT 
                    NULL, 
                    tipo, 
                    Ncostos_articulo, 
                    ?, 
                    CURDATE(), 
                    precio, 
                    (precio * (1 + (variacion / 100))), 
                    ?, 
                    (precio * (1 + (variacion / 100))) * (? / 100), 
                    (precio * (1 + (variacion / 100))) * (1 + (? / 100)), 
                    variacion, 
                    'N' 
                  FROM sco_costos_articulos 
                  ORDER BY tipo, Ncostos_articulo, descripcion";

    $stmt = $link->prepare($sqlInsert);
    if (!$stmt) {
        throw new Exception("Error preparando la inserción: " . $link->error);
    }

    // Pasamos el nuevo ID y el valor del IVA 3 veces para los cálculos del SELECT
    $stmt->bind_param("iddd", $nuevoId, $ivaFactor, $ivaFactor, $ivaFactor);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la generación masiva: " . $stmt->error);
    }

    // 5. Si todo salió bien, confirmamos los cambios
    $link->commit();
    $stmt->close();

    // Redirección al éxito
    header("Location: costos_estructura_list.php?status=success");

} catch (Exception $e) {
    // Si algo falla, revertimos cualquier cambio en la BD
    $link->rollback();
    
    // Opcional: Registrar el error en un log
    error_log("Error en generación de costos: " . $e->getMessage());
    
    // Redirección con mensaje de error
    header("Location: costos_estructura_list.php?error=" . urlencode($e->getMessage()));
}

$link->close();
exit();
?>