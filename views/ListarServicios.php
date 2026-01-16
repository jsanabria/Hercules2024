<?php

namespace PHPMaker2024\hercules;

// Page object
$ListarServicios = &$Page;
?>
<?php
$Page->showMessage();
?>
<h2>Listar Expedientes</h2>
<div class="container">
  <form class="row row-cols-lg-auto g-3 align-items-center">
    <div class="col-12">
      <label for="fecha_desde" class="form-label visually-hidden">Fecha Registro Desde:</label>
      <div class="input-group">
        <span class="input-group-text">Fecha Registro:</span>
        <input type="date" class="form-control form-control-sm" id="fecha_desde" name="fecha_desde">
      </div>
    </div>

    <div class="col-12">
      <label for="fecha_hasta" class="form-label visually-hidden">Fecha Registro Hasta:</label>
      <div class="input-group">
        <span class="input-group-text">y</span>
        <input type="date" class="form-control form-control-sm" id="fecha_hasta" name="fecha_hasta">
      </div>
    </div>

    <div class="col-12">
      <button type="button" class="btn btn-primary btn-sm" id="buscar" name="buscar">Buscar Registros</button>
    </div>
  </form>
</div>

<div class="container mt-4">
  <div id="result">
  </div>
</div>

<script type="text/javascript">
  // El código JavaScript no necesita cambios, ya que depende de los IDs de los elementos
  $("#buscar").click(function(){
    var fecha_desde = $("#fecha_desde").val();
    var fecha_hasta = $("#fecha_hasta").val();

    if(fecha_desde == "" || fecha_hasta == "") {
      alert("Fecha no correctas");
      return false;
    }
    $.ajax({
      url : "dashboard/listar_servicios_buscar.php",
      type: "POST",
      data : {fecha_desde: fecha_desde, fecha_hasta: fecha_hasta},
      beforeSend: function(){
        $("#result").html("Espere. . . ");
      }
    })
    .done(function(data) {
      $("#result").html(data);
    })
    .fail(function(data) {
      alert( "error" + data );
    })
    .always(function(data) {
      // Código opcional de 'always'
    });
  }); 
</script>
<?= GetDebugMessage() ?>
