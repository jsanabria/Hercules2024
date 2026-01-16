<?php

namespace PHPMaker2024\hercules;

// Page object
$TasaCambioGuardar = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// Recibir el valor y convertirlo a float
$nueva_tasa = floatval($_POST["tasa"] ?? 0);

if ($nueva_tasa > 0) {
    // Escapar el valor o usarlo directamente como número en el UPDATE
    $sql = "UPDATE sco_parametro SET valor1 = '$nueva_tasa' WHERE codigo = '050'";
    
    if (Execute($sql)) {
        // Redireccionar con éxito
        header("Location: TasaCambio?msg=success");
    } else {
        echo "Error al actualizar la tasa.";
    }
} else {
    echo "Valor de tasa no válido.";
}
?>
<?= GetDebugMessage() ?>
