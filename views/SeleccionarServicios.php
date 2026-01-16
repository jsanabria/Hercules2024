<?php

namespace PHPMaker2024\hercules;

// Page object
$SeleccionarServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// =========================================================================================================
// MONITOREO DE SERVICIOS - VERSIÓN CON MODALES DINÁMICOS
// Este script asume la disponibilidad de las funciones de PHPMaker 2024 (CurrentUserName, ExecuteRow, etc.)
// y la integración de Bootstrap 5.3 y Font Awesome.
// =========================================================================================================

use function PHPMaker2024\hercules\HtmlEncode;

// --- 1. OBTENCIÓN DE DATOS DEL USUARIO ---
$username = CurrentUserName();
$path = "../../carpetacarga/";

// Consulta 1: Obtener proveedor y tipo_proveedor
$sql_user_data = "SELECT a.proveedor, b.tipo_proveedor FROM sco_user a JOIN userlevels b on b.userlevelid = a.`level` WHERE a.username = '" . AdjustSql($username, "s") . "' LIMIT 1";
$row_user = ExecuteRow($sql_user_data);

if ($row_user) {
    $proveedor = $row_user["proveedor"];
    $tipo_proveedor = $row_user["tipo_proveedor"];
} else {
    header("Location: MonitoriarServicios");
    exit();
}

// --- 2. Mapeo del Tipo de Proveedor ---
$tipo_proveedor_map = [
    0 => "N/A",
    1 => "Funeraria",
    2 => "Cementario",
    3 => "Ataudes",
    4 => "Arreglos Florales",
    5 => "Ofrendas de Voz",
    6 => "Obituarios",
];
$tp = $tipo_proveedor_map[(int)$tipo_proveedor] ?? "Desconocido";

// --- 3. Obtener el valor de Preventa ---
$sql_preventa = "SELECT valor4 FROM sco_parametro WHERE codigo = '009' AND valor2 = " . AdjustSql($proveedor, "s") . " LIMIT 1";
$preventa = ExecuteScalar($sql_preventa);
$preventa = $preventa ?? 'N/A';

// --- 4. Obtener el nombre del Proveedor y Redirección de validación ---
$sql_nombre_prov = "SELECT b.nombre FROM sco_user a JOIN sco_proveedor b on b.Nproveedor = a.proveedor WHERE a.username = '" . AdjustSql($username, "s") . "' LIMIT 1";
$nombre_proveedor = ExecuteScalar($sql_nombre_prov);

if (empty(trim($nombre_proveedor))) {
    header("Location: monitoriar_servicios.php");
    exit();
}

// --- 5. Construcción de la cláusula WHERE ---
$where = "a.paso = " . AdjustSql($tipo_proveedor, "s");

if ($tipo_proveedor == '5') {
    $where .= " AND a.servicio_tipo = 'OFVO'";
} elseif ($tipo_proveedor == '6') {
    $sql_servicio = "SELECT b.servicio FROM sco_user a JOIN sco_ofrece_servicio b on b.proveedor = a.proveedor WHERE a.username = '" . AdjustSql($username, "s") . "' LIMIT 1";
    $servicio = ExecuteScalar($sql_servicio);
    if (!empty($servicio)) {
        $where .= " AND a.servicio = " . AdjustSql($servicio, "s");
    }
}

// --- 6. Consulta principal de Servicios ---
if ($tipo_proveedor == '5') {
    $sql_servicios = "SELECT DISTINCT 
        a.expediente, 
        d.nombre_contacto AS contacto, 
        CONCAT(d.telefono_contacto1, ' / ', IFNULL(d.telefono_contacto2,'')) AS telf_contacto, 
        CONCAT(d.nombre_fallecido, ' ', d.apellidos_fallecido) as difunto, 
        d.capilla, 
        a.nota AS voces, 
        date_format(a.fecha_fin, '%d/%m/%Y') as fecha_serv, 
        date_format(a.hora_fin, '%h:%i%p') as hora_serv, 
        a.fecha_fin as fecha, 
        if(a.proveedor=" . AdjustSql($proveedor, "s") . ", '1', (SELECT nombre FROM sco_proveedor WHERE Nproveedor = a.proveedor)) as proveedor_nombre, 
        a.proveedor as prov, 
        (SELECT date_format(fecha_inicio, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fecha_inicio, 
        (SELECT fecha_inicio FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fi, 
        (SELECT date_format(hora_inicio, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as hora_inicio, 
        (SELECT date_format(fecha_fin, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fecha_fin, 
        (SELECT date_format(hora_fin, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as hora_fin, 
        IF(d.espera_cenizas='S', 'Si', 'NO') as espera_cenizas, a.servicio_atendido, a.Norden, a.adjunto, a.paso 
    FROM 
        sco_orden a 
        JOIN sco_servicio b ON b.Nservicio = a.servicio 
        JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        LEFT OUTER JOIN view_expediente_servicio d ON d.Nexpediente = a.expediente 
    WHERE 
        $where AND d.estatus NOT IN (6, 7) 
    ORDER BY fi, a.expediente";
} else {
    $sql_servicios = "SELECT 
        a.expediente, 
        d.nombre_contacto AS contacto, 
        CONCAT(d.telefono_contacto1, ' / ', IFNULL(d.telefono_contacto2,'')) AS telf_contacto, 
        CONCAT(d.nombre_fallecido, ' ', d.apellidos_fallecido) as difunto, 
        d.capilla, 
        a.nota AS voces, 
        date_format(a.fecha_fin, '%d/%m/%Y') as fecha_serv, 
        date_format(a.hora_fin, '%h:%i%p') as hora_serv, 
        a.fecha_fin as fecha, 
        if(a.proveedor=" . AdjustSql($proveedor, "s") . ", '1', (SELECT nombre FROM sco_proveedor WHERE Nproveedor = a.proveedor)) as proveedor_nombre, 
        a.proveedor as prov, 
        (SELECT date_format(fecha_inicio, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fecha_inicio, 
        (SELECT fecha_inicio FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fi, 
        (SELECT date_format(hora_inicio, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as hora_inicio, 
        (SELECT date_format(fecha_fin, '%d/%m/%Y') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as fecha_fin, 
        (SELECT date_format(hora_fin, '%h:%i%p') FROM sco_orden WHERE expediente = a.expediente AND paso = '1' LIMIT 1) as hora_fin, 
        IF(d.espera_cenizas='S', 'Si', 'NO') as espera_cenizas, a.adjunto, a.Norden, a.servicio_atendido, a.paso 
    FROM 
        sco_orden a 
        JOIN sco_servicio b ON b.Nservicio = a.servicio 
        JOIN sco_adjunto c ON c.servicio = b.Nservicio AND c.Nadjunto = a.adjunto 
        LEFT OUTER JOIN view_expediente_servicio d ON d.Nexpediente = a.expediente 
    WHERE 
        $where AND d.estatus NOT IN (6, 7) 
    ORDER BY fi, a.expediente";
}

$servicios = ExecuteRows($sql_servicios);
$total_servicios = is_array($servicios) ? count($servicios) : 0;
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4 text-primary">
                <i class="fas fa-handshake me-2"></i> Monitor de Servicios Asignados: <?php echo HtmlEncode($tp); ?>
            </h3>
        </div>
    </div>
    
    <div class="card shadow-lg border-primary">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Servicios Contratados (Preventa: <?php echo HtmlEncode($preventa); ?>)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-sm-1 text-center">Acción / Proveedor</th>
                            <th class="col-sm-1">Exp. #</th>
                            <th class="col-sm-1">Contacto</th>
                            <th class="col-sm-2">Teléfonos</th>
                            <th class="col-sm-1">Difunto</th>
                            <th class="col-sm-1">Capilla</th>
                            <th class="col-sm-1">Inicia</th>
                            <th class="col-sm-1">Fin</th>
                            <th class="col-sm-1">Tema / Arreglo</th>
                            <th class="col-sm-1">Voces / Nota / Esquela</th>
                            <th class="col-sm-1">Pautado</th>
                            <th class="col-sm-1">E.C.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($total_servicios > 0): ?>
                            <?php foreach ($servicios as $row): 
                                
                                // Sub-consulta para obtener Tema/Arreglo (N+1)
                                $contenido = "";
                                if ($row["paso"] == '5') {
                                    $sql2 = "SELECT b.nota AS tema FROM sco_orden a JOIN sco_adjunto b ON b.servicio = a.servicio AND b.Nadjunto = a.adjunto WHERE a.expediente = " . AdjustSql($row["expediente"], "s") . " AND a.paso = '5' AND a.servicio_tipo = 'OFVO' LIMIT 1";
                                    $row2 = ExecuteRow($sql2);
                                    if ($row2) {
                                        $contenido = HtmlEncode($row2["tema"]);
                                    }
                                } else {
                                    $sql2 = "SELECT b.nota AS tema FROM sco_orden a JOIN sco_adjunto b ON b.servicio = a.servicio AND b.Nadjunto = a.adjunto WHERE a.expediente = " . AdjustSql($row["expediente"], "s") . " AND a.paso = " . AdjustSql($row["paso"], "s") . " AND a.adjunto = " . AdjustSql($row["adjunto"], "s") . " LIMIT 1";
                                    $row2 = ExecuteRow($sql2);
                                    if ($row2) {
                                        $contenido = HtmlEncode($row2["tema"]);
                                    }
                                }
                                
                                $chkmk = ($row["servicio_atendido"] == "S") ? '<span class="text-success ms-1" title="Servicio Atendido"><i class="fas fa-check-circle"></i></span>' : '';
                                
                                // Lógica de la celda de acción/proveedor
                                $is_assigned_to_other = $row["proveedor_nombre"] != '1' && $row["prov"] != $proveedor;

                                // Determinar el archivo de destino (Target File)
                                if ($tipo_proveedor == '5') {
                                    $target_file = 'TomarServicio';
                                    $modal_title = 'Tomar/Editar Ofrendas de Voz';
                                } elseif ($tipo_proveedor == '6') {
                                    $target_file = 'TomarServicio3';
                                    $modal_title = 'Tomar/Editar Obituario';
                                } else {
                                    $target_file = 'TomarServicio2';
                                    $modal_title = 'Tomar/Editar Servicio Proveedor';
                                }
                                
                                // Preparar parámetros base para JavaScript
                                $js_params_data = [
                                    'proveedor' => HtmlEncode($proveedor),
                                    'username' => HtmlEncode($username),
                                    'Norden' => HtmlEncode($row["Norden"] ?? ''),
                                    'Nexpediente' => HtmlEncode($row["expediente"] ?? ''),
                                ];
                                $js_params_json = json_encode($js_params_data); // Codificar a JSON para el atributo data-params
                                

                                if ($row["proveedor_nombre"] == '1') { // Servicio sin asignar
                                    $btn_class = "btn-success";
                                    $btn_text = "Tomar Servicio";
                                    // Nuevo botón que activa el modal
                                    $action_content = '<button type="button" class="btn btn-sm ' . $btn_class . '" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#serviceModal" 
                                                        data-file="' . HtmlEncode($target_file) . '" 
                                                        data-title="' . HtmlEncode($modal_title) . '"
                                                        data-params=\'' . $js_params_json . '\' 
                                                        onclick="loadServiceModal(this)">' . $btn_text . '</button>';
                                } elseif ($row["prov"] == $proveedor) { // Servicio asignado a este proveedor
                                    $btn_class = "btn-warning";
                                    $btn_text = "Editar Servicio";
                                    // Nuevo botón que activa el modal
                                    $action_content = '<button type="button" class="btn btn-sm ' . $btn_class . '" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#serviceModal" 
                                                        data-file="' . HtmlEncode($target_file) . '" 
                                                        data-title="' . HtmlEncode($modal_title) . '"
                                                        data-params=\'' . $js_params_json . '\' 
                                                        onclick="loadServiceModal(this)">' . $btn_text . '</button>';
                                } else { // Servicio asignado a otro proveedor
                                    $action_content = '<span class="btn btn-sm btn-danger disabled" title="Asignado a: ' . HtmlEncode($row["proveedor_nombre"]) . '">' . HtmlEncode($row["proveedor_nombre"]) . '</span>';
                                }
                                
                                // Lógica para Voces/Esquela/Nota
                                $voces_content = HtmlEncode($row["voces"]);
                                if ($row["paso"] == '6') {
                                    $voces_content = str_replace("|", ":", $voces_content);
                                    $voces_content = str_replace("---", "<br>", $voces_content);
                                    // El enlace de previsualización se mantiene en una nueva pestaña (target="_blank") para que se vea completo.
                                    $voces_content = '<a href="obituario_preview2.php?Norden=' . HtmlEncode($row["Norden"]) . '" target="_blank" class="text-decoration-none">' . $voces_content . '</a>';
                                }

                            ?>
                            <tr>
                                <td class="text-center" style="min-width: 120px;"><?php echo $action_content; ?></td>
                                <td><?php echo HtmlEncode($row["expediente"]) . $chkmk; ?></td>
                                <td><?php echo HtmlEncode($row["contacto"]); ?></td>
                                <td><?php echo HtmlEncode($row["telf_contacto"]); ?></td>
                                <td><strong class="text-primary"><?php echo HtmlEncode($row["difunto"]); ?></strong></td>
                                <td><?php echo HtmlEncode($row["capilla"]); ?></td>
                                <td><?php echo HtmlEncode($row["fecha_inicio"] . " " . $row["hora_inicio"]); ?></td>
                                <td><?php echo HtmlEncode($row["fecha_fin"] . " " . $row["hora_fin"]); ?></td>
                                <td><strong class="text-secondary"><?php echo $contenido; ?></strong></td>
                                <td><strong class="text-secondary"><?php echo $voces_content; ?></strong></td>
                                <td><?php echo HtmlEncode($row["fecha_serv"] . " " . $row["hora_serv"]); ?></td>
                                <td><?php echo HtmlEncode($row["espera_cenizas"]); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12" class="text-center table-warning">
                                    <i class="fas fa-info-circle me-2"></i> &laquo; No hay Servicios Pendientes &raquo;
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12" class="text-center table-light text-primary">
                                <strong>Total Servicios: <?php echo $total_servicios; ?></strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Genérico para la Toma de Servicios -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="serviceModalLabel">Cargando Acción...</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="serviceModalBody">
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2 text-primary">Cargando formulario de servicio...</p>
                </div>
            </div>
            <!-- Los botones de acción se cargarán dentro del formulario en el modal body -->
            <!-- <div class="modal-footer"> </div> -->
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap y Lógica del Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    /**
     * Carga dinámicamente el contenido del script de acción (establece_datos*.php)
     * dentro del cuerpo del modal mediante AJAX (Fetch API).
     * @param {HTMLElement} button El botón que fue presionado.
     */
    function loadServiceModal(button) {
        const targetFile = button.dataset.file;
        const modalTitle = button.dataset.title || 'Detalle de Servicio';
        const paramsJson = button.dataset.params;
        const params = JSON.parse(paramsJson);
        
        const modalBody = document.getElementById('serviceModalBody');
        const modalTitleElement = document.getElementById('serviceModalLabel');

        // 1. Mostrar estado de carga
        modalTitleElement.textContent = modalTitle;
        modalBody.innerHTML = `
            <div class="loading-spinner d-block">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <p class="mt-2 text-primary">Cargando formulario de servicio...</p>
            </div>
        `;

        // 2. Construir la URL con parámetros
        const urlParams = new URLSearchParams();
        for (const key in params) {
            if (params.hasOwnProperty(key) && params[key]) {
                urlParams.append(key, params[key]);
            }
        }
        const fullUrl = `${targetFile}?${urlParams.toString()}`;
        
        console.log("Cargando URL: ", fullUrl);

        // 3. Cargar contenido vía Fetch API
        fetch(fullUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.text();
            })
            .then(html => {
                // 4. Inyectar el HTML en el cuerpo del modal
                // IMPORTANTE: Los scripts de acción (establece_datos*.php) deben
                // retornar SÓLO el fragmento HTML del formulario, NO un documento HTML completo.
                modalBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Error al cargar el contenido del modal:', error);
                modalBody.innerHTML = `<div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> Error al cargar el servicio. 
                    Verifique que el script ${targetFile} existe y está configurado para devolver solo el fragmento de formulario.
                </div>`;
            });
    }

    // Opcional: Limpiar el modal al cerrarse (para prevenir que se muestre el contenido anterior)
    const serviceModal = document.getElementById('serviceModal')
    if (serviceModal) {
      serviceModal.addEventListener('hidden.bs.modal', function (event) {
        const modalBody = document.getElementById('serviceModalBody');
        modalBody.innerHTML = ''; // Limpiar el contenido al cerrar
      })
    }
</script>

<?= GetDebugMessage() ?>
