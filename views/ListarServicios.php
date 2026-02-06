<?php

namespace PHPMaker2024\hercules;

// Page object
$ListarServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<div class="container mt-3">
  <form id="formBuscarServicios" class="row row-cols-lg-auto g-3 align-items-center bg-light p-3 rounded border">
    <div class="col-12">
      <div class="input-group">
        <span class="input-group-text bg-primary text-white">Fecha Registro:</span>
        <input type="date" class="form-control form-control-sm" id="fecha_desde" name="fecha_desde">
      </div>
    </div>

    <div class="col-12">
      <div class="input-group">
        <span class="input-group-text">hasta</span>
        <input type="date" class="form-control form-control-sm" id="fecha_hasta" name="fecha_hasta">
      </div>
    </div>

    <div class="col-12">
      <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" id="buscar">
        <i class="bi bi-search me-2"></i> <span id="btnText">Buscar Registros</span>
        <div id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></div>
      </button>
    </div>
  </form>
</div>

<div class="container mt-4">
  <div id="result">
    </div>
</div>

<script type="text/javascript">
  $("#buscar").click(function() {
    // Referencias a elementos para evitar buscarlos varias veces
    var btn = $(this);
    var btnText = $("#btnText");
    var btnSpinner = $("#btnSpinner");
    var resultDiv = $("#result");
    
    var fecha_desde = $("#fecha_desde").val();
    var fecha_hasta = $("#fecha_hasta").val();

    // Validación básica
    if (fecha_desde == "" || fecha_hasta == "") {
      alert("Por favor, seleccione ambas fechas.");
      return false;
    }

    $.ajax({
      url: "dashboard/listar_servicios_buscar.php",
      type: "POST",
      data: { fecha_desde: fecha_desde, fecha_hasta: fecha_hasta },
      beforeSend: function() {
        // 1. Efecto visual en el botón
        btn.prop("disabled", true); // Deshabilitar clic
        btnText.text("Buscando..."); // Cambiar texto
        btnSpinner.removeClass("d-none"); // Mostrar spinner
        
        // 2. Efecto visual en el contenedor de resultados
        resultDiv.css("opacity", "0.5");
        resultDiv.html(`
          <div class="text-center my-5">
            <div class="spinner-grow text-primary" role="status"></div>
            <p class="mt-2 text-muted">Consultando base de datos, por favor espere...</p>
          </div>
        `);
      }
    })
    .done(function(data) {
      resultDiv.html(data);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
      resultDiv.html(`
        <div class="alert alert-danger">
          Error en la consulta: ${textStatus} - ${errorThrown}
        </div>
      `);
    })
    .always(function() {
      // Restaurar estado original
      btn.prop("disabled", false);
      btnText.text("Buscar Registros");
      btnSpinner.addClass("d-none");
      resultDiv.css("opacity", "1");
    });
  });
</script>
<?= GetDebugMessage() ?>
