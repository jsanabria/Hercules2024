<?php 
include 'includes/conexBD.php'; // Usa el objeto $link y trae las funciones de auditoría

$reclamo = $_GET["reclamo"] ?? '';
$username = $_GET["username"] ?? 'sistema';

// --- LOGICA DE PROCESAMIENTO (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. CARGA DE NUEVO ADJUNTO
    if (isset($_POST["GrabaNota"]) && !empty($_FILES["imagen"]["name"])) {
        $target_dir = "../carpetacarga/";
        $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $target_filename = date("YisHms") . "_" . uniqid() . "." . $extension;
        $target_file = $target_dir . $target_filename;
        
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (in_array($extension, $allowed) && $_FILES["imagen"]["size"] < 2000000) {
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                $stmt = $link->prepare("INSERT INTO sco_reclamo_adjunto (reclamo, nota, archivo, usuario, fecha) VALUES (?, ?, ?, ?, NOW())");
                $nota = $_POST["nota"] ?? '';
                $stmt->bind_param("ssss", $reclamo, $nota, $target_filename, $username);
                
                if ($stmt->execute()) {
                    audittrail_try($link, [
                        'action'   => 'UPLOAD_ADJUNTO',
                        'table'    => 'sco_reclamo_adjunto',
                        'keyvalue' => $reclamo,
                        'newvalue' => "Archivo: $target_filename | Nota: $nota"
                    ]);
                }
                $stmt->close();
            }
        }
    }

    // 2. ENVÍO DE CORREO CON ADJUNTOS
    if (isset($_POST["EnviarMailSol"]) || isset($_POST["EnviarMailAre"])) {
        $emaila = isset($_POST["EnviarMailSol"]) ? "sol" : "are";
        $nota_cliente = $_POST["nota_cliente"] ?? '';
        $img_seleccionadas = $_POST["EnviarImagen"] ?? [];

        $sql = "SELECT rec.*, par.valor2 as emailare, par.valor3 as emailare2 
                FROM sco_reclamo rec 
                JOIN sco_parametro par ON par.valor1 = rec.tipo 
                WHERE par.codigo = '014' AND rec.Nreclamo = ?";
        
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $reclamo);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($data) {
            $destinatario = ($emaila == "sol") ? $data["email"] : $data["emailare"];
            include_once 'funciones_mail_hercules.php'; 

            $attachments = [];
            if (!empty($img_seleccionadas)) {
                $ids = implode(',', array_map('intval', $img_seleccionadas));
                $res = $link->query("SELECT archivo FROM sco_reclamo_adjunto WHERE Nreclamo_adjunto IN ($ids)");
                while ($row = $res->fetch_assoc()) {
                    $ruta_fisica = realpath(__DIR__ . "/../carpetacarga/" . $row["archivo"]);
                    if ($ruta_fisica && file_exists($ruta_fisica)) {
                        $attachments[] = $ruta_fisica;
                    }
                }
            }

            $exito = EnviarCorreo([
                'to' => $destinatario,
                'cc' => ($emaila != "sol") ? $data["emailare2"] : "",
                'subject' => "Ticket Reclamo #$reclamo - Información Adjunta",
                'body' => "Se ha enviado información del reclamo.<br><br><b>Mensaje:</b> $nota_cliente",
                'attachments' => $attachments
            ]);

            if ($exito) {
                audittrail_try($link, [
                    'action'   => 'ENVIO_MAIL_ADJUNTOS',
                    'table'    => 'sco_reclamo',
                    'keyvalue' => $reclamo,
                    'newvalue' => "Destino: $emaila ($destinatario) | Adjuntos: " . count($img_seleccionadas)
                ]);
                echo "<script>alert('Correo enviado con éxito a: $destinatario');</script>";
            }
        }
    }
}

// Búsqueda de información para los botones
$sqlInfo = "SELECT rec.email, par.valor2 as emailare FROM sco_reclamo rec 
            JOIN sco_parametro par ON par.valor1 = rec.tipo 
            WHERE par.codigo = '014' AND rec.Nreclamo = ?";
$stmtInfo = $link->prepare($sqlInfo);
$stmtInfo->bind_param("s", $reclamo);
$stmtInfo->execute();
$resInfo = $stmtInfo->get_result()->fetch_assoc();

$mailSol = $resInfo['email'] ?? 'No definido';
$mailAre = $resInfo['emailare'] ?? 'No definido';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-size: 0.82rem; padding: 10px; }
        .img-preview { width: 60px; height: 45px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
        .sticky-form { position: sticky; top: 0; background: #f4f6f9; z-index: 10; padding-bottom: 10px; }
        .btn-envio { font-weight: bold; padding: 10px 5px; line-height: 1.2; }
        .mail-label { display: block; font-size: 0.65rem; font-weight: normal; opacity: 0.8; margin-top: 3px; }
        .card-custom { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border-radius: 8px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <form id="formReclamos" method="post" enctype="multipart/form-data">
        
        <div class="sticky-form">
            <div class="row no-gutters shadow-sm bg-white p-2 rounded border">
                <div class="col-md-4"><input type="file" name="imagen" class="form-control-file"></div>
                <div class="col-md-7"><input type="text" name="nota" class="form-control form-control-sm" placeholder="Descripción del adjunto..."></div>
                <div class="col-md-1 pl-1">
                    <button type="submit" name="GrabaNota" class="btn btn-info btn-sm btn-block"><i class="fas fa-upload"></i></button>
                </div>
            </div>
        </div>

        <div class="table-responsive bg-white card-custom border mt-2">
            <table class="table table-sm table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th width="40" class="text-center"><input type="checkbox" id="selectAll"></th>
                        <th width="80">Vista</th>
                        <th>Descripción / Usuario</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $link->prepare("SELECT * FROM sco_reclamo_adjunto WHERE reclamo = ? ORDER BY Nreclamo_adjunto DESC");
                    $stmt->bind_param("s", $reclamo);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()): 
                        $isPdf = strtolower(pathinfo($row["archivo"], PATHINFO_EXTENSION)) == 'pdf';
                    ?>
                    <tr>
                        <td class="align-middle text-center">
                            <input type="checkbox" name="EnviarImagen[]" class="item-checkbox" value="<?= $row["Nreclamo_adjunto"] ?>">
                        </td>
                        <td>
                            <a href="../carpetacarga/<?= $row["archivo"] ?>" target="_blank">
                                <?php if($isPdf): ?>
                                    <div class="img-preview d-flex align-items-center justify-content-center bg-light text-danger"><i class="fas fa-file-pdf"></i></div>
                                <?php else: ?>
                                    <img src="../carpetacarga/<?= $row["archivo"] ?>" class="img-preview">
                                <?php endif; ?>
                            </a>
                        </td>
                        <td class="align-middle">
                            <b><?= htmlspecialchars($row["nota"]) ?></b><br>
                            <small class="text-muted"><i class="fas fa-user-circle"></i> <?= htmlspecialchars($row["usuario"]) ?></small>
                        </td>
                        <td class="align-middle text-muted small"><?= date("d/m/y h:i A", strtotime($row["fecha"])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3 p-3 bg-white border rounded shadow-sm card-custom">
            <h6 class="text-primary small font-weight-bold mb-3"><i class="fas fa-paper-plane mr-2"></i>Notificar Reclamo por Correo:</h6>
            <textarea id="notaCliente" class="form-control form-control-sm mb-3" name="nota_cliente" rows="2" placeholder="Escriba el mensaje para el correo..."></textarea>
            
            <div class="row">
                <div class="col-6">
                    <button type="submit" id="btnSol" name="EnviarMailSol" class="btn btn-warning btn-block btn-envio btn-validate shadow-sm" disabled onclick="procesarEnvio(this, 'EnviarMailSol')">
                        <span class="btn-content"><i class="fas fa-user-tag"></i> ENVIAR AL SOLICITANTE</span>
                        <span class="mail-label"><?= $mailSol ?></span>
                    </button>
                </div>
                <div class="col-6">
                    <button type="submit" id="btnAre" name="EnviarMailAre" class="btn btn-success btn-block btn-envio btn-validate shadow-sm" disabled onclick="procesarEnvio(this, 'EnviarMailAre')">
                        <span class="btn-content"><i class="fas fa-building"></i> ENVIAR AL ÁREA</span>
                        <span class="mail-label"><?= $mailAre ?></span>
                    </button>
                </div>
            </div>
            <p id="msgValidation" class="text-danger small mt-2 mb-0"><i class="fas fa-info-circle mr-1"></i> Seleccione adjuntos y escriba un mensaje para habilitar el envío.</p>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const selectAll = document.getElementById('selectAll');
        const notaCliente = document.getElementById('notaCliente');
        const buttons = document.querySelectorAll('.btn-validate');
        const msg = document.getElementById('msgValidation');

        function validate() {
            const hasCheck = Array.from(checkboxes).some(c => c.checked);
            const hasText = notaCliente.value.trim().length > 3;
            const ok = hasCheck && hasText;

            buttons.forEach(b => b.disabled = !ok);
            msg.style.display = ok ? 'none' : 'block';
        }

        checkboxes.forEach(c => c.addEventListener('click', validate));
        notaCliente.addEventListener('input', validate);

        if(selectAll) {
            selectAll.addEventListener('click', function() {
                checkboxes.forEach(c => c.checked = this.checked);
                validate();
            });
        }
    });

    function procesarEnvio(btn, name) {
        // Bloquear ambos botones para evitar doble envío
        document.getElementById('btnSol').disabled = true;
        document.getElementById('btnAre').disabled = true;
        
        // Efecto visual de carga
        const content = btn.querySelector('.btn-content');
        const label = btn.querySelector('.mail-label');
        content.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';
        if(label) label.style.display = 'none';

        // Inyectar el nombre del botón para que el POST lo reconozca
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = name;
        hidden.value = '1';
        btn.form.appendChild(hidden);

        btn.form.submit();
    }
</script>

</body>
</html>