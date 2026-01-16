<?php

namespace PHPMaker2024\hercules;

// Page object
$OficioReligioso = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Este script asume que las funciones Execute(), ExecuteRows(), ExecuteScalar(), 
// CurrentUserName() y adjustSql() están disponibles en el entorno PHPMaker.

// Variables de búsqueda y estado
$search_expediente = $_POST['search_expediente'] ?? '';
$search_cedula = $_POST['search_cedula'] ?? '';
$search_nombre = $_POST['search_nombre'] ?? '';
$message = '';
$ministros_rs = [];
$rs = [];

## ----------------------------------------------------
## 1. Obtener Lista de Ministros Disponibles (para el Dropdown)
## ----------------------------------------------------
$sql_ministros = "SELECT username, nombre FROM sco_user WHERE cargo = 'MINISTRO' ORDER BY nombre";
$ministros_rs = ExecuteRows($sql_ministros);

## ----------------------------------------------------
## 2. Lógica de ACTUALIZACIÓN (Asociar/Cambiar Ministro)
## ----------------------------------------------------
if (isset($_POST['action']) && $_POST['action'] === 'update_ministro') {
    $Norden = intval($_POST['Norden'] ?? 0);
    $ministro_username = adjustSql($_POST['ministro'] ?? '');
    $Nexpediente = intval($_POST['expediente'] ?? 0);
    
    // Recuperar el criterio de búsqueda para persistencia
    $search_expediente = $_POST['hidden_search_expediente'] ?? '';
    $search_cedula = $_POST['hidden_search_cedula'] ?? '';
    $search_nombre = $_POST['hidden_search_nombre'] ?? '';

    if ($Norden > 0) {
        $ministro_update = empty($ministro_username) ? 'NULL' : "'" . $ministro_username . "'";
        $nota = '';
        $ministro_nombre = '';
        
        // === CAMBIO CRÍTICO: OBTENER EL NOMBRE DEL MINISTRO ===
        if (!empty($ministro_username) && $ministro_username !== "''") {
            // Quitamos las comillas que adjustSql() pudo haber añadido para la consulta
            $ministro_query_safe = trim($ministro_username, "'"); 
            
            $sql_ministro_name = "SELECT nombre FROM sco_user WHERE username = '$ministro_query_safe'";
            $ministro_nombre = ExecuteScalar($sql_ministro_name);
            // Si no se encuentra, usamos el username como respaldo
            $ministro_nombre = ($ministro_nombre !== false) ? $ministro_nombre : $ministro_query_safe;
        }

        // 1. Actualizar sco_orden
        $sql_update_ministro = "UPDATE sco_orden SET ministro = $ministro_update WHERE Norden = $Norden";
        
        if (Execute($sql_update_ministro)) {
            $message = '<div class="alert alert-success" role="alert">✅ Ministro actualizado con éxito para la Orden N° ' . $Norden . '.</div>';

            // 2. Generar y guardar bitácora (sco_nota)
            if (empty($ministro_username)) {
                $nota = "PADRE NO REALIZO OFICIO RELIGIOSO";
            } else {
                $nota = "PADRE ($ministro_nombre) REALIZO OFICIO RELIGIOSO";
            }
            
            // Sanitizar la nota y obtener el nombre de usuario
            $nota_sanitizada = adjustSql($nota);
            $usuario = adjustSql(CurrentUserName());

            $sql_insert_nota = "
                INSERT INTO sco_nota (Nnota, expediente, nota, usuario, fecha)
                VALUES (NULL, $Nexpediente, '$nota_sanitizada', '$usuario', '" . date('Y-m-d H:i:s') . "')
            ";
            
            Execute($sql_insert_nota);
        } else {
            $message = '<div class="alert alert-danger" role="alert">❌ Error al actualizar el ministro para la Orden N° ' . $Norden . '.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning" role="alert">⚠️ No se pudo procesar la actualización. Norden inválido.</div>';
    }
}

## ----------------------------------------------------
## 3. Lógica de BÚSQUEDA (Listado de Expedientes)
## ----------------------------------------------------
$where = "a.paso = 5 AND a.servicio_tipo = 'RELI'"; // Condiciones base (paso 5, servicio religioso)

// Construir la condición de búsqueda compleja
$search_conditions = [];
$has_search_criteria = false;

// 1. Expediente
if (!empty($search_expediente)) {
    $search_expediente_safe = adjustSql($search_expediente);
    $search_conditions[] = "b.Nexpediente = " . intval($search_expediente_safe);
    $has_search_criteria = true;
}

// 2. Cédula
if (!empty($search_cedula)) {
    $search_cedula_safe = adjustSql($search_cedula);
    $search_conditions[] = "b.cedula_fallecido LIKE '%$search_cedula_safe'";
    $has_search_criteria = true;
}

// 3. Nombre y Apellido
if (!empty($search_nombre)) {
    $nombre_parts = explode(' ', $search_nombre);
    $like_parts = [];
    foreach ($nombre_parts as $part) {
        if (!empty($part)) {
            $part_safe = adjustSql($part);
            $like_parts[] = "(b.nombre_fallecido LIKE '%$part_safe%' OR b.apellidos_fallecido LIKE '%$part_safe%')";
        }
    }
    if (!empty($like_parts)) {
        $search_conditions[] = "(" . implode(' AND ', $like_parts) . ")";
        $has_search_criteria = true;
    }
}

// Aplicar el filtro de búsqueda
if (!empty($search_conditions)) {
    $where .= " AND (" . implode(' OR ', $search_conditions) . ")";
} elseif (!$has_search_criteria && isset($_POST['search'])) {
    // Si se presionó Buscar sin criterios, no hacer nada especial, solo la condición base.
}

// Query de Listado
$sql_list = "
    SELECT 
        a.Norden, 
        b.Nexpediente AS expediente, 
        a.fecha_fin, 
        c.nombre AS nombre_servicio_exp, 
        CONCAT(b.nombre_fallecido, ' ', b.apellidos_fallecido) AS nombre_fallecido_completo, 
        b.cedula_fallecido, 
        d.nombre AS servicio_orden, 
        a.ministro AS ministro_username,
        (SELECT nombre FROM sco_user WHERE username = a.ministro) AS ministro_nombre
    FROM 
        sco_orden AS a 
        JOIN sco_expediente AS b ON b.Nexpediente = a.expediente AND a.paso = 5 AND a.servicio_tipo = 'RELI' 
        LEFT OUTER JOIN sco_servicio_tipo AS c ON c.Nservicio_tipo = b.servicio_tipo 
        LEFT OUTER JOIN sco_servicio_tipo AS d ON d.Nservicio_tipo = a.servicio_tipo 
    WHERE 
        $where
    ORDER BY a.fecha_fin DESC
";

if ($has_search_criteria) {
    $rs = ExecuteRows($sql_list);
}

$total_expedientes = count($rs);
?>

<style>
/* CSS para mejorar la legibilidad del texto en los badges 
   (Especialmente útil si el tema de Bootstrap 4 usa colores de fondo claros 
   para .badge-success o .badge-warning)
*/
.badge-success, 
.badge-warning {
    /* Fuerza el color del texto a negro para que contraste bien con fondos claros/amarillos */
    color: #000000 !important; 
}

/* Opcional: Oscurece el fondo del badge warning para mejor contraste */
.badge-warning {
    background-color: #ffc107; /* Amarillo estándar de Bootstrap 4 */
}
</style>

<div class="container-fluid">
    <h2>📋 Gestión de Ministros en Servicios Religiosos</h2>
    <hr>
    
    <!-- Mensajes de Alerta -->
    <?php echo $message; ?>

    <!-- Formulario de Búsqueda -->
    <div class="card card-default mb-4">
        <div class="card-header">
            <h3 class="card-title">Filtros de Búsqueda</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="">
                <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
                <input type="hidden" name="search" value="1">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="search_expediente">N° Expediente:</label>
                        <input type="text" class="form-control form-control-sm" id="search_expediente" name="search_expediente" value="<?php echo htmlspecialchars($search_expediente); ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="search_cedula">Cédula del Difunto:</label>
                        <input type="text" class="form-control form-control-sm" id="search_cedula" name="search_cedula" value="<?php echo htmlspecialchars($search_cedula); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="search_nombre">Nombre y Apellido del Difunto:</label>
                        <input type="text" class="form-control form-control-sm" id="search_nombre" name="search_nombre" value="<?php echo htmlspecialchars($search_nombre); ?>">
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">🔎 Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados de la Búsqueda -->
    <?php if ($total_expedientes > 0) { ?>
        <p class="text-muted small">Mostrando **<?php echo $total_expedientes; ?>** resultados de servicios religiosos listos para asignación.</p>

        <!-- 1. VISTA DE TABLA (Pantallas Medianas/Grandes) -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-striped table-bordered table-sm table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Expediente / Orden</th>
                        <th scope="col">Difunto (Cédula)</th>
                        <th scope="col">Servicio / Fecha Fin</th>
                        <th scope="col" style="width: 25%;">Ministro Actual</th>
                        <th scope="col" style="width: 30%;">Asignar Nuevo Ministro</th>
                        <th scope="col" style="width: 10%;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rs as $row) { ?>
                        <tr>
                            <td class="align-middle">
                                <small>Exp.:</small> **<?php echo htmlspecialchars($row['expediente']); ?>**<br>
                                <small>Orden:</small> <?php echo htmlspecialchars($row['Norden']); ?>
                            </td>
                            <td class="align-middle">
                                **<?php echo htmlspecialchars($row['nombre_fallecido_completo']); ?>**<br>
                                <small>CI: <?php echo htmlspecialchars($row['cedula_fallecido']); ?></small>
                            </td>
                            <td class="align-middle">
                                <?php echo htmlspecialchars($row['servicio_orden']); ?><br>
                                <small>Fin: <?php echo htmlspecialchars($row['fecha_fin']); ?></small>
                            </td>
                            <td class="align-middle">
                                <?php if (!empty($row['ministro_nombre'])): ?>
                                    <span class="badge badge-success"><?php echo htmlspecialchars($row['ministro_nombre']); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-warning">SIN ASIGNAR</span>
                                <?php endif; ?>
                            </td>
                            <!-- Formulario de Actualización por Fila -->
                            <td colspan="2" class="p-0">
                                <form method="POST" action="" class="d-flex h-100 align-items-center p-2">
                                    <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                                    <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
                                    <input type="hidden" name="action" value="update_ministro">
                                    <input type="hidden" name="Norden" value="<?php echo htmlspecialchars($row['Norden']); ?>">
                                    <input type="hidden" name="expediente" value="<?php echo htmlspecialchars($row['expediente']); ?>">
                                    <!-- Campos ocultos para persistir la búsqueda -->
                                    <input type="hidden" name="hidden_search_expediente" value="<?php echo htmlspecialchars($search_expediente); ?>">
                                    <input type="hidden" name="hidden_search_cedula" value="<?php echo htmlspecialchars($search_cedula); ?>">
                                    <input type="hidden" name="hidden_search_nombre" value="<?php echo htmlspecialchars($search_nombre); ?>">
                                    
                                    <select name="ministro" class="form-control form-control-sm mr-2" required>
                                        <option value="">-- Seleccionar Ministro --</option>
                                        <option value="">-- NO ASIGNAR --</option>
                                        <?php 
                                        $current_user = htmlspecialchars($row['ministro_username'] ?? '');
                                        foreach ($ministros_rs as $m_row) { 
                                            $selected = ($m_row['username'] === $current_user) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo htmlspecialchars($m_row['username']); ?>" <?php echo $selected; ?>>
                                                <?php echo htmlspecialchars($m_row['nombre'] ?? ''); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <button type="submit" class="btn btn-info btn-sm">Guardar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- 2. VISTA DE TARJETAS (Pantallas Pequeñas/Móviles) -->
        <div class="d-md-none">
            <?php foreach ($rs as $row) { ?>
                <div class="card mb-3 card-expediente">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">Expediente N°: <?php echo htmlspecialchars($row['expediente']); ?> (Orden: <?php echo htmlspecialchars($row['Norden']); ?>)</h6>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-1"><strong>Difunto:</strong> <?php echo htmlspecialchars($row['nombre_fallecido_completo']); ?></p>
                        <p class="card-text mb-1"><small>CI: <?php echo htmlspecialchars($row['cedula_fallecido']); ?></small></p>
                        <p class="card-text mb-3">
                            <strong>Servicio:</strong> <?php echo htmlspecialchars($row['servicio_orden']); ?><br>
                            <small>Finaliza: <?php echo htmlspecialchars($row['fecha_fin']); ?></small>
                        </p>
                        
                        <p class="mb-2">
                            <strong>Ministro Actual:</strong> 
                            <?php if (!empty($row['ministro_nombre'])): ?>
                                <span class="badge badge-success"><?php echo htmlspecialchars($row['ministro_nombre']); ?></span>
                            <?php else: ?>
                                <span class="badge badge-warning">SIN ASIGNAR</span>
                            <?php endif; ?>
                        </p>

                        <!-- Formulario de Actualización por Fila Móvil -->
                        <form method="POST" action="">
                            <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                            <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
                            <input type="hidden" name="action" value="update_ministro">
                            <input type="hidden" name="Norden" value="<?php echo htmlspecialchars($row['Norden']); ?>">
                            <input type="hidden" name="expediente" value="<?php echo htmlspecialchars($row['expediente']); ?>">
                            <!-- Campos ocultos para persistir la búsqueda -->
                            <input type="hidden" name="hidden_search_expediente" value="<?php echo htmlspecialchars($search_expediente); ?>">
                            <input type="hidden" name="hidden_search_cedula" value="<?php echo htmlspecialchars($search_cedula); ?>">
                            <input type="hidden" name="hidden_search_nombre" value="<?php echo htmlspecialchars($search_nombre); ?>">

                            <div class="form-group mb-2">
                                <label for="ministro_<?php echo $row['Norden']; ?>" class="small">Asignar/Cambiar Ministro:</label>
                                <select name="ministro" id="ministro_<?php echo $row['Norden']; ?>" class="form-control form-control-sm" required>
                                    <option value="">-- Seleccionar Ministro --</option>
                                    <option value="">-- NO ASIGNAR --</option>
                                    <?php 
                                    $current_user = htmlspecialchars($row['ministro_username']);
                                    foreach ($ministros_rs as $m_row) { 
                                        $selected = ($m_row['username'] === $current_user) ? 'selected' : '';
                                    ?>
                                        <option value="<?php echo htmlspecialchars($m_row['username']); ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($m_row['nombre']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info btn-block btn-sm mt-3">Guardar Ministro</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } elseif ($has_search_criteria) { ?>
        <div class="alert alert-info mt-4" role="alert">
            ℹ️ No se encontraron expedientes con los criterios de búsqueda o no cumplen con la condición de ser servicios religiosos en el paso 5.
        </div>
    <?php } else { ?>
        <div class="alert alert-info mt-4" role="alert">
            Por favor, ingrese un número de expediente, cédula o nombre/apellido para iniciar la búsqueda.
        </div>
    <?php } ?>
</div>

<?= GetDebugMessage() ?>
