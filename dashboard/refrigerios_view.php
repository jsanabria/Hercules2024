<div class="card shadow-sm p-3 mb-5 bg-white rounded">
    <h5 class="card-title text-primary mb-3">
        <i class="fas fa-calendar-alt"></i> Filtro de Distribución de Refrigerios
    </h5>
    
    <div class="card-body">
        <form id="refrigeriosForm">
            <div class="row g-3 align-items-end">
                
                <div class="col-md-5">
                    <label for="fecha" class="form-label fw-bold">Fecha Desde:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
                </div>
                
                <div class="col-md-5">
                    <label for="fecha2" class="form-label fw-bold">Fecha Hasta:</label>
                    <input type="date" class="form-control" id="fecha2" name="fecha2" required>
                </div>
                
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search me-1"></i> Consultar
                    </button>
                </div>
                
            </div>
        </form>
    </div>
</div>

<div id="result">
    </div>

<script type="text/javascript">
    // Asegúrate de incluir jQuery y Bootstrap Icons (Font Awesome o Bootstrap Icons)
    
    $("#refrigeriosForm").on('submit', function(event) {
        event.preventDefault(); 
        
        const fecha = $("#fecha").val();
        const fecha2 = $("#fecha2").val();
        const resultDiv = $("#result");

        if (!fecha || !fecha2) {
            alert("Seleccione un rango de fechas válido.");
            return;
        }

        // Mostrar un mensaje de carga estilizado
        resultDiv.html('<div class="alert alert-info d-flex align-items-center" role="alert"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Cargando resultados, por favor espere...</div>');

        $.ajax({
            url: "dashboard/refrigerios_consultar.php",
            method: "POST", 
            data: { fecha: fecha, fecha2: fecha2 }
        })
        .done(function(data) {
            resultDiv.html(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            resultDiv.html('<div class="alert alert-danger">Error al cargar la consulta: ' + textStatus + ' - ' + errorThrown + '</div>');
            console.error("AJAX Error:", jqXHR.responseText);
        });
    }); 
</script>