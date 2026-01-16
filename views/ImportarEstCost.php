<?php

namespace PHPMaker2024\hercules;

// Page object
$ImportarEstCost = &$Page;
?>
<?php
$Page->showMessage();
?>
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-import me-2"></i>Importar Estructuras de Costo
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(isset($_REQUEST["error"])): ?>
                        <?php if($_REQUEST["error"] == "NO"): ?>
                            <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-check-circle me-2 fs-4"></i>
                                <div><strong>¡Éxito!</strong> El proceso de carga de archivo fue finalizado correctamente.</div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-exclamation-triangle me-2 fs-4"></i>
                                <div>
                                    <strong>Error:</strong> No se pudo procesar el archivo. <br>
                                    <small class="text-dark"><?php echo htmlspecialchars($_REQUEST["error"]); ?></small>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="importar_est_cost_guardar.php" enctype="multipart/form-data" method="post">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary" for="myfile">
                                <i class="fas fa-file-alt me-1"></i> Seleccione Archivo .txt:
                            </label>
                            <div class="input-group">
                                <input type="file" class="form-control shadow-none" name="myfile" id="myfile" accept=".txt" required>
                                <label class="input-group-text bg-light" for="myfile">Explorar</label>
                            </div>
                            <div class="form-text mt-2">
                                <i class="fas fa-info-circle me-1"></i> Solo se permiten archivos de texto plano (.txt).
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-between align-items-center border-top pt-4">
                            <a class="btn btn-outline-info d-inline-flex align-items-center" 
                               href="../carpetacarga/Estructura de Datos EC.pdf" 
                               target="_blank">
                                <i class="fas fa-book-open me-2"></i> Ver Estructura Requerida
                            </a>
                            
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Enviar Archivo
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            
            <div class="text-center mt-3 text-muted">
                <small>Sistema Hércules - Módulo de Importación Técnica</small>
            </div>
        </div>
    </div>
</div>
<?= GetDebugMessage() ?>
