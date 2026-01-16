<?php
/**
 * Script: Eliminar Estructura Abierta y Revertir Precios Maestros
 * Optimizado para MySQLi y Transacciones
 */

require_once 'includes/conexBD.php'; // Usa la conexión $link de conexBD.php
date_default_timezone_set('America/Caracas');

try {
    // 1. Iniciar Transacción
    $link->begin_transaction();

    // 2. Eliminar la estructura que está abierta actualmente (Cerrado = 'N')
    // Nota: Esto limpia cualquier borrador que no se haya finalizado.
    $sqlDelete = "DELETE FROM sco_costos WHERE cerrado = 'N'";
    $link->query($sqlDelete);

    // 3. Identificar la última estructura que fue cerrada exitosamente
    $sqlLast = "SELECT MAX(id) AS ultimo_id FROM sco_costos WHERE cerrado = 'S'";
    $resLast = $link->query($sqlLast);
    $rowLast = $resLast->fetch_assoc();
    $ultimoId = $rowLast['ultimo_id'];

    if ($ultimoId) {
        /**
         * 4. Revertir Precios Maestros
         * Sincroniza la tabla de artículos con los precios de la estructura que estamos reabriendo.
         */
        $sqlRevertir = "UPDATE sco_costos_articulos a 
                        JOIN sco_costos c ON c.costos_articulos = a.Ncostos_articulo 
                        SET a.precio = c.precio_nuevo, 
                            a.variacion = c.porcentaje_aplicado 
                        WHERE c.id = ?";
        
        $stmtRev = $link->prepare($sqlRevertir);
        $stmtRev->bind_param("i", $ultimoId);
        $stmtRev->execute();

        /**
         * 5. Cambiar el estado de la estructura de 'S' (Cerrado) a 'N' (Abierto)
         * Esto permite que vuelva a aparecer como la estructura editable actual.
         */
        $sqlOpen = "UPDATE sco_costos SET cerrado = 'N' WHERE id = ?";
        $stmtOpen = $link->prepare($sqlOpen);
        $stmtOpen->bind_param("i", $ultimoId);
        $stmtOpen->execute();

        $stmtRev->close();
        $stmtOpen->close();
    }

    // 6. Confirmar todos los cambios
    $link->commit();
    $status = "success_removed";

} catch (Exception $e) {
    // Si algo falla (ej. error de red, tabla bloqueada), se deshacen todos los cambios
    $link->rollback();
    error_log("Error al eliminar/revertir estructura de costos: " . $e->getMessage());
    $status = "error_reverting";
}

$link->close();
header("Location: costos_estructura_list.php?status=" . $status);
exit();
?>