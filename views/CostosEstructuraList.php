<?php

namespace PHPMaker2024\hercules;

// Page object
$CostosEstructuraList = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// 1. Lógica de Negocio: Obtener datos en una sola consulta
$sql = "SELECT id, fecha, cerrado FROM sco_costos GROUP BY id, fecha, cerrado ORDER BY id DESC";
$datos = ExecuteRows($sql); // Obtenemos todo el historial de una vez
$sw_abierto = false; // Interruptor para detectar si hay alguna estructura abierta
?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-7 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history me-2"></i>Historial de Estructuras</h5>
                    <span class="badge bg-light text-primary"><?php echo count($datos); ?> Registros</span>
                </div>
                <div class="list-group list-group-flush" style="max-height: 400px; overflow-y: auto;">
                    <?php if (count($datos) > 0): ?>
                        <?php foreach ($datos as $row): 
                            $es_cerrado = ($row["cerrado"] == "S");
                            if (!$es_cerrado) $sw_abierto = true; // Si encontramos una abierta, activamos el switch
                            
                            $status_class = $es_cerrado ? "bg-secondary" : "bg-success";
                            $status_text  = $es_cerrado ? "Cerrado" : "Abierto";
                        ?>
                            <a href="buscar_costos.php?id=<?php echo $row["id"]; ?>&fecha=<?php echo $row["fecha"]; ?>" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <i class="fas fa-calendar-alt text-muted me-2"></i>
                                    <span class="fw-bold"><?php echo $row["fecha"]; ?></span>
                                    <span class="text-muted ms-2 small">ID: <?php echo str_pad($row["id"], 8, "0", STR_PAD_LEFT); ?></span>
                                </div>
                                <span class="badge rounded-pill <?php echo $status_class; ?>">
                                    <?php echo $status_text; ?>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted">No hay estructuras registradas.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-5 col-lg-4 mt-4 mt-md-0">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted fw-bold mb-4">Acciones Disponibles</h6>
                    
                    <div class="d-grid gap-3">
                        <button type="button" id="btn-add" 
                                class="btn btn-primary btn-lg shadow-sm <?php echo $sw_abierto ? 'disabled' : ''; ?>"
                                <?php echo $sw_abierto ? 'disabled' : ''; ?>>
                            <i class="fas fa-plus-circle me-2"></i>Nueva Estructura
                        </button>

                        <button type="button" id="btn-remove" 
                                class="btn btn-outline-danger btn-lg <?php echo !$sw_abierto ? 'disabled' : ''; ?>"
                                <?php echo !$sw_abierto ? 'disabled' : ''; ?>>
                            <i class="fas fa-trash-alt me-2"></i>Eliminar Abierta
                        </button>
                    </div>

                    <?php if ($sw_abierto): ?>
                        <div class="alert alert-info mt-4 mb-0 py-2 small">
                            <i class="fas fa-info-circle me-1"></i> Debe cerrar la estructura abierta antes de crear una nueva.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Usamos SweetAlert2 (disponible en PHPMaker 2024) para una mejor UX
$("#btn-add").click(function() {
    Swal.fire({
        title: '¿Nueva Estructura?',
        text: "Se generará una nueva base de costos.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd',
        confirmButtonText: 'Sí, crear',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "costos_estructura_add.php";
        }
    });
});

$("#btn-remove").click(function() {
    Swal.fire({
        title: '¿Eliminar Estructura?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "costos_estructura_remove.php";
        }
    });
});
</script>
<?= GetDebugMessage() ?>
