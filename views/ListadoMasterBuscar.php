<?php

namespace PHPMaker2024\hercules;

// Page object
$ListadoMasterBuscar = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Asegúrate de que las funciones ExecuteScalar, ExecuteRow, y la conexión $link
// (que se asume está definida en conexBD.php) estén disponibles en este ámbito.

// =================================================================================
// 1. SANITIZACIÓN DE ENTRADAS (Previene SQL Injection y XSS)
// =================================================================================

// Sanitizar todas las variables de entrada que serán usadas en consultas SQL y HTML.
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$fecha_desde = filter_input(INPUT_GET, "fecha_desde", FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$fecha_hasta = filter_input(INPUT_GET, "fecha_hasta", FILTER_SANITIZE_SPECIAL_CHARS) ?? '';
$tipo_mov = filter_input(INPUT_GET, "tipo_mov", FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

$out = '';
$start_datetime = $fecha_desde . ' 00:00:00';
$end_datetime = $fecha_hasta . ' 23:59:59';


// Ejecutar la consulta en función del ID
switch($id) {
case "reclamos":
    // 3. CONSULTA OPTIMIZADA: Obtiene todos los resultados en una sola llamada.
    $sql = "SELECT 
                Nreclamo, solicitante, ci_difunto, nombre_difunto, 
                tipo, estatus, registro, registra 
            FROM 
                sco_reclamo 
            WHERE 
                registro BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                registro DESC;"; 
    
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'ListadoMasterBuscarExcel?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Reclamo. #</th>';
          $out .= '<th scope="col">Solicitante</th>';
          $out .= '<th scope="col">C.I. Difunto</th>';
          $out .= '<th scope="col">Nombre Difunto</th>';
          $out .= '<th scope="col">Tipo</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Fecha Registro</th>';
          $out .= '<th scope="col">Apertura</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE: Itera sobre todos los resultados obtenidos de una sola vez.
        foreach($rows as $row) {
            $out .= '<tr>';
            $out .= '<th scope="row"><a href="../sco_reclamoview.php?showdetail=&Nreclamo=' . htmlspecialchars($row["Nreclamo"] ?? '') . '" target="_blank">' . htmlspecialchars($row["Nreclamo"] ?? '') . '</a></th>';
            $out .= '<td>' . htmlspecialchars($row["solicitante"] ?? '') . '</td>';
            // Aquí el error solía ser común si ci_difunto o apellidos venían nulos
            $out .= '<td>' . htmlspecialchars(($row["ci_difunto"] ?? '') . " " . ($row["apellidos_fallecido"] ?? '')) . '</td>';
            $out .= '<td>' . htmlspecialchars($row["nombre_difunto"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["tipo"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["registro"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["registra"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Reclamos: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "orden_salida":
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    $sql = "SELECT 
                a.Norden_salida, a.fecha_hora, CONCAT(a.username, ' - ', b.nombre) AS solicitante, 
                g.userlevelname AS area, CONCAT(a.conductor, ' - ', c.nombre) AS conductor,
                m.nombre AS marca, d.nombre AS modelo, 
                a.placa, f.tipo, a.motivo, 
                p.valor2 AS estatus
            FROM sco_orden_salida AS a 
                LEFT OUTER JOIN sco_user AS b ON b.username = a.username 
                LEFT OUTER JOIN sco_user AS c ON c.username = a.conductor 
                LEFT OUTER JOIN userlevels AS g ON g.userlevelid = a.grupo 
                LEFT OUTER JOIN sco_flota AS f ON f.placa = a.placa 
                LEFT OUTER JOIN sco_marca AS m ON m.Nmarca = f.marca 
                LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = f.modelo 
                LEFT OUTER JOIN sco_parametro AS p ON p.valor1 = a.estatus AND p.codigo = '031' 
            WHERE 
                a.fecha_hora BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                a.fecha_hora DESC;";
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'listado_master_buscar_excel.php?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Orden Salida. #</th>';
          $out .= '<th scope="col">Fecha</th>';
          $out .= '<th scope="col">Solicitante</th>';
          $out .= '<th scope="col">Area</th>';
          $out .= '<th scope="col">Conductor</th>';
          $out .= '<th scope="col">Marca</th>';
          $out .= '<th scope="col">Modelo</th>';
          $out .= '<th scope="col">Placa</th>';
          $out .= '<th scope="col">Tipo</th>';
          $out .= '<th scope="col">Motivo</th>';
          $out .= '<th scope="col">Estatus</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
             $out .= '<th scope="row"><a href="../sco_orden_salidaview.php?showdetail=&Norden_salida=' . htmlspecialchars($row["Norden_salida"]) . '" target="_blank">' . htmlspecialchars($row["Norden_salida"]) . '</a></th>';
              $out .= '<td>' . htmlspecialchars($row["fecha_hora"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["solicitante"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["area"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["conductor"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["marca"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["modelo"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["placa"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["tipo"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["motivo"] ?? '') . '</td>';
              $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Ordenes: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "mttotecnico":
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    $sql = "SELECT 
                a.Nmttotecnico, a.fecha_registro, CONCAT(a.user_solicita, ' - ', b.nombre) AS solicitante, 
                a.tipo_solicitud, a.unidad_solicitante, a.area_falla, a.prioridad, a.estatus, a.diagnostico
            FROM 
                sco_mttotecnico AS a 
                LEFT OUTER JOIN sco_user AS b ON b.username = a.user_solicita  
            WHERE 
                a.fecha_registro BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                a.fecha_registro DESC;";
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'ListadoMasterBuscarExcel?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Id. #</th>';
          $out .= '<th scope="col">Fecha</th>';
          $out .= '<th scope="col">Solicitante</th>';
          $out .= '<th scope="col">Tipo</th>';
          $out .= '<th scope="col">Unidad</th>';
          $out .= '<th scope="col">Area Falla</th>';
          $out .= '<th scope="col">Prioridad</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Diagn&oacute;stico</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
            $out .= '<th scope="row"><a href="../sco_mttotecnicoview.php?Nmttotecnico=' . htmlspecialchars($row["Nmttotecnico"] ?? '') . '">' . htmlspecialchars($row["Nmttotecnico"] ?? '') . '</a></th>';
            // Se aplica ?? '' a cada celda
            $out .= '<td>' . htmlspecialchars($row["fecha_registro"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["solicitante"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["tipo_solicitud"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["unidad_solicitante"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["area_falla"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["prioridad"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["diagnostico"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Ordenes Mtto: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "flotas":
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    $sql = "SELECT 
                a.Nflota_incidencia AS id, 
                a.fecha_registro, 
                e.nombre AS area, b.tipo, 
                c.nombre AS marcas, d.nombre AS modelo, 
                b.placa, b.color, b.anho, 
                a.tipo AS estatus, 
                f.campo_descripcion AS falla, 
                g.campo_descripcion AS reparacion, 
                a.diagnostico
            FROM 
                sco_flota_incidencia AS a 
                JOIN sco_flota AS b ON b.Nflota = a.flota 
                LEFT OUTER JOIN sco_marca AS c ON c.Nmarca = b.marca 
                LEFT OUTER JOIN sco_modelo AS d ON d.Nmodelo = b.modelo 
                LEFT OUTER JOIN sco_tipo_flota AS e ON e.Ntipo_flota = b.tipo_flota 
                LEFT OUTER JOIN sco_tabla AS f ON f.campo_codigo = a.falla AND f.tabla = 'FALLASVH' 
                LEFT OUTER JOIN sco_tabla AS g ON g.campo_codigo = a.reparacion AND g.tabla = 'REPARARVH' 
                LEFT OUTER JOIN sco_proveedor AS h ON h.Nproveedor = a.proveedor  
            WHERE 
                a.fecha_registro BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                a.fecha_registro DESC;";
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'listado_master_buscar_excel.php?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Id. #</th>';
          $out .= '<th scope="col">Fecha</th>';
          $out .= '<th scope="col">Area</th>';
          $out .= '<th scope="col">Tipo</th>';
          $out .= '<th scope="col">Marca</th>';
          $out .= '<th scope="col">Modelo</th>';
          $out .= '<th scope="col">Placa</th>';
          $out .= '<th scope="col">Color</th>';
          $out .= '<th scope="col">A&ntilde;o</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Falla</th>';
          $out .= '<th scope="col">Diagn&oacute;stico</th>';
          $out .= '<th scope="col">Reparaci&oacute;n</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
            $out .= '<th scope="row"><a href="../sco_flota_incidenciaview.php?showdetail=&Nflota_incidencia=' . htmlspecialchars($row["id"] ?? '') . '" target="_blank">' . htmlspecialchars($row["id"] ?? '') . '</a></th>';
            $out .= '<td>' . htmlspecialchars($row["fecha_registro"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["area"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["tipo"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["marcas"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["modelo"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["placa"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["color"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["anho"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["falla"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["diagnostico"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["reparacion"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Incidencia: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;  
case "lapidas":
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    
    // Determinar la columna de fecha a usar (si es "registro" o el estatus modificado)
    $fecha_columna = ($tipo_mov === 'registro') ? 'a.registro' : 'a.modificacion';

    $sql = "SELECT 
                a.Nlapidas_registro AS id, 
                a.solicitante, b.campo_descripcion AS parentesco, 
                a.email, a.ci_difunto, a.nombre_difunto, 
                a.tipo, a.estatus, a.registro, a.registra, 
                a.contrato
            FROM 
                sco_lapidas_registro AS a 
                LEFT OUTER JOIN sco_tabla AS b ON a.parentesco = b.campo_codigo AND b.tabla = 'PARENTESCOS' 
            WHERE 
                $fecha_columna BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                a.registro DESC;";
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'ListadoMasterBuscarExcel?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '&tipo_mov=' . $tipo_mov . '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Id. #</th>';
          $out .= '<th scope="col">Fecha</th>';
          $out .= '<th scope="col">Solicitante</th>';
          $out .= '<th scope="col">Parentesco</th>';
          $out .= '<th scope="col">Email</th>';
          $out .= '<th scope="col">CI Difunto</th>';
          $out .= '<th scope="col">Nombre Difunto</th>';
          $out .= '<th scope="col">Tipo</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Registra</th>';
          $out .= '<th scope="col">Contrato</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
            $out .= '<th scope="row"><a href="../sco_lapidas_registroview.php?showdetail=&Nlapidas_registro=' . htmlspecialchars($row["id"] ?? '') . '" target="_blank">' . htmlspecialchars($row["id"] ?? '') . '</a></th>';
            $out .= '<td>' . htmlspecialchars($row["registro"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["solicitante"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["parentesco"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["email"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["ci_difunto"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["nombre_difunto"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["tipo"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["registra"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["contrato"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Registros: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "parcelas":
    // Determinar la columna de fecha a usar según el tipo de movimiento
    $fechaSQL = "fecha_registro";
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
    }
    
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    $sql = "SELECT 
                Nparcela_ventas AS id, ci_vendedor, vendedor, seccion, modulo, subseccion, parcela, usuario_compra, 
                DATE_FORMAT(fecha_compra, '%d/%m/%Y') AS fecha_compra, ci_comprador, comprador, usuario_vende, 
                DATE_FORMAT(fecha_venta, '%d/%m/%Y') AS fecha_venta, id_parcela, estatus, 
                DATE_FORMAT(fecha_registro, '%d/%m/%Y') AS fecha_registro, numero_factura, orden_pago 
            FROM 
                sco_parcela_ventas 
            WHERE 
                $fechaSQL BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                $fechaSQL DESC;";
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'ListadoMasterBuscarExcel?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '&tipo_mov=' . $tipo_mov . '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Id. #</th>';
          $out .= '<th scope="col">Fecha Compra</th>';
          $out .= '<th scope="col">Vendedor</th>';
          $out .= '<th scope="col">Secci&oacute;n</th>';
          $out .= '<th scope="col">Modulo</th>';
          $out .= '<th scope="col">Sub-Secci&oacute;n</th>';
          $out .= '<th scope="col">Parcel</th>';
          $out .= '<th scope="col">Comprador</th>';
          $out .= '<th scope="col">Numero Factura</th>';
          $out .= '<th scope="col">Orden Pago</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Fecha Venta</th>';
          $out .= '<th scope="col">Usuario Compra</th>';
          $out .= '<th scope="col">Usuario Vende</th>';
          $out .= '<th scope="col">Fecha Registro</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
            $out .= '<th scope="row">...' . htmlspecialchars($row["id"] ?? '') . '</th>';
            $out .= '<td>' . htmlspecialchars($row["fecha_compra"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["vendedor"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["seccion"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["modulo"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["subseccion"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["parcela"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["comprador"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["numero_factura"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["orden_pago"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["estatus"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["fecha_venta"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["usuario_compra"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["usuario_vende"] ?? '') . '</td>';
            $out .= '<td>' . htmlspecialchars($row["fecha_registro"] ?? '') . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Parcelas: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "compras":
    // 3. CONSULTA OPTIMIZADA: Se mantiene la complejidad del JOIN, pero se ejecuta una sola vez.
    $sql = "SELECT 
                Norden_compra, fecha, unidad_solicitante, estatus, username
            FROM 
                sco_orden_compra 
            WHERE 
                fecha BETWEEN '$start_datetime' AND '$end_datetime'
            ORDER BY 
                fecha DESC;"; 
                
    $rows = ExecuteRows($sql);
    $contar = count($rows);

    // $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'ListadoMasterBuscarExcel?id=' . $id .'&fd=' . $fecha_desde .'&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<button class="btn btn-primary" onclick="js:window.location.href = \'listado_master_buscar_excel.php?id=' . $id . '&fd=' . $fecha_desde . '&fh=' . $fecha_hasta. '\'">Exportar a Excel</button>';
    $out .= '<table class="table table-hover">';
      $out .= '<thead>';
        $out .= '<tr>';
          $out .= '<th scope="col">Orden Compra. #</th>';
          $out .= '<th scope="col">Fecha</th>';
          $out .= '<th scope="col">Unidad Solicitante</th>';
          $out .= '<th scope="col">Estatus</th>';
          $out .= '<th scope="col">Solicitante</th>';
        $out .= '</tr>';
      $out .= '</thead>';
      $out .= '<tbody>';
        // BUCLE EFICIENTE
        foreach($rows as $row) {
            $out .= '<tr>';
             $out .= '<th scope="row"><a href="../sco_orden_compraview.php?showdetail=sco_orden_compra_detalle&Norden_compra=' . htmlspecialchars($row["Norden_compra"]) . '" target="_blank">' . htmlspecialchars($row["Norden_compra"]) . '</a></th>';
              $out .= '<td>' . htmlspecialchars($row["fecha"]) . '</td>';
              $out .= '<td>' . htmlspecialchars($row["unidad_solicitante"]) . '</td>';
              $out .= '<td>' . htmlspecialchars($row["estatus"]) . '</td>';
              $out .= '<td>' . htmlspecialchars($row["username"]) . '</td>';
            $out .= '</tr>';
        }
        $out .= '<tr><th colspan="12" class="text-right">Total Ordenes de Compra: ' . number_format($contar, 0, ",", ".") . '</th></tr>';
      $out .= '</tbody>';
    $out .= '</table>';

    break;
case "otros": // Para configurarlo más adelante, por los momentos funcionara el primero
    // Si se necesita implementar el caso "otros", el patrón de optimización N+1 es el mismo.
    break;
default:
}

echo $out;

?>
<?= GetDebugMessage() ?>
