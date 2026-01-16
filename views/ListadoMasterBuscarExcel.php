<?php

namespace PHPMaker2024\hercules;

// Page object
$ListadoMasterBuscarExcel = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
/**
 * Script de Exportación de Excel - HERCULES
 * IMPORTANTE: No debe haber NINGÚN espacio o etiqueta HTML fuera de los tags de PHP.
 */

// 1. INICIALIZACIÓN
require __DIR__ . "/../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Función de exportación corregida
function exportCustomReportToExcel($filename, array $records) {
    if (empty($records)) {
        die("No hay registros para exportar.");
    }

    // Limpiar cualquier salida previa (espacios, errores, advertencias)
    if (ob_get_length()) {
        ob_end_clean();
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 1. Encabezados
    $headers = array_keys($records[0]);
    $sheet->fromArray($headers, NULL, 'A1');
    $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->getFont()->setBold(true);

    // 2. Datos
    $sheet->fromArray($records, NULL, 'A2');

    // 3. Auto-ajustar columnas
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // 4. Headers para descarga limpia
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    
    exit(); // Finaliza el proceso para evitar que PHPMaker inyecte el footer HTML
}

// 2. LÓGICA DE PARÁMETROS
$id = $_GET["id"] ?? "";
$fecha_desde = ($_REQUEST["fd"] ?? "") . ' 00:00:00';
$fecha_hasta = ($_REQUEST["fh"] ?? "") . ' 23:59:59';
$tipo_mov = $_REQUEST["tipo_mov"] ?? null;

// Uso de QuotedValue correcto para 2024
$fd = QuotedValue($fecha_desde, DataType::STRING);
$fh = QuotedValue($fecha_hasta, DataType::STRING);

$sql = "";

switch($id) {
    case "reclamos":
        $sql = "SELECT
                Nreclamo, solicitante, telefono1, telefono2,
                email, ci_difunto, nombre_difunto, tipo,
                REPLACE(REPLACE(comentario,CHAR(10),''),CHAR(13),'') AS comentario,
                estatus, registro, registra, modificacion,
                modifica, replace(mensaje_cliente,'\n',' ') AS mensaje_cliente,
                seccion, modulo, sub_seccion, parcela, boveda
            FROM sco_reclamo
            WHERE registro BETWEEN $fd AND $fh 
            ORDER BY registro DESC;";
        $filename = "hercules_reclamos_" . date('Ymd') . ".xlsx";
        break;

    case "orden_salida":
        $sql = "SELECT
                a.Norden_salida, a.fecha_hora, CONCAT(a.username, ' - ', b.nombre) AS solicitante,
                g.userlevelname AS area, CONCAT(a.conductor, ' - ', c.nombre) AS conductor,
                a.acompanantes, m.nombre AS marca, d.nombre AS modelo,
                a.placa, f.tipo, f.anho, f.color,
                a.motivo, a.observaciones, a.autoriza, a.fecha_autoriza, p.valor2 AS estatus
            FROM sco_orden_salida AS a
                LEFT OUTER JOIN sco_user AS b ON b.username = a.username
                LEFT OUTER JOIN sco_user AS c ON c.username = a.conductor
                LEFT OUTER JOIN userlevels AS g ON g.userlevelid = a.grupo
                LEFT OUTER JOIN sco_flota AS f ON f.placa = a.placa
                LEFT OUTER JOIN sco_marca AS m ON m.Nmarca = f.marca
                LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = f.modelo
                LEFT OUTER JOIN sco_parametro AS p ON p.valor1 = a.estatus AND p.codigo = '031'
            WHERE a.fecha_hora BETWEEN $fd AND $fh 
            ORDER BY a.fecha_hora DESC;";
        $filename = "hercules_ordenes_salida_" . date('Ymd') . ".xlsx";
        break;
        
    case "mttotecnico":
        $sql = "SELECT
                a.Nmttotecnico, a.fecha_registro, CONCAT(a.user_solicita, ' - ', b.nombre) AS solicitante,
                a.tipo_solicitud, a.unidad_solicitante,
                a.area_falla, a.comentario,
                a.prioridad, a.estatus, a.falla_atendida_por, a.diagnostico, a.solucion, a.requiere_materiales,
                a.materiales, CONCAT(a.user_diagnostico, ' - ', c.nombre) AS user_diagnostico,
                a.fecha_solucion
            FROM sco_mttotecnico AS a
                LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita
                LEFT OUTER JOIN sco_user AS c ON c.username = a.user_diagnostico
            WHERE a.fecha_registro BETWEEN $fd AND $fh 
            ORDER BY a.fecha_registro DESC;";
        $filename = "hercules_mtto_tecnico_" . date('Ymd') . ".xlsx";
        break;

    case "flotas":
        $sql = "SELECT
                a.Nflota_incidencia AS id,
                a.fecha_registro,
                e.nombre AS area, b.tipo,
                c.nombre AS marcas, d.nombre AS modelo,
                b.placa, b.color, b.anho,
                b.serial_carroceria, b.serial_motor,
                a.tipo AS estatus,
                f.campo_descripcion AS falla,
                g.campo_descripcion AS reparacion,
                replace(a.diagnostico, '\r\n', '') AS diagnostico, a.solicitante,
                replace(a.nota, '\r\n', '') AS nota,
                h.nombre AS proveedor,
                a.username AS regitra,
                a.username_diagnostica,
                a.fecha_reparacion
            FROM
                sco_flota_incidencia AS a
                JOIN sco_flota AS b ON b.Nflota = a.flota
                LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca
                LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo
                LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota
                LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH'
                LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND f.tabla = 'REPARARVH'
                LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor
            WHERE a.fecha_registro BETWEEN $fd AND $fh 
            ORDER BY a.fecha_registro DESC;";
        $filename = "hercules_flotas_" . date('Ymd') . ".xlsx";
        break;

    case "lapidas":
        $sql = "SELECT
                a.Nlapidas_registro AS id,
                a.solicitante, b.campo_descripcion AS parentesco,
                a.telefono1, a.telefono2, a.email, a.ci_difunto, a.nombre_difunto,
                a.tipo, replace(a.comentario, '\r\n', '') AS comentario, a.estatus,
                a.registro, a.registra,
                a.modificacion, a.modifica,
                a.seccion, a.modulo, a.sub_seccion, a.parcela, a.boveda,
                a.contrato
            FROM
                sco_lapidas_registro AS a
                LEFT OUTER JOIN sco_tabla AS b ON a.parentesco = b.campo_codigo AND b.tabla = 'PARENTESCOS'
            WHERE a.registro BETWEEN $fd AND $fh 
            ORDER BY a.registro DESC;";
        $filename = "hercules_lapidas_" . date('Ymd') . ".xlsx";
        break;

    case "parcelas":
        $fechaSQL = "";
        $orderByClause = "id DESC"; 

        switch($tipo_mov) {
            case "registro":
                $fechaSQL = "fecha_registro";
                break;
            case "compra":
                $fechaSQL = "fecha_compra";
                break;
            case "venta":
                $fechaSQL = "fecha_venta";
                break;
            default:
                break;
        }

        $whereClause = "1=1";
        if (!empty($fechaSQL)) {
            $whereClause = "$fechaSQL BETWEEN $fd AND $fh ";
            $orderByClause = "$fechaSQL DESC";
        }

        $sql = "SELECT
                Nparcela_ventas AS id, ci_vendedor, vendedor,
                seccion, modulo, subseccion, parcela,
                usuario_compra, fecha_compra, valor_compra, moneda_compra,
                tasa_compra, ci_comprador, comprador, usuario_vende,
                fecha_venta, valor_venta, moneda_venta, tasa_venta,
                id_parcela, replace(nota, '\n ', ' ') AS nota, estatus, fecha_registro,
                numero_factura, orden_pago
            FROM
                sco_parcela_ventas
            WHERE $whereClause
            ORDER BY $orderByClause;";
        $filename = "hercules_parcelas_" . date('Ymd') . ".xlsx";
        break;

    case "compras":
        $sql = "SELECT
                *
            FROM sco_orden_compra
            WHERE
                fecha BETWEEN $fd AND $fh 
            ORDER BY fecha DESC;";
        $filename = "hercules_compras_" . date('Ymd') . ".xlsx"; 
        break;
        
    case "otros":
    default:
        break;
}

// 4. EJECUCIÓN Y EXPORTACIÓN
if (!empty($sql)) {
    // 4.1. Ejecutar la consulta con PHPMaker
    // 🟢 Uso de la función nativa ExecuteRows()
    try {
        $developer_records = ExecuteRows($sql);
    } catch (\Exception $e) {
        // Manejo de error de la base de datos de PHPMaker
        die("Error al ejecutar la consulta: " . $e->getMessage());
    }

    // 4.2. Exportar el resultado usando la clase ExportReport de PHPMaker
    exportCustomReportToExcel($filename, $developer_records);
}
?>
<?= GetDebugMessage() ?>
