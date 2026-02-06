<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "hercules";

/*
$servername = "localhost:3306";
$username = "cemenlsk_hercules";
$password = "S![%IeeBY.nW";
$dbname = "cemenlsk_hercules";
*/

$link = new mysqli($servername, $username, $password, $dbname);

// --- Verificar la Conexión ---
if ($link->connect_error) {
    // Si hay un error de conexión, muestra el error y termina el script
    die("<div class='alert alert-danger' role='alert'>Error de conexión a la base de datos: " . $link->connect_error . "</div>");
}

$sql = "SET NAMES utf8 ";
if ($stmt = $link->prepare($sql)) { 
	$stmt->execute();
} 
else {
    // Si hay un error en la preparación de la consulta
    die("<div class='alert alert-danger' role='alert'>Error al preparar la consulta: " . $link->error . "</div>");
}

ini_set('date.timezone', 'America/Caracas'); 

/* =========================================================================
 *  UTILIDADES DE BITÁCORA (tabla existente: audittrail)
 *  Columnas: id, datetime, script, user, action, table, field, keyvalue, oldvalue, newvalue
 *  -------------------------------------------------------------------------
 *  USO RÁPIDO:
 *    audittrail_try($link, [
 *      'action'    => 'RESERVAR',
 *      'table'     => 'sco_orden',
 *      'keyvalue'  => $Norden,                               // PK
 *      'newvalue'  => ['expediente'=>$exp, 'capilla'=>$cap], // datos nuevos (array o string)
 *    ]);
 * ========================================================================= */

/** Obtiene el nombre de usuario (mejor esfuerzo) */
function at_user(): string {
    // 1. Primero intentamos ver si viene en la petición POST (lo que enviamos desde el JS)
    if (!empty($_POST['usuario']))       return (string)$_POST['usuario'];
    
    // 2. Si no, buscamos en la sesión
    if (!empty($_SESSION['username']))   return (string)$_SESSION['username'];
    if (!empty($_SESSION['user']))       return (string)$_SESSION['user'];
    
    // 3. Otros métodos
    if (!empty($_SERVER['REMOTE_USER'])) return (string)$_SERVER['REMOTE_USER'];
    
    return 'sistema';
}

/** Obtiene el nombre del script actual (ej: /capillas/api/reservar.php) */
function at_script(): string {
    return isset($_SERVER['SCRIPT_NAME']) ? (string)$_SERVER['SCRIPT_NAME'] : 'cli';
}

/** Normaliza cualquier valor a string: si es array/obj => JSON, si no => (string) */
function at_to_string($v): ?string {
    if ($v === null) return null;
    if (is_array($v) || is_object($v)) {
        return json_encode($v, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    // Acepta números, bools, strings
    return (string)$v;
}

/**
 * Inserta un registro en la tabla `audittrail`.
 * Campos esperados en $data:
 *  - action   (string)    p.ej. 'RESERVAR', 'BLOQUEAR', 'DESBLOQUEAR', 'ANULAR_RESERVA', 'BORRAR_RESERVA', 'ACTUALIZAR', 'OTRO', ...
 *  - table    (string)    nombre lógico de la tabla afectada (ej: 'sco_orden', 'sco_reserva')
 *  - field    (string|null)  si aplica, un campo puntual modificado (puedes dejar null)
 *  - keyvalue (scalar|array|null)   PK o identificador; si es array se guarda como JSON
 *  - oldvalue (scalar|array|null)   estado previo (JSON si es array)
 *  - newvalue (scalar|array|null)   estado nuevo (JSON si es array)
 *  - user     (string|null)         si no se pasa, se autocompleta con at_user()
 *  - script   (string|null)         si no se pasa, se autocompleta con at_script()
 */
function audittrail_log(mysqli $link, array $data): bool
{
    $script   = isset($data['script']) ? (string)$data['script'] : at_script();
    $user     = isset($data['user'])   ? (string)$data['user']   : at_user();
    $action   = isset($data['action']) ? (string)$data['action'] : 'OTRO';
    $table    = isset($data['table'])  ? (string)$data['table']  : 'OTRO';
    $field    = isset($data['field'])  ? (string)$data['field']  : null;

    $keyvalue = at_to_string($data['keyvalue'] ?? null);
    $oldvalue = at_to_string($data['oldvalue'] ?? null);
    $newvalue = at_to_string($data['newvalue'] ?? null);

    // Nota: `table` es palabra reservada, por eso la escapamos con backticks.
    $sql = "INSERT INTO audittrail
              (`datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`)
            VALUES
              (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

    if (!$stmt = $link->prepare($sql)) {
        error_log("audittrail_log prepare error: ".$link->error);
        return false;
    }

    // Tipos: 8 parámetros (todo strings, pueden ser null) => "ssssssss"
    $stmt->bind_param(
        "ssssssss",
        $script,
        $user,
        $action,
        $table,
        $field,
        $keyvalue,
        $oldvalue,
        $newvalue
    );

    $ok = $stmt->execute();
    if (!$ok) {
        error_log("audittrail_log exec error: ".$stmt->error);
    }
    $stmt->close();
    return (bool)$ok;
}

/** Envoltorio que no rompe el flujo si algo falla (devuelve true/false) */
function audittrail_try(mysqli $link, array $data): bool {
    try {
        return audittrail_log($link, $data);
    } catch (Throwable $e) {
        error_log("audittrail_try exception: ".$e->getMessage());
        return false;
    }
}

/**
 * Helper para registrar cambios de UPDATE:
 *  - $before y $after son arrays asociativos del mismo registro (antes/después).
 *  - Registra un renglón por cada campo que cambia (field, oldvalue, newvalue).
 *    Si prefieres un solo renglón, usa audittrail_try con old/new globales.
 */
function audittrail_log_diff(mysqli $link, string $table, $keyvalue, array $before, array $after, ?string $action='ACTUALIZAR'): int {
    $count = 0;
    $allKeys = array_unique(array_merge(array_keys($before), array_keys($after)));
    foreach ($allKeys as $k) {
        $ov = $before[$k] ?? null;
        $nv = $after[$k]  ?? null;
        // compara estrictamente; si quieres comparar “por texto” castea a string
        if ($ov !== $nv) {
            if (audittrail_try($link, [
                'action'   => $action ?? 'ACTUALIZAR',
                'table'    => $table,
                'field'    => $k,
                'keyvalue' => $keyvalue,
                'oldvalue' => $ov,
                'newvalue' => $nv,
            ])) {
                $count++;
            }
        }
    }
    return $count;
}

?>
