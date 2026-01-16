<?php 
include 'includes/conexBD.php'; 

// 1. Captura de parámetros
$idMtt = $_GET["id"] ?? '';
$username = $_GET["username"] ?? 'sistema';

// --- LÓGICA DE PROCESAMIENTO (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. CARGA DE NUEVO ADJUNTO
    if (isset($_POST["GrabaNota"]) && !empty($_FILES["imagen"]["name"])) {
        $target_dir = "../carpetacarga/";
        $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
        $target_filename = "MTTO_" . date("Ymd_His") . "_" . uniqid() . "." . $extension;
        $target_file = $target_dir . $target_filename;
        
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
            $stmt = $link->prepare("INSERT INTO sco_mttotecnico_adjunto (mttotecnico, nota, archivo, usuario, fecha) VALUES (?, ?, ?, ?, NOW())");
            $nota = $_POST["nota"] ?? '';
            $stmt->bind_param("isss", $idMtt, $nota, $target_filename, $username);
            $stmt->execute();
            $stmt->close();
        }
    }

    // 2. ENVÍO DE CORREO
    if ((isset($_POST["EnviarMailSol"]) || isset($_POST["EnviarMailAre"])) && !empty($idMtt)) {
        $img_seleccionadas = $_POST["EnviarImagen"] ?? [];
        $nota_adicional = $_POST["nota_cliente"] ?? '';

        $sqlParam = "SELECT valor1, valor2, valor3 FROM sco_parametro WHERE codigo = '035'";
        $resParam = $link->query($sqlParam)->fetch_assoc();
        
        $destinatario = isset($_POST["EnviarMailSol"]) ? $resParam["valor1"] : $resParam["valor2"];
        $cc = $resParam["valor3"] ?? '';

        if (!empty($destinatario)) {
            include_once 'funciones_mail_hercules.php'; 
            $attachments = [];
            if (!empty($img_seleccionadas)) {
                $ids = implode(',', array_map('intval', $img_seleccionadas));
                $res = $link->query("SELECT archivo FROM sco_mttotecnico_adjunto WHERE Nmttotecnico_adjunto IN ($ids)");
                while ($row = $res->fetch_assoc()) {
                    $ruta = realpath(__DIR__ . "/../carpetacarga/" . $row["archivo"]);
                    if ($ruta && file_exists($ruta)) $attachments[] = $ruta;
                }
            }

            $exito = EnviarCorreo([
                'to' => $destinatario,
                'cc' => $cc,
                'subject' => "Información Técnica Actualizada - Ticket #$idMtt",
                'body' => "Se ha compartido información técnica.<br><br><b>Mensaje:</b><br>$nota_adicional",
                'attachments' => $attachments
            ]);

            if ($exito) echo "<script>alert('Información enviada con éxito a: $destinatario');</script>";
        }
    }
}

$sqlEmails = "SELECT valor1 as principal, valor2 as area FROM sco_parametro WHERE codigo = '035'";
$resEmails = $link->query($sqlEmails)->fetch_assoc();
$mailPrincipal = $resEmails['principal'] ?? 'no-configurado@mail.com';
$mailArea = $resEmails['area'] ?? 'no-configurado@mail.com';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-size: 0.82rem; padding: 10px; }
        .img-preview { width: 55px; height: 42px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6; }
        .sticky-form { position: sticky; top: 0; background: #f8f9fa; z-index: 10; padding-bottom: 12px; }
        .btn-envio { font-weight: bold; padding: 12px 5px; transition: all 0.2s; }
        .mail-label { display: block; font-size: 0.62rem; font-weight: normal; margin-top: 2px; }
        .card-custom { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); border-radius: 8px; }
    </style>
</head>
<body>

<div class="container-fluid">
    <form id="formAdjuntos" method="post" enctype="multipart/form-data">
        
        <div class="sticky-form">
            <div class="row no-gutters bg-white p-2 rounded border shadow-sm">
                <div class="col-md-5"><input type="file" name="imagen" class="form-control-file"></div>
                <div class="col-md-6"><input type="text" name="nota" class="form-control form-control-sm" placeholder="Nota del archivo..."></div>
                <div class="col-md-1 pl-1">
                    <button type="submit" name="GrabaNota" class="btn btn-info btn-sm btn-block"><i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>

        <div class="table-responsive bg-white card-custom border mb-3">
            <table class="table table-sm table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" width="40"><input type="checkbox" id="selectAll"></th>
                        <th width="70">Vista</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $link->prepare("SELECT * FROM sco_mttotecnico_adjunto WHERE mttotecnico = ? ORDER BY Nmttotecnico_adjunto DESC");
                    $stmt->bind_param("i", $idMtt);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0):
                        while ($row = $result->fetch_assoc()): 
                            $isPdf = strtolower(pathinfo($row["archivo"], PATHINFO_EXTENSION)) == 'pdf';
                    ?>
                    <tr>
                        <td class="align-middle text-center">
                            <input type="checkbox" name="EnviarImagen[]" class="item-checkbox" value="<?= $row["Nmttotecnico_adjunto"] ?>">
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
                            <span class="d-block font-weight-bold"><?= htmlspecialchars($row["nota"]) ?></span>
                            <small class="text-muted"><i class="fas fa-user-edit mr-1"></i><?= htmlspecialchars($row["usuario"]) ?></small>
                        </td>
                        <td class="align-middle text-muted small"><?= date("d/m/y", strtotime($row["fecha"])) ?></td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4" class="text-center p-3 text-muted italic">No hay archivos adjuntos</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="p-3 bg-white card-custom border">
            <h6 class="text-dark small font-weight-bold mb-3"><i class="fas fa-paper-plane mr-2 text-primary"></i>Enviar Notificación por Correo</h6>
            <textarea id="notaCliente" class="form-control form-control-sm mb-3" name="nota_cliente" rows="2" placeholder="Escriba el mensaje para el correo..."></textarea>
            
            <div class="row">
                <div class="col-6">
                    <button type="submit" name="EnviarMailSol" id="btnSol" class="btn btn-primary btn-block btn-envio btn-validate shadow-sm" disabled onclick="deshabilitarBotones(this, 'EnviarMailSol')">
                        <i class="fas fa-user-shield"></i> NOTIFICAR PRINCIPAL
                        <span class="mail-label"><?= $mailPrincipal ?></span>
                    </button>
                </div>
                <div class="col-6">
                    <button type="submit" name="EnviarMailAre" id="btnAre" class="btn btn-success btn-block btn-envio btn-validate shadow-sm" disabled onclick="deshabilitarBotones(this, 'EnviarMailAre')">
                        <i class="fas fa-briefcase"></i> NOTIFICAR ÁREA
                        <span class="mail-label"><?= $mailArea ?></span>
                    </button>
                </div>
            </div>
            <p id="msgValidation" class="text-danger xsmall mt-2 mb-0"><i class="fas fa-exclamation-triangle mr-1"></i> Seleccione al menos un archivo y escriba un mensaje para habilitar el envío.</p>
        </div>
        <input type="hidden" name="botonPresionado" id="botonPresionado">
    </form>
</div>

<script>
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const selectAll = document.getElementById('selectAll');
    const notaCliente = document.getElementById('notaCliente');
    const btnValidate = document.querySelectorAll('.btn-validate');
    const msgValidation = document.getElementById('msgValidation');

    function validateForm() {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
        const hasText = notaCliente.value.trim().length > 3;
        const isValid = anyChecked && hasText;

        btnValidate.forEach(btn => btn.disabled = !isValid);
        msgValidation.style.display = isValid ? 'none' : 'block';
    }

    checkboxes.forEach(cb => cb.addEventListener('change', validateForm));
    notaCliente.addEventListener('input', validateForm);
    
    if(selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = this.checked);
            validateForm();
        });
    }

    // Función para evitar doble clic y enviar el formulario
    function deshabilitarBotones(btn, nombreBoton) {
        // Deshabilitamos visualmente ambos botones de envío
        document.getElementById('btnSol').disabled = true;
        document.getElementById('btnAre').disabled = true;
        
        // Cambiamos el texto para indicar progreso
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        // Creamos un input temporal para que PHP sepa qué botón se presionó (ya que al deshabilitar el botón el POST no lo envía)
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = nombreBoton;
        hiddenInput.value = '1';
        document.getElementById('formAdjuntos').appendChild(hiddenInput);
        
        // Enviamos el formulario
        document.getElementById('formAdjuntos').submit();
    }
</script>

</body>
</html>