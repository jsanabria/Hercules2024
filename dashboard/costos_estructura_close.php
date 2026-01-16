<?php
/**
 * Script: Cierre de Estructura de Costos y Actualización de Precios Maestros
 * Optimizado para MySQLi y Transacciones
 */

require_once 'includes/conexBD.php'; // Usa la conexión $link de conexBD.php

// 1. Obtener y validar ID (Seguridad)
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

if ($id > 0) {
    try {
        // 2. Iniciar Transacción
        $link->begin_transaction();

        // 3. Marcar la estructura como Cerrada ('S')
        $sqlCerrar = "UPDATE sco_costos SET cerrado = 'S' WHERE id = ?";
        $stmt1 = $link->prepare($sqlCerrar);
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        /**
         * 4. Actualizar Precios Maestros
         * Sincroniza la tabla de artículos con los nuevos precios calculados en la estructura
         */
        $sqlActualizarMaestro = "UPDATE sco_costos_articulos a 
                                 JOIN sco_costos c ON c.costos_articulos = a.Ncostos_articulo 
                                 SET a.precio = c.precio_nuevo, 
                                     a.variacion = c.porcentaje_aplicado 
                                 WHERE c.id = ?";
        
        $stmt2 = $link->prepare($sqlActualizarMaestro);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        // 5. Confirmar cambios si ambas consultas fueron exitosas
        $link->commit();
        
        $stmt1->close();
        $stmt2->close();
        
        $status = "success";

    } catch (Exception $e) {
        // Si algo falla, revertimos todo para no dejar precios a medias
        $link->rollback();
        error_log("Error al cerrar estructura de costos ID $id: " . $e->getMessage());
        $status = "error";
    }
} else {
    $status = "invalid_id";
}

// 6. Cerrar conexión y redireccionar
$link->close();
header("Location: costos_estructura_list.php?status=" . $status);
exit();
?>