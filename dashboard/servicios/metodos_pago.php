<?php
// Mantiene la conexión y la obtención del expediente del difunto
require_once '../includes/conexBD.php';
$mysqli = $link;

// Nexpediente por GET
$exp = isset($_GET['exp']) ? (int)$_GET['exp'] : 0;
$username = $_GET['username'] ?? '';

$difunto = [
  'Nexpediente' => $exp,
  'nombre' => '',
  'apellidos' => ''
];

if ($exp > 0) {
  $stmt = $mysqli->prepare("SELECT Nexpediente, COALESCE(nombre_fallecido,''), COALESCE(apellidos_fallecido,'') FROM sco_expediente WHERE Nexpediente = ?");
  $stmt->bind_param("i", $exp);
  $stmt->execute();
  $stmt->bind_result($nx, $nom, $ape);
  if ($stmt->fetch()) {
    $difunto['Nexpediente'] = $nx;
    $difunto['nombre'] = $nom;
    $difunto['apellidos'] = $ape;
  }
  $stmt->close();
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Módulo Capillas</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="assets/app.css" rel="stylesheet">
<link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">
<script src="assets/jquery-3.7.1.min.js"></script>
<script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

<style>
  /* Layout minimal con panel izquierdo fijo y contenido a la derecha */
  .layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    min-height: 100vh;
    background: #f6f7fb;
  }
  .sidebar {
    background: #fff;
    border-right: 1px solid #e5e7eb;
    padding: 16px;
    position: sticky;
    top: 0;
    align-self: start;
    height: 100vh;
    overflow: auto;
  }
  .content { padding: 24px; }
  .card.expediente-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 16px;
    background: #fafafa;
  }
  .exp-id { font-weight: 700; }
  .exp-nombre { color: #374151; }
  .grid-title { font-size: 22px; font-weight: 700; margin: 0 0 4px 0; }
  .grid-subtitle { font-size: 14px; color: #6b7280; margin-bottom: 12px; }
  /* Estilos específicos para la nueva tabla de costos (Ajuste de índices) */
  #tabla-servicios th:nth-child(3),
  #tabla-servicios td:nth-child(3) { text-align: center; width: 50px; } /* Cantidad (antes 4) */
  #tabla-servicios th:nth-child(4),
  #tabla-servicios td:nth-child(4),
  #tabla-servicios th:nth-child(5),
  #tabla-servicios td:nth-child(5) { text-align: right; width: 100px; } /* Costo y Total (antes 5 y 6) */
</style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <h3 class="mb-3">Expediente</h3>

    <div class="card expediente-card" id="exp-card"
         data-expediente="<?= htmlspecialchars($difunto['Nexpediente']) ?>"
         data-nombre="<?= htmlspecialchars(trim($difunto['nombre'].' '.$difunto['apellidos'])) ?>">
      <div class="exp-id">#<?= htmlspecialchars($difunto['Nexpediente']) ?></div>
      <div class="exp-nombre"><?= htmlspecialchars(trim($difunto['nombre'].' '.$difunto['apellidos'])) ?></div>
    </div>
  </aside>

  <main class="content main-panel">
    <div class="main-panel__inner">
      <h2 class="grid-title" id="grid-title">Servicios Asociados</h2>
      <div class="grid-subtitle" id="grid-subtitle"></div>

      <table id="tabla-servicios" class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Tipo Servicio</th>
            <th>Servicio</th>
            <th>Can.</th>
            <th>Costo</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody></tbody>
        <tfoot>
          <tr>
            <td colspan="2" class="text-end fw-bold"></td> <td colspan="1" class="text-center fw-bold" id="footer-cantidad"></td>
            <td colspan="1" class="text-end fw-bold"></td>
            <td colspan="1" class="text-end fw-bold" id="footer-total-monto"></td>
          </tr>
        </tfoot>
      </table>

    </div>
  </main>

</div>

<script>
/* Arranca cuando jQuery esté listo (ejecutado SOLO una vez) */
$(function(){

  // 1. Declaración de constantes y elementos DOM (reducida)
  const $title = $('#grid-title');
  const $sub   = $('#grid-subtitle');

  // Helper para formatear números como moneda Bs.X.XXX,XX
  const formatCurrency = (value) => {
    // Asegura que sea un número flotante
    const num = parseFloat(value);
    if (isNaN(num)) return '—';

    // Implementación sencilla similar a number_format($num, 2, ',', '.')
    return 'Bs.' + num.toLocaleString('es-ES', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
      useGrouping: true
    });
  };

  // === Carga y Renderizado de Servicios ===
  function renderServiciosPaso2(data) {
    const $tb = $('#tabla-servicios tbody');
    $tb.empty();

    const rows = data.rows || [];
    const total_servicios = data.total_servicios || 0;
    const total_monto = data.total_monto || 0.00;

    // Placeholder e imágenes eliminados, solo se necesita el colspan ajustado
    const COLSPAN_EMPTY = 5; // (Tipo Servicio, Servicio, Cantidad, Costo, Total)

    if (!Array.isArray(rows) || rows.length === 0) {
      $tb.append(`<tr><td colspan="${COLSPAN_EMPTY}" class="text-center text-muted">Sin servicios cargados.</td></tr>`);
    } else {
      rows.forEach(r => {
        $tb.append(
          `<tr>
            <td>${r.servicio_tipo || '—'}</td>
            <td>${r.servicio_nombre || '—'}</td>
            <td class="text-center">${r.cantidad ?? '—'}</td>
            <td class="text-end">${formatCurrency(r.costo)}</td>
            <td class="text-end">${formatCurrency(r.total)}</td>
          </tr>`
        );
      });
    }

    // Actualizar el pie de página (totales)
    $('#footer-cantidad').text(`Servicios: ${total_servicios}`);
    $('#footer-total-monto').text(`Total Bs.: ${formatCurrency(total_monto).replace('Bs.', '')}`);
    $('#footer-total-monto').prev().text(''); 
  }


  async function loadServiciosPaso2() {
    try {
      const exp_num = <?= (int)$exp ?>;
      // USANDO el nuevo endpoint: api/metodos_pago_list.php
      const res = await $.getJSON('api/metodos_pago_list.php', { exp: exp_num }); 
      renderServiciosPaso2(res || {});
    } catch (e) {
      console.error('Error al cargar servicios:', e);
      renderServiciosPaso2({});
    }
  }

  // Actualiza Título/Subtítulo (simplificado)
  function updateHeader() {
    $title.text('Servicios Asociados al Expediente #<?= (int)$exp ?>');

    const today = new Date();
    let longDate = today.toLocaleDateString('es-ES', {
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
    longDate = longDate.charAt(0).toUpperCase() + longDate.slice(1);
    $sub.text(longDate);
  }

  // 4. Inicialización
  loadServiciosPaso2();
  updateHeader();
});
</script>
</body>
</html>