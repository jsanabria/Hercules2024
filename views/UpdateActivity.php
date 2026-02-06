<?php

namespace PHPMaker2024\hercules;

// Page object
$UpdateActivity = &$Page;
?>
<?php
$Page->showMessage();
?>
<?php
// 1. Esto le dice a PHPMaker: "No registres esta página en el historial de navegación"
$Page->terminate(false); 

if (IsLoggedIn()) {
    $username = CurrentUserName();
    $ip = $_SERVER['REMOTE_ADDR'];
    $file = $_SERVER['PHP_SELF'];
    $now = time(); 

    // Limpiamos y registramos actividad
    Execute("DELETE FROM sco_users_online WHERE username = '" . AdjustSql($username) . "'");
    $sqlInsert = "INSERT INTO sco_users_online (timestamp, ip, file, username, last_activity, unlogin) 
                  VALUES ($now, '$ip', '$file', '$username', NOW(), 'N')";
    Execute($sqlInsert);
    
    // 2. Limpiar el buffer para enviar SOLO el JSON
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(["status" => "success"]);
    
    // 3. En lugar de exit, usamos el terminador nativo de PHPMaker
    die(); 
} else {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(["status" => "not_logged_in"]);
    die();
}
?>
<?= GetDebugMessage() ?>
