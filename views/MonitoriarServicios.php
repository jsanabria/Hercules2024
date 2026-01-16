<?php

namespace PHPMaker2024\hercules;

// Page object
$MonitoriarServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php

/**
 * Custom File: servicios_monitoreo.php
 * Usando funciones nativas de PHPMaker (ew.php) y Bootstrap.
 * NOTA: La variable $conn ya está disponible en Custom Files de PHPMaker.
 */

// --- 1. CONFIGURACIÓN DE FILTROS Y CLÁUSULAS ---

// 1a. Filtro de Fechas
$fecha_ini_sql = Get("fecha_ini") ? Get("fecha_ini") : null;
$fecha_fin_sql = Get("fecha_fin") ? Get("fecha_fin") : null;
$fecha_filter_clause = ""; 
$fecha_ini_display = "";
$fecha_fin_display = "";

if ($fecha_ini_sql && $fecha_fin_sql) {
    // Si ambas fechas están presentes, construye la cláusula AND
    $fecha_filter_clause = " AND (SELECT fecha_inicio FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) BETWEEN '" . AdjustSql($fecha_ini_sql) . "' AND '" . AdjustSql($fecha_fin_sql) . "'";
    
    // Formato de visualización (d/m/Y)
    $fecha_ini_display = date("d/m/Y", strtotime($fecha_ini_sql));
    $fecha_fin_display = date("d/m/Y", strtotime($fecha_fin_sql));
}

// 1b. Filtro de Pendientes (Checkbox)
$is_pendiente_filter_active = Get("pendiente") == '1';
$pendiente_filter_clause = "";

if ($is_pendiente_filter_active) {
    // Si el checkbox está marcado, agregamos la condición 'a.proveedor = 1'
    $pendiente_filter_clause = " AND a.proveedor = 1";
}


// La condición BASE que siempre debe estar en la cláusula WHERE (Estatus)
$where_base = "d.estatus NOT IN (6, 7)";

// CONSTRUCCIÓN FINAL DE LA CLÁUSULA WHERE
// Concatenamos la cláusula base, la opcional de fecha, y la opcional de pendiente
$where_clause_final = "WHERE " . $where_base . $fecha_filter_clause . $pendiente_filter_clause;


// Define la ruta de carga si aún es necesaria
$path = "../../carpetacarga/";

// Inicializa la cadena de preventa
$preventa = "";

// Consulta SQL 1: Obtener la cadena de título para el monitoreo
$sql_preventa = "
    SELECT 
        valor4 AS preventa, 
        (SELECT nombre FROM sco_proveedor WHERE Nproveedor = valor2) AS medio 
    FROM 
        sco_parametro 
    WHERE 
        codigo = '009';
";

// Usamos ExecuteRows para obtener todos los resultados de la primera consulta
$preventa_rows = ExecuteRows($sql_preventa);

if ($preventa_rows) {
    foreach ($preventa_rows as $row) {
        $preventa .= "\"" . $row["preventa"] . $row["medio"] . "\" / ";
    }
    // Limpia la cadena: elimina el último " / "
    $preventa = rtrim($preventa, " / ");
}

// --- 2. CONSULTA SQL PRINCIPAL (USANDO CLÁUSULA FINAL) ---

$sql_servicios = "
    SELECT DISTINCT
        a.expediente,
        d.nombre_contacto AS contacto,
        CONCAT(d.telefono_contacto1, ' / ', IFNULL(d.telefono_contacto2,'')) AS telf_contacto,
        CONCAT(d.nombre_fallecido, ' ', d.apellidos_fallecido) AS difunto, d.cedula_fallecido,
        d.capilla,
        d.servicio,
        a.nota AS voces,
        a.cantidad,
        DATE_FORMAT(a.fecha_fin, '%d/%m/%Y') AS fecha_serv,
        DATE_FORMAT(a.hora_fin, '%h:%i%p') AS hora_serv,
        a.fecha_fin AS fecha,
        IF(a.proveedor=1, '1', (SELECT nombre FROM sco_proveedor WHERE Nproveedor = a.proveedor)) AS proveedor,
        (SELECT DATE_FORMAT(fecha_inicio, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) AS fecha_inicio,
        (SELECT fecha_inicio FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) AS fi,
        (SELECT DATE_FORMAT(hora_inicio, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) AS hora_inicio, a.paso,
        (SELECT DATE_FORMAT(fecha_fin, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) AS fecha_fin,
        (SELECT DATE_FORMAT(hora_fin, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 0,1) AS hora_fin,
        IF(d.espera_cenizas='S', 'Si', 'NO') AS espera_cenizas, IF(a.paso=6, a.servicio, '0') AS medio,
        (SELECT Norden FROM sco_orden WHERE expediente = a.expediente AND paso = 6 AND servicio = a.servicio LIMIT 0,1) AS NordenObituario
    FROM
        sco_orden a
        JOIN sco_adjunto c ON c.servicio = a.servicio AND c.Nadjunto = a.adjunto
        LEFT OUTER JOIN view_expediente_servicio d ON d.Nexpediente = a.expediente
    
    -- CLAUSULA WHERE FINAL: Base + Fecha opcional + Pendiente opcional
    " . $where_clause_final . " 
    
    ORDER BY fi, a.expediente;
";

// Ejecutamos la consulta principal
$servicios_rows = ExecuteRows($sql_servicios);
$total_servicios = count($servicios_rows);
$servicios_pendientes = 0; // Inicializar contador de pendientes (se calculará en el loop)

?>
<style>
    /* Estilos opcionales para la Grilla/Card */
    .service-card {
        border-left: 5px solid;
        margin-bottom: 15px;
    }
    .service-card-1 { border-color: #28a745; } /* Servicio sin Tomar */
    .service-card-other { border-color: #dc3545; } /* Proveedor asignado */
    .detail-label {
        font-weight: 600;
        margin-right: 5px;
        color: #6c757d;
        display: block; 
    }
    .detail-value {
        display: block;
        word-wrap: break-word; 
    }
    .filter-form .form-control {
        max-width: 150px;
    }
    /* Estilo para el contenedor del filtro */
    .filter-container {
        padding: 10px 15px;
        border-radius: 4px;
        background-color: #ffffff; 
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    /* Texto indicando el estado del filtro */
    .filter-status {
        font-size: 0.9rem;
        font-weight: bold;
        color: #007bff;
    }
    .pending-filter-group {
        display: flex;
        align-items: center;
        margin-right: 15px;
    }
</style>

<div class="row grid-container">
    <div class="col-12">
        <div class="card shadow">
            
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Servicios Contratados (Monitoreo) <?php echo $preventa; ?></h3>
            </div>
            
            <div class="filter-container d-flex flex-wrap align-items-center justify-content-between">
                <form method="GET" class="filter-form d-flex flex-wrap align-items-center">
                    
                    <div class="pending-filter-group me-4 mb-2 mb-md-0">
                        <input type="checkbox" id="pendiente" name="pendiente" value="1" class="form-check-input me-1" 
                            <?php echo $is_pendiente_filter_active ? 'checked' : ''; ?>>
                        <label for="pendiente" class="form-check-label text-dark">Servicios Pendientes</label>
                    </div>

                    <label for="fecha_ini" class="me-2 mb-2 mb-md-0 text-dark">Desde:</label>
                    <input type="date" id="fecha_ini" name="fecha_ini" class="form-control me-3 mb-2 mb-md-0" value="<?php echo $fecha_ini_sql; ?>">
                    
                    <label for="fecha_fin" class="me-2 mb-2 mb-md-0 text-dark">Hasta:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control me-3 mb-2 mb-md-0" value="<?php echo $fecha_fin_sql; ?>">
                    
                    <button type="submit" class="btn btn-sm btn-info mb-2 mb-md-0">Aplicar Filtro</button>
                    
                    <?php if ($fecha_filter_clause || $is_pendiente_filter_active): ?>
                        <a href="<?php echo CurrentPage()->pageUrl(); ?>" class="btn btn-sm btn-secondary ms-2 mb-2 mb-md-0">Mostrar Todos</a>
                    <?php endif; ?>
                </form>
                
                <div class="filter-status mt-2 mt-md-0">
                    <?php 
                        $status_text = "Mostrando Todos los Servicios";
                        if ($is_pendiente_filter_active) {
                            $status_text = '<span class="text-warning">Filtrando SOLO Pendientes</span>';
                        }
                        if ($fecha_filter_clause) {
                             $status_text .= ' | <span class="text-danger">Rango: ' . $fecha_ini_display . ' - ' . $fecha_fin_display . '</span>';
                        } else if (!$is_pendiente_filter_active) {
                            // Si no hay filtro de pendiente ni de fecha, muestra el estado inicial
                            $status_text = '<span class="text-success">Mostrando Todos los Servicios</span>';
                        }
                        echo $status_text;
                    ?>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <?php if ($total_servicios > 0) : ?>
                        <?php foreach ($servicios_rows as $row) : 
                            
                            // Lógica de tipo de servicio (TP)
                            $tp = "N/A";
                            switch ($row["paso"]) {
                                case 1: $tp = "Funeraria"; break;
                                case 2: $tp = "Cementerio"; break;
                                case 3: $tp = "Ataudes"; break;
                                case 4: $tp = "Arreglos Florales"; break;
                                case 5: $tp = "Ofrendas de Voz"; break;
                                case 6:
                                    // Usamos ExecuteScalar para la subconsulta de un solo valor
                                    $sql_servicio_nombre = "SELECT nombre FROM sco_servicio WHERE Nservicio = '" . AdjustSql($row["medio"]) . "'";
                                    $nombre_servicio = ExecuteScalar($sql_servicio_nombre);
                                    $tp = "Obituarios: " . $nombre_servicio;
                                    break;
                            }

                            // Lógica de Contenido/Tema (Voces)
                            $contenido = "";
                            if ($row["paso"] == 6) {
                                $arr = explode("---", $row["voces"]);
                                $contenido = str_replace("Aviso|", "", end($arr)); 
                            } else {
                                $sql_tema = "SELECT b.nota AS tema FROM sco_orden a JOIN sco_adjunto b ON b.servicio = a.servicio AND b.Nadjunto = a.adjunto WHERE a.expediente = " . AdjustSql($row["expediente"]) . " AND a.paso = " . AdjustSql($row["paso"]);
                                $temas_rows = ExecuteRows($sql_tema);
                                $temas_list = [];
                                if ($temas_rows) {
                                    foreach ($temas_rows as $row2) {
                                        $temas_list[] = $row2["tema"];
                                    }
                                }
                                $contenido = implode(" / ", $temas_list);
                            }

                            // Lógica de Contenido Voces/Nota Cinta
                            $contenido_voces = $row["voces"];
                            if ($row["paso"] == 6) {
                                $contenido_voces = str_replace("|", ":", $row["voces"]);
                                $contenido_voces = str_replace("---", "<br>", $contenido_voces);
                                $contenido_voces = '<a href="ObituarioPreview?Norden=' . $row["NordenObituario"] . '" target="_blank">' . $contenido_voces . '</a>';
                            }
                            
                            // Lógica para contar servicios pendientes y asignar clase
                            $card_class = '';
                            if ($row["proveedor"] == '1') {
                                $card_class = 'service-card-1'; // Proveedor = '1' (Pendiente)
                                $servicios_pendientes++; // Contar el pendiente
                            } else {
                                $card_class = 'service-card-other'; // Proveedor asignado
                            }
                        ?>
                            <div class="col-12 mb-3">
                                <div class="card service-card <?php echo $card_class; ?>">
                                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                        <h5 class="mb-0">
                                            <span class="detail-label d-inline me-2">Exp. #:</span>
                                            <strong class="text-primary"><?php echo $row["expediente"]; ?></strong>
                                        </h5>
                                        <div>
                                            <?php if ($row["proveedor"] == '1') : ?>
                                                <span class="badge bg-success p-2">Servicio sin Tomar</span>
                                            <?php else : ?>
                                                <span class="badge bg-danger p-2">Proveedor: <?php echo $row["proveedor"]; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="mb-1"><span class="detail-label">Difunto:</span><strong class="detail-value text-dark"><?php echo $row["difunto"]; ?></strong></div>
                                                <div class="mb-1"><span class="detail-label">Capilla:</span><span class="detail-value"><?php echo $row["capilla"]; ?></span></div>
                                                <div class="mb-1"><span class="detail-label">Tipo:</span><span class="detail-value"><?php echo $tp; ?></span></div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="mb-1"><span class="detail-label">Contacto:</span><span class="detail-value"><?php echo $row["contacto"]; ?></span></div>
                                                <div class="mb-1"><span class="detail-label">Teléfonos:</span><span class="detail-value"><?php echo $row["telf_contacto"]; ?></span></div>
                                                <div class="mb-1"><span class="detail-label">Espera Cenizas:</span><span class="detail-value"><?php echo $row["espera_cenizas"]; ?></span></div>
                                            </div>
                                            <div class="col-12 col-md-4 mb-2">
                                                <div class="mb-1"><span class="detail-label">Inicio:</span><span class="detail-value"><?php echo $row["fecha_inicio"] . " " . $row["hora_inicio"]; ?></span></div>
                                                <div class="mb-1"><span class="detail-label">Fin:</span><span class="detail-value"><?php echo $row["fecha_fin"] . " " . $row["hora_fin"]; ?></span></div>
                                                <div class="mb-1"><span class="detail-label">Pautado:</span><span class="detail-value"><?php echo $row["fecha_serv"] . " " . $row["hora_serv"]; ?></span></div>
                                            </div>
                                            <div class="col-12 mt-2 pt-2 border-top">
                                                <div class="mb-1">
                                                    <span class="detail-label">Tema / Arreglo:</span>
                                                    <strong class="detail-value text-success"><?php echo $contenido; ?></strong>
                                                </div>
                                                <div class="mb-1">
                                                    <span class="detail-label">Voces / Nota Cinta:</span>
                                                    <strong class="detail-value text-info"><?php echo $contenido_voces; ?></strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                <strong>
                                    &laquo; No hay Servicios 
                                    <?php echo $is_pendiente_filter_active ? "Pendientes " : ""; ?>
                                    <?php echo $fecha_filter_clause ? "en el rango $fecha_ini_display - $fecha_fin_display" : "encontrados"; ?>
                                    &raquo;
                                </strong>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-footer text-center bg-primary text-white">
                Total Servicios Mostrados: <strong><?php echo $total_servicios; ?></strong> 
                <?php 
                    // El conteo de pendientes sólo tiene sentido si NO se está aplicando el filtro de pendientes
                    if (!$is_pendiente_filter_active): 
                ?>
                        | Servicios sin Proveedor (en esta vista): 
                        <?php if ($servicios_pendientes > 0): ?>
                            <strong class="text-warning"><?php echo $servicios_pendientes; ?></strong>
                        <?php else: ?>
                            <strong class="text-success">0</strong>
                        <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // En un Custom File de PHPMaker, puedes usar la librería jQuery existente.
    $("#regresar").click(function(){
        window.location.href = "index.php"; 
    }); 
    
    // Función para manejar el envío del formulario al cambiar el checkbox
    // Nota: Esto asegura que el filtro se aplique al tildar/destildar sin presionar el botón de Filtro.
    document.getElementById('pendiente').addEventListener('change', function() {
        this.closest('form').submit();
    });
</script>
<?php // Cierre de PHP al final del archivo Custom File ?>
<?= GetDebugMessage() ?>
