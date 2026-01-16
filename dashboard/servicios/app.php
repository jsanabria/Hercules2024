<?php
// app.php — Contenedor principal de módulos
// Lee parámetros para pasarlos a los módulos
$exp = isset($_GET['exp']) ? (int)$_GET['exp'] : 0;
$username = $_GET['username'] ?? '';
$initialMod = $_GET['mod'] ?? 'asignar-capilla'; // módulo por defecto
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Hércules | Panel principal</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Estilos propios -->
<link rel="stylesheet" href="assets/app.css">

<!-- Bootstrap local -->
<link rel="stylesheet" href="assets/bootstrap-5.3.8-dist/css/bootstrap.min.css">

<!-- jQuery local -->
<script src="assets/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS local (bundle incluye Popper) -->
<script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>

<style>
  /* Que el área central ocupe toda la anchura y alto disponible */
  html, body { height: 100%; }
  body { display: flex; flex-direction: column; }
  #topbar { z-index: 1030; }
  .app-shell { flex: 1 1 auto; display: flex; flex-direction: column; }
  #module-container { flex: 1 1 auto; padding: 0; }

  /* Contenedor AJAX (cuando el módulo devuelve HTML parcial) */
  #ajax-pane { display: none; padding: 1rem; }

  /* Iframe (para páginas completas como index.php) */
  #frame-pane { display: none; border: 0; width: 100%; height: calc(100vh - 56px); }

  /* Estado activo en menú */
  .navbar .nav-link.active { font-weight: 600; border-bottom: 2px solid #0d6efd; }

  /* Loader */
  .module-loader { text-align:center; padding: 2rem 0; color:#6c757d; }
</style>
</head>
<body>

<!-- NAVBAR SUPERIOR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm sticky-top" id="topbar">
  <div class="container-fluid">
    <a href="../../Home" class="navbar-brand d-flex align-items-center gap-2" href="#" data-module="asignar-capilla">
      <img src="../../images/hercules_logo.png" alt="Logo" height="28">
      <span>Hércules | Funeraria Monumental</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav"
      aria-controls="mainNav" aria-expanded="false" aria-label="Mostrar menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0" id="menu-items">
        <!-- Abre otra página (listado general) -->
        <li class="nav-item">
          <a class="nav-link" href="../../ScoExpedienteList">Listar Expedientes</a>
        </li>

        <!-- Módulos que van dentro del app (central) -->
        <li class="nav-item"><a class="nav-link" href="#" data-module="asignar-capilla">Asignar Capilla</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-module="sepelio-cremacion">Sepelio / Cremación</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-module="ataud-cofre">Ataúd / Cofre</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-module="arreglo-floral">Arreglo Floral</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-module="ofr-voz-ofic-r">Ofr. Voz / Ofic. R</a></li>
        <li class="nav-item"><a class="nav-link" href="#" data-module="metodos-pago">Métodos de Pago</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTENEDOR DE LA APP -->
<div class="app-shell">
  <div id="module-container" class="container-fluid">
    <!-- Pane para módulos AJAX -->
    <div id="ajax-pane"></div>
    <!-- Pane para páginas completas (como index.php) -->
    <iframe id="frame-pane" title="Módulo" loading="lazy"></iframe>
  </div>
</div>

<script>
(function mainRouter(){
  if (!window.jQuery) { return setTimeout(mainRouter, 50); }

  // Parámetros iniciales desde PHP
  const EXP = <?php echo json_encode($exp, JSON_UNESCAPED_UNICODE); ?>;
  const USER = <?php echo json_encode($username, JSON_UNESCAPED_UNICODE); ?>;
  const INITIAL = <?php echo json_encode($initialMod, JSON_UNESCAPED_UNICODE); ?>;

  // Mapa de módulos:
  // - type: 'iframe' para páginas completas (ej: index.php)
  // - type: 'ajax'  para HTML parciales
  const MODULES = {
    'asignar-capilla':   { type: 'iframe', url: (p)=> `capillas.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
    'sepelio-cremacion': { type: 'ajax',  url: (p)=> `servicios.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
    'ataud-cofre':       { type: 'ajax',  url: (p)=> `ataud_cofre.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
    'arreglo-floral':    { type: 'ajax',  url: (p)=> `arreglo_floral.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
    'ofr-voz-ofic-r':    { type: 'ajax',  url: (p)=> `voz_reli.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
    'metodos-pago':      { type: 'ajax',  url: (p)=> `metodos_pago.php?exp=${encodeURIComponent(p.exp||0)}&username=${encodeURIComponent(p.user||'')}` },
  };

  const $menu = $('#menu-items');
  const $ajaxPane = $('#ajax-pane');
  const $framePane = $('#frame-pane');

  function setActive(key){
    $menu.find('.nav-link').removeClass('active');
    $menu.find(`.nav-link[data-module="${key}"]`).addClass('active');
  }

  function showLoader(where) {
    const loader = `
      <div class="module-loader">
        <div class="spinner-border" role="status" aria-hidden="true"></div>
        <div class="small mt-2">Cargando…</div>
      </div>`;
    if (where === 'ajax') { $ajaxPane.html(loader); }
    else { /* para iframe no se muestra dentro */ }
  }

  async function loadModule(key, push=true){
    const mod = MODULES[key];
    if (!mod) return;

    setActive(key);

    // Oculta ambos y muestra sólo el que corresponda
    if (mod.type === 'ajax') {
      $framePane.hide().attr('src','about:blank');
      $ajaxPane.show();
      showLoader('ajax');

      try {
        const url = mod.url({ exp: EXP, user: USER });
        const html = await $.ajax({ url, method: 'GET', dataType: 'html' });
        $ajaxPane.html(html);
      } catch (e) {
        console.error(e);
        $ajaxPane.html(`<div class="alert alert-danger">No se pudo cargar el módulo.</div>`);
      }

    } else if (mod.type === 'iframe') {
      $ajaxPane.hide().empty();
      const url = mod.url({ exp: EXP, user: USER });
      $framePane.attr('src', url).show();
    }

    // Actualiza la URL sin recargar
    if (push) {
      const qs = new URLSearchParams(location.search);
      qs.set('mod', key);
      if (EXP) qs.set('exp', EXP);
      if (USER) qs.set('username', USER);
      history.pushState({mod:key}, '', `${location.pathname}?${qs.toString()}`);
    }
  }

  // Clicks del menú
  $(document).on('click', 'a.nav-link[data-module]', function(ev){
    ev.preventDefault();
    const key = $(this).data('module');
    loadModule(key);
  });

  // Soporte back/forward
  window.addEventListener('popstate', function (ev) {
    const key = (ev.state && ev.state.mod) || (new URLSearchParams(location.search).get('mod')) || 'asignar-capilla';
    loadModule(key, false);
  });

  // Carga inicial
  loadModule(INITIAL, false);
})();
</script>

</body>
</html>
