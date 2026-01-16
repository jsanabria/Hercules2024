<?php 
// 1. Incluir conexión existente (usa el objeto $link)
include 'includes/conexBD.php'; 

// 2. Captura segura de parámetros GET
$reclamo = $_GET["reclamo"] ?? '';
$username = $_GET["username"] ?? 'sistema';

// 3. Procesar inserción de nueva nota (Auto-procesado)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty(trim($_POST['nota']))) {
    $nuevaNota = $_POST['nota'];
    
    // Usamos sentencias preparadas (como en tu conexBD.php) para evitar Inyección SQL
    $sqlInsert = "INSERT INTO sco_reclamo_nota (reclamo, usuario, nota, fecha) VALUES (?, ?, ?, NOW())";
    
    if ($stmt = $link->prepare($sqlInsert)) {
        $stmt->bind_param("sss", $reclamo, $username, $nuevaNota);
        $stmt->execute();
        $stmt->close();
        
        // Registrar en la Bitácora (opcional, usando tu función audittrail_try)
        audittrail_try($link, [
            'action' => 'AGREGAR_NOTA',
            'table' => 'sco_reclamo_nota',
            'keyvalue' => $reclamo,
            'newvalue' => $nuevaNota
        ]);

        // Redirigir para limpiar el formulario y evitar reenvíos al refrescar
        header("Location: " . $_SERVER['PHP_SELF'] . "?reclamo=$reclamo&username=$username");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas de Reclamo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-size: 0.85rem; padding: 10px; }
        .card-notes { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: none; }
        .note-user { font-weight: bold; color: #495057; }
        .note-date { font-size: 0.75rem; color: #adb5bd; }
        .sticky-top-form { position: sticky; top: 0; background: #f4f6f9; z-index: 100; padding-bottom: 15px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="sticky-top-form">
        <form method="post" action="">
            <div class="input-group shadow-sm">
                <textarea class="form-control" name="nota" rows="2" placeholder="Escriba una nota..." required></textarea>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-notes">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 20%">Usuario</th>
                        <th style="width: 20%">Fecha</th>
                        <th>Detalle de la Nota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta usando el objeto $link de conexBD.php
                    $sql = "SELECT usuario, nota, DATE_FORMAT(fecha, '%d/%m/%Y %h:%i%p') as fecha_f 
                            FROM sco_reclamo_nota 
                            WHERE reclamo = ? 
                            ORDER BY Nreclamo_nota DESC";
                    
                    if ($stmt = $link->prepare($sql)) {
                        $stmt->bind_param("s", $reclamo);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='note-user text-nowrap'><i class='fas fa-user-circle mr-1'></i> " . htmlspecialchars($row["usuario"]) . "</td>";
                                echo "<td class='note-date text-nowrap'><i class='far fa-calendar-alt mr-1'></i> " . $row["fecha_f"] . "</td>";
                                echo "<td>" . nl2br(htmlspecialchars($row["nota"])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center text-muted'>No hay notas registradas para este reclamo.</td></tr>";
                        }
                        $stmt->close();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>