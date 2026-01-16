<?php

namespace PHPMaker2024\hercules;

// Page object
$ImportarParcelas = &$Page;
?>
<?php
$Page->showMessage();
?>
<div class="container mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-sync-alt mr-2"></i> Importar Parcelas desde AS400</h5>
        </div>
        <div class="card-body text-center p-5">
            
            <?php
            // Comprobar si es una petición POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                // Ejecución del script Shell
                $salida = shell_exec('sh /home/parcelassh.sh');
                
                echo '
                <div class="alert alert-success shadow-sm border-0" style="border-radius: 12px;">
                    <h4 class="alert-heading"><i class="fas fa-check-circle"></i> ¡Sincronización Exitosa!</h4>
                    <p>El proceso de importación ha finalizado correctamente.</p>
                    <hr>
                    <a href="ParcelasList" class="btn btn-success px-4 shadow-sm" style="border-radius: 50px;">
                        <i class="fas fa-arrow-left mr-2"></i>Regresar a Parcelas
                    </a>
                </div>';
            } else {
                ?>
                <div id="setup_interface">
                    <div class="mb-4 text-primary">
                        <i class="fas fa-database fa-3x"></i>
                    </div>
                    <p class="text-muted mb-4">Pulse el botón para iniciar la transferencia de datos desde el AS400.</p>
                    
                    <form method="POST" action="<?php echo CurrentPageUrl(false); ?>" id="formImportar">
                        <input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
                        <input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
                        
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow" style="border-radius: 50px; font-weight: bold;" onclick="mostrarCarga()">
                            <i class="fas fa-file-import mr-2"></i> Iniciar Importación
                        </button>
                    </form>
                </div>
                <?php
            }
            ?>

            <div id="loading_spinner" style="display:none;" class="py-4">
                <div class="spinner-border text-primary" role="status" style="width: 3.5rem; height: 3.5rem;"></div>
                <h5 class="mt-4 text-primary font-weight-bold">Conectando con AS400...</h5>
                <p class="text-muted">Procesando, por favor espere...</p>
            </div>

        </div>
    </div>
</div>

<script>
function mostrarCarga() {
    document.getElementById('setup_interface').style.display = 'none';
    document.getElementById('loading_spinner').style.display = 'block';
}
</script>
<?= GetDebugMessage() ?>
