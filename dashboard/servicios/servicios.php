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

// === Fecha y hora fin de velación (por defecto) ===
$fecha_fin_vel = '';
$hora_fin_vel  = '';

if ($exp > 0) {
  $stmt = $mysqli->prepare("
      SELECT DATE_FORMAT(fecha_fin, '%Y-%m-%d') AS fecha_fin, hora_fin
      FROM sco_orden
      WHERE expediente = ? AND paso = 1
      ORDER BY fecha_fin DESC, hora_fin DESC
      LIMIT 1
  ");
  $stmt->bind_param("i", $exp);
  $stmt->execute();
  $stmt->bind_result($fecha_fin_vel, $hora_fin_vel);
  $stmt->fetch();
  $stmt->close();
}

// Prefill de funeraria si el expediente tiene paso=1 en sco_orden
$prefFunId = 0;
$prefFunName = '';

if ($exp > 0) {
  $sqlPaso = "SELECT 1 FROM sco_orden WHERE expediente = ? AND paso = 1 LIMIT 1";
  if ($st = $mysqli->prepare($sqlPaso)) {
    $st->bind_param("i", $exp);
    $st->execute(); $st->store_result();
    if ($st->num_rows > 0) {
      $prefFunId = 1;
      // Asume 'Funeraria Monumental' si no se encuentra o hay error en la base
      $prefFunName = 'Funeraria Monumental';
      if ($sp = $mysqli->prepare("SELECT nombre FROM sco_proveedor WHERE Nproveedor=1 LIMIT 1")) {
        $sp->execute(); $sp->bind_result($xname);
        if ($sp->fetch()) {
            $prefFunName = $xname ?: 'Funeraria Monumental';
        }
        $sp->close();
      }
    }
    $st->close();
  }
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

  /* Estilos para Typeahead */
  .typeahead-list {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      z-index: 1000;
      background: #fff;
      border: 1px solid #ccc;
      border-top: none;
      max-height: 200px;
      overflow-y: auto;
      display: none; /* Inicia oculto */
  }
  .typeahead-item {
      padding: 8px 12px;
      cursor: pointer;
  }
  .typeahead-item:hover, .typeahead-item.active {
      background: #f0f0f0;
  }
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
      <label class="form-label">Fecha fin velación</label>
      <input type="date" id="sel-fecha" class="form-control" value="<?= htmlspecialchars($fecha_fin_vel) ?>">
    </div>

    <div class="control">
      <label class="form-label">Hora fin velación</label>
      <select id="hora_ser" name="hora_ser" class="form-select">
        <?php
        $horas = [];
        for ($h = 0; $h < 24; $h++) {
          foreach (['00', '30'] as $m) {
            $val = sprintf('%02d:%s', $h, $m);
            $ampm = date("g:i a", strtotime($val));
            $sel = ($val == substr($hora_fin_vel, 0, 5)) ? 'selected' : '';
            echo "<option value='$val' $sel>$ampm</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="control form-check form-switch">
      <input class="form-check-input" type="checkbox" role="switch" id="chk-espera-cenizas">
      <label class="form-check-label" for="chk-espera-cenizas">Espera de cenizas</label>
    </div>

    <div class="control">
      <button id="btn-guardar-serv" type="button" class="btn btn-primary w-100">
        <span class="btn-label">Guardar servicio</span>
        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
      </button>
    </div>


    <div class="control position-relative">
      <label class="form-label">Funeraria</label>
      <input type="hidden" id="funeraria_id" value="<?= (int)$prefFunId ?>">
      <input type="hidden" id="proveedor_id" value="<?= (int)$prefFunId ?>"> 


      <input type="text" class="form-control" id="funeraria_input" placeholder="Buscar y seleccionar funeraria…"
             value="<?= htmlspecialchars($prefFunName) ?>" autocomplete="off">
 
      <div id="funeraria_list" class="typeahead-list shadow-sm"></div>
    </div>
  </aside>

  <main class="content main-panel">
    <div class="main-panel__inner">
      <h2 class="grid-title" id="grid-title">Tipo: — · Servicio: —</h2>
      <div class="grid-subtitle" id="grid-subtitle"></div>

      <table id="tabla-servicios" class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Funeraria</th>
            <th>Tipo Servicio</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Espera Cenizas</th>
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

  const $funInput = $('#funeraria_input');
  const $funId    = $('#funeraria_id');
  const $provId   = $('#proveedor_id');
  const $funList  = $('#funeraria_list');

  const $btnGuardar = $('#btn-guardar-serv');

  // 2. Funciones Auxiliares (accesibles dentro de este scope)

  // === Carga y Renderizado de Servicios (la función que daba error) ===
  function renderServiciosPaso2(rows) {
    const $tb = $tablaServicios.find('tbody');
    $tb.empty();
    if (!Array.isArray(rows) || rows.length === 0) {
      $tb.append('<tr><td colspan="8" class="text-center text-muted">Sin servicios cargados.</td></tr>');
      return;
    }
    rows.forEach(r => {
      $tb.append(
        `<tr>
          <td>${r.proveedor_nombre || '—'}</td>
          <td>${r.servicio_tipo || '—'}</td>
          <td>${r.servicio_nombre || r.servicio || '—'}</td>
          <td>${r.fecha || '—'}</td>
          <td>${r.hora || '—'}</td>
          <td>${(r.espera_cenizas || 'N') === 'S' ? 'Sí' : 'No'}</td>
          <td>
            <button class="btn btn-outline-danger btn-sm btn-del-servicio"
                    data-id="${r.Norden}" title="Eliminar servicio">
              🗑️
            </button>
          </td>
        </tr>`
      );
    });
  }

  async function loadServiciosPaso2() {
    try {
      const res = await $.getJSON('api/servicios_list.php', { exp: <?= (int)$exp ?> });
      renderServiciosPaso2(res && Array.isArray(res.rows) ? res.rows : []);
    } catch (e) {
      console.error('Error al cargar servicios:', e);
      renderServiciosPaso2([]);
    }
  }
  // ===================================================================

  // Carga de Tipos de Servicio (endpoint de tipos)
  function loadTiposServicio() {
    $.getJSON('api/servicios_tipos.php', function(data){
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

  // Carga de Servicios por Tipo (endpoint de servicios)
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

  // Typeahead helpers (debounce y render)
  function debounce(fn, ms) {
    let t = null;
    return function(...args) {
      clearTimeout(t);
      t = setTimeout(() => fn.apply(this, args), ms);
    };
  }
  function renderFunerarias(items) {
    if (!Array.isArray(items) || items.length === 0) {
      $funList.hide().empty();
      return;
    }
    const html = items.map(it => {
      const id = it.Nproveedor ?? '';
      const name = it.nombre ?? '';
      const safeName = $('<div>').text(name).html(); 
      return `<div class="typeahead-item" data-id="${id}" data-name="${safeName}">${safeName}</div>`;
    }).join('');
    $funList.html(html).show();
  }
  const searchFunerarias = debounce(function(term){
    term = (term || '').trim();
    if (term.length < 2) { $funList.hide().empty(); return; }
    $.getJSON('api/funerarias.php', { q: term }, function(data){
      renderFunerarias(data);
    }).fail(function(){
      $funList.hide().empty();
    });
  }, 220);


  // 3. Event Listeners

  // === Eventos de la Funeraria (Typeahead) ===
  $funInput.on('input', function(){
    $funId.val('');
    $provId.val('');
    searchFunerarias(this.value);
  });

  $funList.on('click', '.typeahead-item', function(){
    const id   = this.getAttribute('data-id') || '';
    const name = this.getAttribute('data-name') || '';
    $funId.val(id);
    $provId.val(id);
    $funInput.val($('<div>').html(name).text());
    $funList.hide().empty();
  });

  $funInput.on('keydown', function(e){
    const $items = $funList.find('.typeahead-item');
    if (!$items.length || !$funList.is(':visible')) return;

    const $active = $items.filter('.active');
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      const $next = $active.length ? $active.next() : $items.first();
      $items.removeClass('active');
      $next.addClass('active')[0]?.scrollIntoView({ block:'nearest' });
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      const $prev = $active.length ? $active.prev() : $items.last();
      $items.removeClass('active');
      $prev.addClass('active')[0]?.scrollIntoView({ block:'nearest' });
    } else if (e.key === 'Enter') {
      e.preventDefault();
      const el = ($active[0] || $items[0]);
      if (el) $(el).trigger('click');
    } else if (e.key === 'Escape') {
      $funList.hide().empty();
    }
  });

  // Clic fuera => cerrar typeahead
  $(document).on('click', function(e){
    if (!$(e.target).closest('.typeahead-list, #funeraria_input').length) {
      $funList.hide().empty();
    }
  });

  // === Evento de Guardar Servicio ===
  $btnGuardar.on('click', async () => {
    if ($btnGuardar.prop('disabled')) return;

    const expediente      = $('#exp-card').data('expediente');
    const tipo_servicio   = $tipo.val();
    const servicio        = $serv.val();
    const proveedor       = $provId.val() || ''; 
    const funeraria       = 1;
    const fecha_ser       = $('#sel-fecha').val();
    const hora_ser        = $('#hora_ser').val();
    const espera_cenizas  = $('#chk-espera-cenizas').is(':checked') ? 'S' : 'N';
    const user            = <?= json_encode($username ?? '') ?>;

    if (!expediente || !tipo_servicio || !servicio || !fecha_ser || !hora_ser) {
        alert('Faltan campos obligatorios (Expediente, Tipo, Servicio, Fecha u Hora).');
        return;
    }

    setSavingState(true);

    try {
      const res = await $.ajax({
        url: 'api/servicio_agregar.php',
        method: 'POST',
        dataType: 'json',
        timeout: 20000,
        data: {
          expediente, tipo_servicio, servicio, proveedor,
          funeraria, fecha_ser, hora_ser, espera_cenizas, user
        }
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

  // ======== Eliminar servicio (CORREGIDO Y DENTRO DEL SCOPE) ========
  // Vinculamos el evento delegado a la tabla estática (#tabla-servicios)
  // UNA SOLA VEZ, al inicio, para que capture los clics en los botones dinámicos.
  $tablaServicios.on('click', '.btn-del-servicio', async function () {
    const $this = $(this);
    const id = $this.data('id');
    if (!id) return;

    // Confirma una sola vez (esto ya estaba en el código anterior)
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
        await loadServiciosPaso2(); // **loadServiciosPaso2 ES ACCESIBLE AQUÍ**
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