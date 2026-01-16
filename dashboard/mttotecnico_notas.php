<?php 
// 1. Incluir conexión existente (usa el objeto $link de conexBD.php)
include 'includes/conexBD.php'; 

// 2. Captura segura de parámetros GET (Cambiamos 'reclamo' por 'id')
$idMtt = $_GET["id"] ?? '';
$username = $_GET["username"] ?? 'sistema';

// 3. Procesar inserción de nueva nota técnica
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty(trim($_POST['nota']))) {
    $nuevaNota = $_POST['nota'];
    
    // SQL adaptado a la estructura de sco_mttotecnico_notas
    $sqlInsert = "INSERT INTO sco_mttotecnico_notas (mttotecnico, username, nota, fecha_hora) VALUES (?, ?, ?, NOW())";
    
    if ($stmt = $link->prepare($sqlInsert)) {
        $stmt->bind_param("iss", $idMtt, $username, $nuevaNota);
        $stmt->execute();
        $stmt->close();
        
        // Registrar en la Bitácora usando tu función audittrail_try
        audittrail_try($link, [
            'action' => 'AGREGAR_NOTA_MTTO',
            'table' => 'sco_mttotecnico_notas',
            'keyvalue' => $idMtt,
            'newvalue' => $nuevaNota
        ]);

        // Redirigir para limpiar el formulario
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=$idMtt&username=$username");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitácora de Mantenimiento</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-size: 0.85rem; padding: 10px; }
        .card-notes { box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border: none; border-radius: 8px; }
        .note-user { font-weight: bold; color: #0056b3; }
        .note-date { font-size: 0.75rem; color: #6c757d; }
        .sticky-top-form { position: sticky; top: 0; background: #f4f6f9; z-index: 100; padding-bottom: 15px; }
        .table thead th { border-top: none; background: #ebf2f9; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="sticky-top-form">
        <form method="post" action="">
            <div class="input-group shadow-sm">
                <textarea class="form-control" name="nota" rows="2" placeholder="Describa el avance técnico o novedad..." required></textarea>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-notes">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 20%">Técnico</th>
                        <th style="width: 20%">Fecha/Hora</th>
                        <th>Detalle Técnico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta adaptada a campos: username, nota, fecha_hora
                    $sql = "SELECT username, nota, DATE_FORMAT(fecha_hora, '%d/%m/%Y %h:%i %p') as fecha_f 
                            FROM sco_mttotecnico_notas 
                            WHERE mttotecnico = ? 
                            ORDER BY Nmttotecnico_notas DESC";
                    
                    if ($stmt = $link->prepare($sql)) {
                        $stmt->bind_param("i", $idMtt);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='note-user text-nowrap'><i class='fas fa-user-cog mr-1'></i> " . htmlspecialchars($row["username"]) . "</td>";
                                echo "<td class='note-date text-nowrap'><i class='far fa-clock mr-1'></i> " . $row["fecha_f"] . "</td>";
                                echo "<td>" . nl2br(htmlspecialchars($row["nota"])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center py-4 text-muted'>No hay registros en la bitácora para este mantenimiento.</td></tr>";
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