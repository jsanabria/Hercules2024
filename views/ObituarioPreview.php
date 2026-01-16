<?php

namespace PHPMaker2024\hercules;

// Page object
$ObituarioPreview = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php

/**
 * Custom File: obituario_preview.php
 * Remanufacturado para PHPMaker 2024 (usando ExecuteRow).
 * Se eliminan las declaraciones 'global' a favor de pasar el array como argumento.
 */

// Obtener y sanitizar el parámetro Norden de la URL.
$Norden = Get("Norden") ?? 0; 
$Norden_escaped = AdjustSql($Norden);

// --- 1. CONSULTA DE DATOS CON ExecuteRow ---

// Asegúrate de usar comillas simples alrededor de la variable Norden si es tipo texto o si AdjustSql() no las añade.
$sql = "SELECT nota FROM sco_orden WHERE Norden = '{$Norden_escaped}'";

// ExecuteRow obtiene una sola fila.
$row = ExecuteRow($sql);

if (!$row) {
    echo '<div class="alert alert-danger text-center mt-3">Error: No se encontró la orden con el ID ' . htmlspecialchars($Norden) . '.</div>';
    return; // Salir del script
}

// Procesar el campo 'nota'
$nota_text = $row["nota"] ?? '';
$nota_text = stripslashes($nota_text);

// Dividir el contenido por "---"
$cont1 = explode("---", $nota_text);


// --- 2. FUNCIONES AUXILIARES (MODERNIZADAS) ---

/**
 * Función auxiliar para obtener y limpiar el valor de una sub-sección (ej. TITULO|Valor).
 * @param array $content_array Array principal de contenido ($cont1).
 * @param int $index Índice dentro del array $cont1.
 * @return string Valor limpio y sanitizado para HTML.
 */
function get_clean_value($content_array, $index) {
    if (isset($content_array[$index])) {
        $parts = explode("|", $content_array[$index]);
        // Devolvemos el segundo elemento, limpiando espacios y asegurando que sea seguro para HTML
        return isset($parts[1]) ? trim(htmlspecialchars($parts[1])) : '';
    }
    return '';
}

/**
 * Función auxiliar para obtener y limpiar la sección completa (ej. CAMPO|Valor -> CAMPO:Valor).
 * @param array $content_array Array principal de contenido ($cont1).
 * @param int $index Índice dentro del array $cont1.
 * @return string Sección formateada y sanitizada para HTML.
 */
function get_clean_section($content_array, $index) {
    if (isset($content_array[$index])) {
        // Reemplazamos el '|' por ':' y limpiamos de forma segura
        return htmlspecialchars(str_replace("|", ":", $content_array[$index]));
    }
    return '';
}

// --- 3. PRESENTACIÓN HTML (Estructura Bootstrap 5) ---
$path = 'phpimages/';
?>
<div class="ew-custom-template-1">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-sm mt-4 mb-4">
                <div class="card-body">
                    <form action="#" method="post">
                        
                        <div class="p-3 mb-4 border rounded text-center">
                            
                            <div class="form-group mb-4">
                                <?php 
                                    // Obtenemos los valores necesarios pasándoles $cont1 como primer argumento
                                    $simbolo = get_clean_value($cont1, 5); 
                                    $logo_compania_url = get_clean_value($cont1, 11);
                                ?>
                                
                                <?php if ($simbolo == "CRUZ") : ?>
                                    <img src="<?= $path ?>Cruz_Obituarios.jpg" width="100" class="img-responsive img-rounded" alt="Cruz Obituarios">
                                <?php elseif ($simbolo == "ESTRELLA DE DAVID") : ?>
                                    <img src="<?= $path ?>Estrella_de_David.jpg" width="100" class="img-responsive img-rounded" alt="Estrella de David">
                                <?php elseif ($simbolo == "LOGO COMPANIA" && !empty($logo_compania_url)) : ?>
                                    <img src="<?php echo $logo_compania_url; ?>" width="100" class="img-responsive img-rounded" alt="Logo Compañía">
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_value($cont1, 0); ?></strong></h4>
                            </div>

                            <div class="form-group mb-2">
                                <h3><?php echo get_clean_value($cont1, 1); ?></h3>
                            </div>

                            <div class="form-group mb-2">
                                <h2><strong><?php echo get_clean_value($cont1, 2); ?></strong></h2>
                            </div>

                            <div class="form-group mb-2">
                                <h4><?php echo get_clean_value($cont1, 3); ?></h4>
                            </div>

                            <div class="form-group mb-4">
                                <h3><strong><?php echo get_clean_value($cont1, 4); ?></strong></h3>
                            </div>

                            <div class="form-group mb-0">
                                <img src="<?= $path ?>logo.jpg" width="70" class="img-responsive img-rounded" alt="Logo Cementerio">
                            </div>
                        </div>
                        
                        <div class="p-3 mb-4 border rounded text-center bg-light">
                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_section($cont1, 6); ?></strong></h4>
                            </div>
                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_section($cont1, 7); ?></strong></h4>
                            </div>
                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_section($cont1, 8); ?></strong></h4>
                            </div>
                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_section($cont1, 9); ?></strong></h4>
                            </div>
                            <div class="form-group mb-2">
                                <h4><strong><?php echo get_clean_section($cont1, 10); ?></strong></h4>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <a class="btn btn-danger" onclick="window.close();">
                                Cerrar <i class="fas fa-times-circle"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
// El Custom File finaliza aquí.
?>
<?= GetDebugMessage() ?>
