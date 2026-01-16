<?php
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
  .control { margin-bottom: 14px; }
  .grid-title { font-size: 22px; font-weight: 700; margin: 0 0 4px 0; }
  .grid-subtitle { font-size: 14px; color: #6b7280; margin-bottom: 12px; }
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

    <div class="control">
      <label class="form-label" for="sel-tipo-servicio">Tipo de servicio</label>
      <select id="sel-tipo-servicio" class="form-select"></select>
    </div>

    <div class="control">
      <label class="form-label" for="sel-servicio">Servicio</label>
      <select id="sel-servicio" class="form-select" disabled>
        <option value="">Seleccione un tipo primero…</option>
      </select>
    </div>

    <div class="control">
      <button id="btn-guardar-serv" type="button" class="btn btn-primary w-100">
        <span class="btn-label">Guardar servicio</span>
        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
      </button>
    </div>
  </aside>

  <main class="content main-panel">
    <div class="main-panel__inner">
      <h2 class="grid-title" id="grid-title">Tipo: — · Servicio: —</h2>
      <div class="grid-subtitle" id="grid-subtitle"></div>

      <table id="tabla-servicios" class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Tipo Servicio</th>
            <th>Servicio</th>
            <th>Imagen</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

    </div>
  </main>

</div>

<script>
/* Arranca cuando jQuery esté listo (ejecutado SOLO una vez) */
$(function(){

  // 1. Declaración de constantes y elementos DOM
  const $tipo  = $('#sel-tipo-servicio');
  const $serv  = $('#sel-servicio');
  const $title = $('#grid-title');
  const $sub   = $('#grid-subtitle');
  const $tablaServicios = $('#tabla-servicios');
  const $btnGuardar = $('#btn-guardar-serv');

  // 2. Funciones Auxiliares

  // === Carga y Renderizado de Servicios ===
  function renderServiciosPaso2(rows) {
    const $tb = $('#tabla-servicios tbody');
    $tb.empty();

    // Placeholder SVG inline (no archivo externo)
    const PLACEHOLDER = 'data:image/svg+xml;utf8,' + encodeURIComponent(`
      <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
        <rect width="120" height="120" fill="#f1f3f5"/>
        <g fill="#adb5bd">
          <circle cx="40" cy="45" r="14"/>
          <rect x="28" y="65" width="64" height="8" rx="4"/>
          <rect x="24" y="78" width="72" height="8" rx="4"/>
        </g>
        <text x="50%" y="108" text-anchor="middle" font-family="Arial, sans-serif" font-size="10" fill="#868e96">Sin imagen</text>
      </svg>
    `);

    if (!Array.isArray(rows) || rows.length === 0) {
      $tb.append('<tr><td colspan="4" class="text-center text-muted">Sin servicios cargados.</td></tr>');
      return;
    }

    rows.forEach(r => {
      const imgFile = (r.image || '').toString().trim();

      // Si viene URL absoluta, úsala; si no, arma la ruta relativa
      let imgSrc = PLACEHOLDER;
      if (imgFile) {
        imgSrc = /^https?:\/\//i.test(imgFile)
          ? imgFile
          : `../../carpetacarga/${encodeURIComponent(imgFile)}`;
      }

      $tb.append(
        `<tr>
          <td>${r.servicio_tipo || '—'}</td>
          <td>${r.servicio_nombre || r.servicio || '—'}</td>
          <td>
            <img class="ewImage"
                 src="${imgSrc}"
                 alt="${imgFile ? 'Imagen del servicio' : 'Imagen no disponible'}"
                 style="width:120px;height:120px;object-fit:cover;border:0"
                 onerror="this.onerror=null; this.src='${PLACEHOLDER}'; this.alt='Imagen no disponible';">
          </td>
          <td>
            <button class="btn btn-outline-danger btn-sm btn-del-servicio"
                    data-id="${r.Norden}" title="Eliminar servicio">🗑️</button>
          </td>
        </tr>`
      );
    });
  }


  async function loadServiciosPaso2() {
    try {
      const res = await $.getJSON('api/ataudes_cofres_list.php', { exp: <?= (int)$exp ?> });
      renderServiciosPaso2(res && Array.isArray(res.rows) ? res.rows : []);
    } catch (e) {
      console.error('Error al cargar servicios:', e);
      renderServiciosPaso2([]);
    }
  }

  // Carga de Tipos de Servicio
  function loadTiposServicio() {
    $.getJSON('api/ataudes_cofres.php', function(data){
      $tipo.empty();
      if (Array.isArray(data) && data.length) {
        data.forEach(function(row){
          $tipo.append('<option value="'+ (row.Nservicio_tipo ?? '') +'">'+ (row.nombre ?? '') +'</option>');
        });
        $tipo.prop('disabled', false);
        onTipoChange(); 
      } else {
        $tipo.append('<option value="">(Sin tipos)</option>').prop('disabled', true);
        $serv.empty().append('<option value="">Seleccione un tipo primero…</option>').prop('disabled', true);
        updateHeader();
      }
    }).fail(function(){
      $tipo.empty().append('<option value="">(Error cargando)</option>').prop('disabled', true);
      $serv.empty().append('<option value="">Seleccione un tipo primero…</option>').prop('disabled', true);
      updateHeader();
    });
  }

  // Carga de Servicios por Tipo
  function loadServiciosByTipo(tipo) {
    if (!tipo) {
      $serv.empty().append('<option value="">Seleccione un tipo primero…</option>').prop('disabled', true);
      updateHeader();
      return;
    }

    $.getJSON('api/servicios.php', { tipo: tipo }, function(data){
      $serv.empty();
      if (Array.isArray(data) && data.length) {
        data.forEach(function(row){
          $serv.append('<option value="'+ (row.Nservicio ?? '') +'">'+ (row.nombre ?? '') +'</option>');
        });
        $serv.prop('disabled', false);
      } else {
        $serv.append('<option value="">(Sin servicios)</option>').prop('disabled', true);
      }
      updateHeader();
    }).fail(function(){
      $serv.empty().append('<option value="">(Error cargando)</option>').prop('disabled', true);
      updateHeader();
    });
  }

  // Eventos de cambio
  function onTipoChange() {
    const tipoVal  = $tipo.val();
    loadServiciosByTipo(tipoVal);
  }
  function onServicioChange() {
    updateHeader();
  }

  // Actualiza Título/Subtítulo
  function updateHeader() {
    const tipoName = $('#sel-tipo-servicio option:selected').text() || '—';
    const servName = $('#sel-servicio option:selected').text() || '—';
    $title.text('Tipo: ' + tipoName + ' · Servicio: ' + servName);

    const today = new Date();
    let longDate = today.toLocaleDateString('es-ES', {
      weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
    });
    longDate = longDate.charAt(0).toUpperCase() + longDate.slice(1);
    $sub.text(longDate);
  }

  function setSavingState(saving) {
    if (saving) {
      $btnGuardar.prop('disabled', true)
                 .attr('aria-busy','true');
      $btnGuardar.find('.spinner-border').removeClass('d-none');
      $btnGuardar.find('.btn-label').text('Guardando...');
    } else {
      $btnGuardar.prop('disabled', false)
                 .removeAttr('aria-busy');
      $btnGuardar.find('.spinner-border').addClass('d-none');
      $btnGuardar.find('.btn-label').text('Guardar servicio');
    }
  }

  // === Guardar Servicio (sin fecha/hora/espera/funeraria) ===
  $btnGuardar.on('click', async () => {
    if ($btnGuardar.prop('disabled')) return;

    const expediente      = $('#exp-card').data('expediente');
    const tipo_servicio   = $tipo.val();
    const servicio        = $serv.val();
    const user            = <?= json_encode($username ?? '') ?>;

    if (!expediente || !tipo_servicio || !servicio) {
        alert('Faltan campos obligatorios (Expediente, Tipo o Servicio).');
        return;
    }

    setSavingState(true);

    try {
      const res = await $.ajax({
        url: 'api/ataud_cofre_agregar.php',
        method: 'POST',
        dataType: 'json',
        timeout: 20000,
        data: { expediente, tipo_servicio, servicio, user }
      });

      if (res && res.ok) {
        alert(res.msg || 'Servicio guardado.');
        location.reload();
      } else {
        alert((res && res.msg) ? res.msg : 'No se pudo guardar el servicio.');
        setSavingState(false);
      }
    } catch (err) {
      console.error(err);
      alert('Error de red o servidor al guardar el servicio.');
      setSavingState(false);
    }
  });

  // ======== Eliminar servicio ========
  $tablaServicios.on('click', '.btn-del-servicio', async function () {
    const $this = $(this);
    const id = $this.data('id');
    if (!id) return;

    if (!confirm('¿Seguro que desea eliminar este servicio?')) return;

    try {
      $this.prop('disabled', true).html('⏳');

      const res = await $.ajax({
        url: 'api/servicio_eliminar.php',
        method: 'POST',
        dataType: 'json',
        data: { id }
      });

      if (res && res.ok) {
        alert('Servicio eliminado correctamente.');
        await loadServiciosPaso2();
      } else {
        alert(res.msg || 'No se pudo eliminar el servicio.');
        $this.prop('disabled', false).html('🗑️');
      }
    } catch (err) {
      console.error(err);
      alert('Error de red o servidor al eliminar.');
      $this.prop('disabled', false).html('🗑️');
    }
  });

  // 4. Inicialización
  loadServiciosPaso2();
  loadTiposServicio();

  // Bind de eventos de cambio de selects
  $tipo.on('change', onTipoChange);
  $serv.on('change', onServicioChange);
});
</script>
</body>
</html>
