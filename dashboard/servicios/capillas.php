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
$fecha_fin_vel = date('Y-m-d');

if ($exp > 0) {
  $stmt = $mysqli->prepare("
      SELECT DATE_FORMAT(fecha_fin, '%Y-%m-%d') AS fecha_fin
      FROM sco_orden
      WHERE expediente = ? AND paso = 1
      ORDER BY fecha_fin DESC, hora_fin DESC
      LIMIT 1
  ");
  $stmt->bind_param("i", $exp);
  $stmt->execute();
  $stmt->bind_result($fecha_fin_vel);
  $stmt->fetch();
  $stmt->close();
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Reservas de Capillas</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="assets/app.css" rel="stylesheet">

<!-- Bootstrap CSS (local) -->
<link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">

<!-- jQuery local -->
<script src="assets/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS local (bundle incluye Popper) -->
<script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
        
<script>
  if (!window.jQuery) {
    var s = document.createElement('script');
    s.src = 'assets/jquery-3.7.1.min.js'; // asegúrate de tener este archivo
    document.head.appendChild(s);
  }
</script>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <h3>Expediente</h3>
    <div class="card expediente-card" draggable="true" id="exp-card"
         data-expediente="<?= htmlspecialchars($difunto['Nexpediente']) ?>"
         data-nombre="<?= htmlspecialchars(trim($difunto['nombre'].' '.$difunto['apellidos'])) ?>">
      <div class="exp-id">#<?= htmlspecialchars($difunto['Nexpediente']) ?></div>
      <div class="exp-nombre"><?= htmlspecialchars(trim($difunto['nombre'].' '.$difunto['apellidos'])) ?></div>
    </div>

    <div class="control">
      <label>Localidad</label>
      <select id="sel-localidad"></select>
    </div>

    <div class="control">
      <label>Fecha</label>
      <input type="date" id="sel-fecha" value="<?= $fecha_fin_vel ?>">
    </div>

    <div class="control">
      <label>Horas de velación</label>
      <select id="sel-horas"></select>
    </div>

    <div class="hint">Arrastra la tarjeta del expediente a una celda disponible.</div>

    <div class="control">
      <button id="btn-quitar-reserva" type="button">Quitar reserva(s) seleccionada(s)</button>
      <small>Si hay varios expedientes en la celda, se te pedirá cuál quitar.</small>
    </div>

    <div class="control">
      <button id="btn-bloquear" type="button">Bloquear franja seleccionada</button>
      <small>Tip: haz clic en una celda para “pre-seleccionarla” antes de bloquear.</small>
    </div>

    <div class="control">
      <div id="sel-info" class="hint" style="line-height:1.3">
        Franja seleccionada: <br>
        <strong>—</strong>
      </div>
    </div>

    <div class="control">
      <button id="btn-desbloquear" type="button">Desbloquear franja seleccionada</button>
      <small>Solo sobre celdas bloqueadas (por ID).</small>
    </div>

  </aside>

  <main class="content">
    <h2 class="grid-title" id="grid-title"></h2>
    <div class="grid-subtitle" id="grid-subtitle"></div>

    <div id="grid-loading" class="grid-loading hidden">
      <div class="loader">
        <div class="spinner" aria-hidden="true"></div>
        <div class="loader-text">Cargando disponibilidad…</div>
      </div>
    </div>

    <div id="grid-container"></div>
  </main>
</div>

<script>
/* Espera a que jQuery esté disponible (por si entró el fallback) */
(function bootWhenReady(){
  if (!window.jQuery) { return setTimeout(bootWhenReady, 50); }

  const $loc = $('#sel-localidad');
  const $fecha = $('#sel-fecha');
  const $horas = $('#sel-horas');
  const $grid = $('#grid-container');

  let currentLocalidad = null;
  let currentCapillas = [];
  let selectedCell = null;

  // === Loading helper ===
  let gridPendingRequests = 0;
  function showGridLoading(){ gridPendingRequests++; $('#grid-loading').removeClass('hidden'); }
  function hideGridLoading(){ gridPendingRequests=Math.max(0,gridPendingRequests-1); if(!gridPendingRequests){ $('#grid-loading').addClass('hidden'); } }

  // Delegados: funcionan aunque la grilla se vuelva a pintar
  $grid.on('dragover', '.cell.slot.disponible', function(e) {
    e.preventDefault();
    (e.originalEvent||e).dataTransfer.dropEffect = 'copy';
    this.classList.add('droptarget');
  });
  $grid.on('dragleave', '.cell.slot.disponible', function() {
    this.classList.remove('droptarget');
  });
  $grid.on('drop', '.cell.slot.disponible', onDropReserve);

  // Selección de franja (en cualquier celda de slots)
  $grid.on('click', '.cell.slot', function () {
    if (selectedCell) selectedCell.classList.remove('selected');
    this.classList.add('selected');
    selectedCell = this;
    updateSelectionInfo();
    refreshActionButtons();
  });

  // Panel de “franja seleccionada”
  function updateSelectionInfo() {
    const $info = $('#sel-info');
    if (!selectedCell) {
      $info.html('Franja seleccionada:<br><strong>—</strong>');
      return;
    }
    const hora = selectedCell.dataset.time || '—';
    const hrs = parseInt($('#sel-horas').val(), 10) || 1;
    const estado = selectedCell.dataset.estado || 'disponible';
    const fin = (() => {
      const [H,M] = hora.split(':').map(Number);
      const date = new Date(2000,0,1,H,M,0);
      date.setHours(date.getHours() + hrs);
      return String(date.toTimeString().slice(0,5));
    })();

    let extra = '';
    const blkId = selectedCell.getAttribute('data-bloqueo-id');
    if (blkId) extra = `<br>Bloqueo ID: <strong>${blkId}</strong>`;

    $info.html(
      `Franja seleccionada:<br>` +
      `<strong>${hora} → ${fin}</strong>` +
      `<br>Capilla: <strong>${selectedCell.dataset.capilla}</strong>` +
      `<br>Horas: <strong>${hrs}</strong>` +
      `<br>Estado: <strong>${estadoLegible(estado)}</strong>` +
      extra
    );
  }

  function refreshActionButtons() {
    const $btnBlock = $('#btn-bloquear');
    const $btnUnblock = $('#btn-desbloquear');
    const $btnRemove = $('#btn-quitar-reserva');

    if (!selectedCell) {
      $btnBlock.prop('disabled', true);
      $btnUnblock.prop('disabled', true);
      $btnRemove.prop('disabled', true);
      return;
    }
    const estado = (selectedCell.dataset.estado || 'disponible').toLowerCase();

    const canBlock   = (estado === 'disponible');
    const canUnblock = (estado === 'bloqueada');
    const canRemove  = (estado === 'reservada');

    $btnBlock.prop('disabled', !canBlock);
    $btnUnblock.prop('disabled', !canUnblock);
    $btnRemove.prop('disabled', !canRemove);
  }

  function estadoLegible(estado) {
    switch ((estado || '').toLowerCase()) {
      case 'disponible': return 'Disponible';
      case 'bloqueada':  return 'Bloqueada';
      case 'reservada':  return 'Reservada';
      default: return estado || '—';
    }
  }

  // Cambia horas => refresca resumen/botones
  $('#sel-horas').on('change', () => { updateSelectionInfo(); refreshActionButtons(); });

  // Fuente del drag (la tarjeta)
  (function setupDragSource() {
    const card = document.getElementById('exp-card');
    if (!card) return;
    card.setAttribute('draggable', 'true');
    card.addEventListener('dragstart', ev => {
      const payload = {
        expediente: card.dataset.expediente,
        nombre: card.dataset.nombre,
        horas: document.getElementById('sel-horas').value
      };
      ev.dataTransfer.effectAllowed = 'copy';
      ev.dataTransfer.setData('application/json', JSON.stringify(payload));
      ev.dataTransfer.setData('text/plain', JSON.stringify(payload));
    });
  })();

  // Cargar localidades
  function loadLocalidades() {
    $.getJSON('api/localidades.php', data => {
      $loc.empty();
      data.forEach(row => {
        $loc.append(`<option value="${row.Nservicio_tipo}">${row.nombre}</option>`);
      });
      currentLocalidad = $loc.val();
      updateGridTitle();
      loadHoras();
      loadCapillasAndGrid();
    });
  }

  // Cargar catálogo de horas
  function loadHoras() {
    $.getJSON('api/horas.php', data => {
      $horas.empty();
      data.forEach(row => {
        $horas.append(`<option value="${row.Nservicio}">${row.nombre}</option>`);
      });
    });
  }

  function loadCapillasAndGrid() {
    updateGridTitle();
    showGridLoading();
    $.getJSON('api/capillas.php', { localidad: currentLocalidad }, caps => {
      currentCapillas = caps; // [{Nservicio, nombre}]
      loadGrid();
    }).always(() => { /* el hide lo hace loadGrid */ });
  }

  function loadGrid() {
    showGridLoading();
    $.getJSON('api/slots.php', {
      localidad: currentLocalidad,
      fecha: $fecha.val()
    }, payload => {
      renderGrid(payload);
    })
    .fail(() => {
      $grid.html('<div class="empty-banner">No se pudo cargar la grilla. Intente nuevamente.</div>');
    })
    .always(() => {
      hideGridLoading();
      hideGridLoading();
    });
  }

  function escapeHtml(s){ return String(s||'').replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

  function renderGrid(model) {
    const hasCaps = Array.isArray(model.capillas) && model.capillas.length > 0;

    if (!hasCaps) {
      $grid.html(`<div class="empty-banner">No hay capillas activas para la localidad seleccionada.</div>`);
      return;
    }

    const cols = model.capillas.length;
    const colwPx = (cols >= 6) ? 220 : 160;
    const colw   = (cols >= 6) ? `${colwPx}px` : `minmax(${colwPx}px, 1fr)`;

    let html = `<div class="grid" style="--cols:${cols}; --colw:${colw}; --colwpx:${colwPx}">`;

    // header
    html += '<div class="cell header time">Hora</div>';
    model.capillas.forEach(c => { html += `<div class="cell header">${escapeHtml(c.nombre)}</div>`; });
    html += '<div class="cell header time">Hora</div>';

    // filas
    model.times.forEach(t => {
      html += `<div class="cell time">${t}</div>`;
      model.capillas.forEach(c => {
        const key = `${c.Nservicio}|${t}`;
        const slot = model.slots[key] || { estado: 'disponible' };

        let cls = `slot ${slot.estado || 'disponible'}`;
        let content = '';

        // atributos extra (por ID de bloqueo)
        let extraAttrs = '';
        if (slot.estado === 'bloqueada' && slot.bloqueo_id) {
          extraAttrs += ` data-bloqueo-id="${String(slot.bloqueo_id)}"`;
        }

        if (slot.estado === 'reservada' && Array.isArray(slot.items) && slot.items.length > 0) {
          content = `<div class="slot-items">` + slot.items.map(it => {
            const exp = (it.expediente != null)
              ? String(it.expediente)
              : (String(it.label || '').split(' - ')[0].replace('#','') || '');
            const nameGuess = (it.nombre && it.nombre.trim())
              ? it.nombre
              : (String(it.label || '').split(' - ').slice(1).join(' - ') || '');
            const ordenId = (it.orden_id != null) ? String(it.orden_id) : '';

            // 🚫 Nada de backticks anidados: construimos el label por concatenación
            const rawLabel = it.label ? String(it.label) : ('#' + exp + ' - ' + nameGuess);
            const titleAttr = escapeHtml(rawLabel);

            return `
              <div class="chip chip--two"
                   data-orden-id="${escapeHtml(ordenId)}"
                   data-expediente="${escapeHtml(exp)}"
                   title="${titleAttr}">
                <div class="chip-exp">#${escapeHtml(exp)}</div>
                <div class="chip-name">${escapeHtml(nameGuess)}</div>
              </div>`;
          }).join('') + `</div>`;
        }
        else if (slot.estado === 'reservada' && slot.text) {
          // respaldo sin items (no hay IDs aquí)
          const parts = String(slot.text).split(' - ');
          const exp = parts[0] ? parts[0].replace('#','') : '';
          const name = parts.slice(1).join(' - ');
          content = `
            <div class="slot-items">
              <div class="chip chip--two" title="${escapeHtml(slot.text)}">
                <div class="chip-exp">#${escapeHtml(exp)}</div>
                <div class="chip-name">${escapeHtml(name)}</div>
              </div>
            </div>`;
        } else {
          // disponible o bloqueada (texto/motivo)
          content = `<div class="slot-label">${escapeHtml(slot.text || '')}</div>`;
        }

        html += `<div class="cell ${cls}" data-capilla="${c.Nservicio}" data-time="${t}" data-estado="${slot.estado || 'disponible'}"${extraAttrs}>
                   ${content}
                 </div>`;
      });
      html += `<div class="cell time">${t}</div>`;
    });

    html += '</div>';
    $grid.html(html);

    // reset selección tras repintar
    selectedCell = null;
    updateSelectionInfo();
    refreshActionButtons();
  }

  async function onDropReserve(e) {
    e.preventDefault();

    // Guarda referencia a la celda antes del await
    const cell = this;

    // Lee el payload arrastrado
    const dt = e.originalEvent ? e.originalEvent.dataTransfer : e.dataTransfer;
    let dataStr = dt.getData('application/json') || dt.getData('text/plain');
    if (!dataStr) { alert('No se pudo leer el expediente.'); return; }

    let data;
    try {
      data = JSON.parse(dataStr);
    } catch {
      alert('Datos de arrastre inválidos.');
      return;
    }

    const capilla   = cell.dataset.capilla;
    const time      = cell.dataset.time;
    const horasInt  = parseInt($('#sel-horas').val(), 10) || 1;
    const localidad = $('#sel-localidad').val();
    const fecha     = $('#sel-fecha').val();

    try {
      showGridLoading();

      // Llamada al endpoint
      let res = await $.ajax({
        url: 'api/reservar.php',
        method: 'POST',
        dataType: 'json',  // si el server no manda JSON correcto, igual tratamos abajo
        data: {
          expediente: data.expediente,
          localidad:  localidad,
          capilla:    capilla,
          fecha:      fecha,
          time:       time,
          horas:      horasInt
        }
      });

      // A veces llega texto si el servidor imprime espacios/BOM.
      if (typeof res === 'string') {
        try { res = JSON.parse(res); } catch (_) { /* lo dejamos como string */ }
      }

      if (res && res.ok) {
        // Éxito: feedback y recarga
        cell.classList.remove('droptarget');

        // Mensaje de éxito (si el backend envía Norden, lo mostramos)
        const idText = res.norden ? ` (Orden ${res.norden})` : '';
        alert((res.msg || 'Reserva creada.') + idText);

        // Refresca la grilla
        await loadGrid();
      } else {
        // Error controlado por el backend
        const msg = (res && res.msg) ? res.msg : 'No se pudo reservar. Verifique solapamientos.';
        alert(msg);
      }
    } catch (err) {
      // Error de red/JS
      console.error('Error reservando:', err);
      alert('Error al reservar. Inténtalo nuevamente.');
    } finally {
      hideGridLoading();
    }
  }

  function updateGridTitle() {
    const locName = $('#sel-localidad option:selected').text() || '—';
    const iso = $('#sel-fecha').val();
    let longDate = '—';
    if (iso) {
      const [y,m,d] = iso.split('-').map(Number);
      const date = new Date(y, m - 1, d);
      longDate = date.toLocaleDateString('es-ES', {
        weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
      });
      longDate = longDate.charAt(0).toUpperCase() + longDate.slice(1);
    }
    $('#grid-title').text(`Localidad: ${locName}`);
    $('#grid-subtitle').text(longDate);
  }

  // ====== Botones ======

  $('#btn-bloquear').on('click', async () => {
    if (!selectedCell) { alert('Primero selecciona una celda.'); return; }
    if ($('#btn-bloquear').prop('disabled')) {
      alert('Solo puedes bloquear celdas disponibles.');
      return;
    }
    const capilla = selectedCell.dataset.capilla;
    const time = selectedCell.dataset.time;
    const hrs = parseInt($('#sel-horas').val(), 10) || 1;

    const motivo = prompt('Motivo del bloqueo (opcional):', 'Mantenimiento');
    if (motivo === null) return;

    const res = await $.ajax({
      url: 'api/bloquear.php',
      method: 'POST',
      dataType: 'json',
      data: {
        localidad: $('#sel-localidad').val(),
        capilla,
        fecha: $('#sel-fecha').val(),
        time,
        horas: hrs,
        motivo: motivo || ''
      }
    }); 
    
    if (res.ok) { alert(res.msg); loadGrid(); }
    else { alert(res.msg || 'No se pudo bloquear.'); }
  });

  // Desbloquear por ID exacto (sin rangos)
  $('#btn-desbloquear').on('click', async () => {
    if (!selectedCell) { alert('Primero selecciona una celda.'); return; }
    if ($('#btn-desbloquear').prop('disabled')) {
      alert('Solo puedes desbloquear celdas bloqueadas.');
      return;
    }
    const blkId = selectedCell.getAttribute('data-bloqueo-id');
    if (!blkId) { alert('No se encontró el ID del bloqueo en la celda.'); return; }

    if (!confirm('¿Eliminar este bloqueo?')) return;

    const res = await $.ajax({
      url: 'api/desbloquear.php',
      method: 'POST',
      dataType: 'json',
      data: { id: blkId }
    });

    if (res.ok) { alert(res.msg); loadGrid(); }
    else { alert(res.msg || 'No se pudo desbloquear.'); }
  });

  // Quitar reserva por N° de Orden (Norden)
  $('#btn-quitar-reserva').on('click', async () => {
    if (!selectedCell) { alert('Primero selecciona una celda.'); return; }
    const estado = (selectedCell.dataset.estado || '').toLowerCase();
    if (estado !== 'reservada') { alert('Solo puedes quitar en celdas reservadas.'); return; }

    // Recolectar chips con Norden
    const chips = Array.from(selectedCell.querySelectorAll('.chip[data-orden-id]'));
    if (chips.length === 0) { alert('No se encontraron IDs de reserva en la celda.'); return; }

    let norden = null;
    if (chips.length === 1) {
      norden = chips[0].getAttribute('data-orden-id');
    } else {
      const opciones = chips.map(ch => {
        const exp = ch.getAttribute('data-expediente') || '';
        const nor = ch.getAttribute('data-orden-id') || '';
        return `Exp ${exp} (Orden ${nor})`;
      }).join('\n');

      const elegido = prompt(`Hay varias reservas en esta celda:\n${opciones}\n\nEscribe el N° de ORDEN (Norden) a quitar:`);
      if (!elegido) return;

      const match = chips.find(ch => ch.getAttribute('data-orden-id') === elegido.trim());
      if (!match) { alert('El N° de orden indicado no corresponde a esta celda.'); return; }
      norden = elegido.trim();
    }

    if (!norden) return;
    if (!confirm(`¿Quitar la reserva (Norden ${norden})?`)) return;

    const res = await $.ajax({
      url: 'api/quitar_reserva.php',
      method: 'POST',
      dataType: 'json',
      data: { norden: norden, hard: 1 } // 0 = anular (recomendado). 1 = DELETE real.
    });

    if (res.ok) { alert(res.msg); loadGrid(); }
    else { alert(res.msg || 'No se pudo quitar la reserva.'); }
  });

  // ====== Eventos globales ======
  $loc.on('change', () => { currentLocalidad = $loc.val(); updateGridTitle(); loadCapillasAndGrid(); });
  $fecha.on('change', () => { updateGridTitle(); loadGrid(); });

  $(function(){ loadLocalidades(); });

})(); // bootWhenReady
</script>
</body>
</html>
