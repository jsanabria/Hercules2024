<?php
// Include your database connection file. Ensure $link is a mysqli connection object.
include 'includes/conexBD.php';

// Sanitize and retrieve request variables
$swmt = htmlspecialchars($_REQUEST["swmt"], ENT_QUOTES, 'UTF-8');
$fecha_inicio = htmlspecialchars($_REQUEST["fecha_inicio"], ENT_QUOTES, 'UTF-8');
$exp = htmlspecialchars($_REQUEST["exp"], ENT_QUOTES, 'UTF-8'); // Expediente ID
$sta = htmlspecialchars($_REQUEST["sta"], ENT_QUOTES, 'UTF-8'); // Estatus
$username = htmlspecialchars($_REQUEST["username"], ENT_QUOTES, 'UTF-8');

// Format the date for database insertion
$ff = explode("/", $fecha_inicio);
// Validate date parts to prevent errors if explode doesn't return 3 elements
if (count($ff) === 3) {
    $fecha = $ff[2] . "-" . $ff[1] . "-" . $ff[0];
} else {
    // Handle invalid date format, perhaps log an error or set a default
    error_log("Invalid date format received for fecha_inicio: " . $fecha_inicio);
    // You might want to redirect with an error message or use a default date
    $fecha = date("Y-m-d"); // Fallback to current date
}

// Prepare the SQL INSERT statement using a prepared statement
// This prevents SQL injection by separating the query structure from the data
$sql = "INSERT INTO sco_nota (Nnota, expediente, nota, usuario, fecha) VALUES (NULL, ?, ?, ?, NOW())";

// Check if the statement can be prepared
if ($stmt = $link->prepare($sql)) {
    // Bind parameters to the prepared statement
    // 'sss' indicates that all three parameters are strings
    $stmt->bind_param("sss", $exp, $sta, $username);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect after successful insertion
        header("Location: PizarraCremaciones.php?swmt=$swmt&fecha_inicio=$fecha_inicio&username=$username");
        exit(); // Always exit after a header redirect
    } else {
        // Handle execution error
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        // You might want to redirect to an error page or show a user-friendly message
        die("Error al guardar la nota. Por favor, intente de nuevo más tarde.");
    }

    // Close the statement
    $stmt->close();
} else {
    // Handle prepare error
    error_log("Error al preparar la consulta: " . $link->error);
    // You might want to redirect to an error page or show a user-friendly message
    die("Error interno del servidor. Por favor, contacte al soporte.");
}

// Close the database connection (assuming $link is your mysqli connection)
// This might be handled in conexBD.php or at the end of your script,
// but it's good practice to ensure it's closed.
$link->close();
?>