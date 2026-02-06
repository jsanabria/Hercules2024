<?php

namespace PHPMaker2024\hercules;

// Page object
$Home = &$Page;
?>
<?php
$Page->showMessage();
?>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }
        .button-area {
            margin-bottom: 30px; /* Espacio debajo de los botones */
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* Espacio entre los botones */
        }
        .button-area .btn {
            flex-grow: 1; /* Para que los botones se distribuyan */
        }
        /* Media queries para ajustar el tamaño de los botones en pantallas pequeñas */
        @media (min-width: 768px) {
            .button-area .btn {
                flex-grow: 0;
                width: calc((100% - 50px) / 6); /* Para 6 botones por fila, ajusta el 50px según el gap total */
            }
        }

        /* ----- */
        .btn-custom-panel {
            background-color: #f0f4f8; /* Fondo gris azulado muy claro */
            border: 1px solid #d1d9e6; /* Borde sutil */
            color: #334e68; /* Color de texto profesional */
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 3px 3px 6px #b8b9be, -3px -3px 6px #ffffff; /* Efecto Neumorfismo suave */
            text-decoration: none;
            height: 100%;
        }

        .btn-custom-panel:hover {
            background-color: #e2e8f0;
            color: #007bff;
            transform: translateY(-2px);
            box-shadow: 2px 2px 4px #b8b9be, -2px -2px 4px #ffffff;
        }

        .btn-custom-panel i {
            font-size: 1.2rem;
            margin-right: 10px;
            color: #627d98; /* Icono un poco más tenue que el texto */
        }

        /* Colores de bordes izquierdo para diferenciar como en la imagen */
        .border-left-primary { border-left: 4px solid #007bff !important; }
        .border-left-success { border-left: 4px solid #28a745 !important; }
        .border-left-warning { border-left: 4px solid #ffc107 !important; }
        .border-left-danger  { border-left: 4px solid #dc3545 !important; }
        .border-left-info    { border-left: 4px solid #17a2b8 !important; }

        /* Espaciado entre letras para el subtítulo */
        .tracking-wider {
            letter-spacing: 1px;
            font-size: 0.7rem;
        }

        /* Asegurar que todos los botones de la fila tengan la misma altura */
        .btn-custom-panel {
            min-height: 55px; /* Altura mínima uniforme */
            justify-content: flex-start; /* Alinea contenido a la izquierda */
        }

        /* Efecto hover más elegante */
        .btn-custom-panel:hover {
            background-color: #f8f9fa;
            border-color: #adb5bd;
            transform: scale(1.02); /* Crece un poquito en lugar de solo moverse */
        }

        /* Iconos un poco más grandes para que se vean como en la imagen */
        .btn-custom-panel i {
            font-size: 1.3rem;
        }

    </style>
    
    <div class="lead-container bg-white p-4 rounded shadow-sm border">
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div>
                <h4 class="mb-0 fw-bold text-primary">HERCULES</h4>
                <span class="text-muted small text-uppercase tracking-wider">Sistema de Control de Operaciones Funerarias</span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="text-end me-2">
                    <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: bold;">TASA BCV</small>
                    <span id="tasaBCV" class="badge bg-light text-dark border shadow-sm" style="font-size: 0.75rem;">
                        <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                    </span>
                </div>

                <div style="min-width: 220px;"> 
                    <a href="ScoExpedienteAdd?showdetail=" class="btn-custom-panel border-left-primary-dark shadow-sm py-2">
                        <i class="bi bi-plus-circle-fill text-primary"></i>
                        <span>Apertura Expediente</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-3"> 
            <div class="col-6 col-md-4 col-lg-2">
                <a href="Disponibilidad" class="btn-custom-panel border-left-success h-100">
                    <i class="bi bi-calendar-check"></i>
                    <span>Disponibilidad</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="dashboard/MonitorServicios.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn-custom-panel border-left-warning h-100">
                    <i class="bi bi-display"></i>
                    <span>Monitor</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="dashboard/PizarraServicios.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn-custom-panel border-left-primary h-100">
                    <i class="bi bi-clipboard-data"></i>
                    <span>Pizarra</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="dashboard/PizarraCremaciones.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn-custom-panel border-left-danger h-100">
                    <i class="bi bi-fire"></i>
                    <span>Cremaciones</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="dashboard/PizarraInhumaciones.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn-custom-panel border-left-info h-100">
                    <i class="bi bi-archive"></i>
                    <span>Inhumaciones</span>
                </a>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <a href="dashboard/PizarraCremacionMascota.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn-custom-panel border-left-secondary h-100">
                    <i class="bi bi-heart-pulse"></i>
                    <span>Mascotas</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-4">
            <div class="card border-success">
                <div class="card-header bg-success d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-lightbulb"></i> ACUMULADO POR SERVICIOS</span>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-light" onclick="cambiarMes(1)"><i class="bi bi-chevron-left"></i></button>
                        <button class="btn btn-outline-light" id="btnSiguiente" onclick="cambiarMes(-1)"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <a href="ListarServicios" target="_blank" class="text-decoration-none">
                                <div class="p-3 bg-white border rounded shadow-sm">
                                    <h1 class="display-4 fw-bold text-success" id="accTotal">0</h1>
                                    <small class="text-muted text-uppercase">Total Acumulado</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2 border rounded bg-white">
                                <h4 class="text-danger fw-bold" id="accMesAnterior">0</h4>
                                <small class="text-muted" id="lblMesAnterior">Anterior</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2 border rounded bg-white">
                                <h4 class="text-info fw-bold" id="accPromedio">0</h4>
                                <small class="text-muted">P. Diario</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-2 border rounded bg-white">
                                <h4 class="text-success fw-bold" id="accMesActual">0</h4>
                                <small class="text-muted" id="lblMesActual">Actual</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm border-dark h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-badge me-2"></i>Usuarios en Línea</span>
                    <span class="badge bg-success" id="countActivos">0</span>
                </div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <ul class="list-group list-group-flush" id="listaUsuariosActivos">
                        <li class="list-group-item text-center py-3">
                            <div class="spinner-border spinner-border-sm text-secondary" role="status"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-5">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-activity me-2"></i>Causas de Fallecimiento (Últimos 7 Días)</span>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Día / Fecha</th>
                                <th>Causa</th>
                                <th class="text-center">Cant.</th>
                            </tr>
                        </thead>
                        <tbody id="tablaCausas">
                            <tr>
                                <td colspan="3" class="text-center py-4">
                                    <div class="spinner-border spinner-border-sm text-warning" role="status"></div>
                                    Cargando estadísticas...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<hr>

    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar-check me-2"></i>Expedientes por Día (Últimos 7 días)</span>
                    <span class="badge bg-light text-primary">Expedientes</span>
                </div>
                <div class="card-body p-0"> <ul class="list-group list-group-flush" id="listaExpedientes">
                        <li class="list-group-item text-center py-4">
                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                            Cargando expedientes...
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-3"> 
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-archive me-2"></i>Inhumados Diarios (Últimos 7 días)</span>
                    <span class="badge bg-light text-info">Inhumaciones</span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="listaInhumados">
                        <li class="list-group-item text-center py-4">
                            <div class="spinner-border spinner-border-sm text-info" role="status"></div>
                            Cargando datos...
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-3"> 
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-fire me-2"></i>Cremados Diarios (Últimos 7 días)</span>
                    <span class="badge bg-light text-danger">Cremaciones</span>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="listaCremados">
                        <li class="list-group-item text-center py-4">
                            <div class="spinner-border spinner-border-sm text-danger" role="status"></div>
                            Cargando datos...
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-info-circle me-2"></i>Estatus Operativo de Servicios (Actual)
                </div>
                <div class="card-body">
                    <div id="contenedorEstatus" class="d-flex flex-wrap gap-2 justify-content-center">
                        <div class="spinner-border text-secondary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Ventas del Mes
                </div>
                <div class="card-body">
                    <h3 class="card-title text-primary">$ <span id="ventasMes">Cargando...</span></h3>
                    <p class="card-text">Total de ventas en el mes actual.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Nuevos Clientes
                </div>
                <div class="card-body">
                    <h3 class="card-title text-success"><span id="nuevosClientes">Cargando...</span></h3>
                    <p class="card-text">Número de clientes nuevos este mes.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Tasa de Conversión
                </div>
                <div class="card-body">
                    <h3 class="card-title text-warning"><span id="tasaConversion">Cargando...</span>%</h3>
                    <p class="card-text">Porcentaje de visitantes a clientes.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    Tasa B.C.V.
                </div>
                <div class="card-body">
                    <h3 class="card-title text-info"><span id="tasaBCV">Cargando...</span></h3>
                    <p class="card-text"><span id="fechaBCV">Cargando...</span></p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Ventas Anuales
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ventasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Clientes por Fuente
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="clientesFuenteChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        function cargarDatosDashboard() {
            fetch('dashboard/includes/data_indicadores.php')
                .then(response => response.json())
                .then(data => {
                    // --- ACTUALIZACIÓN SEGURA DE INDICADORES ---
                    
                    // Tasa Conversión (La que pediste activar)
                    const elTasaConv = document.getElementById("tasaConversion");
                    if (elTasaConv && data.indicadores) {
                        elTasaConv.innerText = data.indicadores.tasaConversion;
                    }

                    // Tasa BCV y Fecha (Solo si existen)
                    const elTasaBCV = document.getElementById("tasaBCV");
                    const elFechaBCV = document.getElementById("fechaBCV");
                    if (elTasaBCV && data.tasaBCV && data.tasaBCV[0]) {
                        elTasaBCV.innerText = " Bs. " + data.tasaBCV[0].tasa + " por 1 " + data.tasaBCV[0].moneda + " Fecha: " + data.tasaBCV[0].fecha;
                    }
                    if (elFechaBCV && data.tasaBCV && data.tasaBCV[0]) {
                        elFechaBCV.innerText = "Fecha valor: " + data.tasaBCV[0].fecha;
                    }

                    // --- LISTADOS (EXPEDIENTES, INHUMADOS, CREMADOS) ---
                    
                    const actualizarLista = (id, items, colorClass) => {
                        const lista = document.getElementById(id);
                        if (!lista) return;
                        lista.innerHTML = "";
                        if (items && items.length > 0) {
                            items.forEach(item => {
                                const li = document.createElement("li");
                                li.className = "list-group-item d-flex justify-content-between align-items-center";
                                li.innerHTML = `<span>${item.etiqueta}</span><span class="badge ${colorClass} rounded-pill">${item.cantidad}</span>`;
                                lista.appendChild(li);
                            });
                        } else {
                            lista.innerHTML = `<li class="list-group-item text-muted text-center">Sin registros</li>`;
                        }
                    };

                    actualizarLista("listaExpedientes", data.expedientesPorDia, "bg-success");
                    actualizarLista("listaInhumados", data.expedientesInhumados, "bg-info text-dark");
                    actualizarLista("listaCremados", data.expedientesCremados, "bg-danger");

                    // --- TABLA DE CAUSAS ---
                    const tablaCausas = document.getElementById("tablaCausas");
                    if (tablaCausas) {
                        tablaCausas.innerHTML = "";
                        if (data.causasFallecimiento && data.causasFallecimiento.length > 0) {
                            data.causasFallecimiento.forEach(item => {
                                const tr = document.createElement("tr");
                                tr.innerHTML = `<td class="small fw-bold">${item.dia}</td><td class="small">${item.causa}</td><td class="text-center"><span class="badge bg-warning text-dark rounded-pill">${item.cantidad}</span></td>`;
                                tablaCausas.appendChild(tr);
                            });
                        } else {
                            tablaCausas.innerHTML = `<tr><td colspan="3" class="text-center text-muted">No hay datos</td></tr>`;
                        }
                    }

                    // --- ESTATUS OPERATIVO ---
                    const contenedor = document.getElementById("contenedorEstatus");
                    if (contenedor) {
                        contenedor.innerHTML = "";
                        if (data.estatusServicios && data.estatusServicios.length > 0) {
                            data.estatusServicios.forEach(item => {
                                const badge = document.createElement("a");
                                badge.href = `ViewExpedienteServicioList?estatusname=${item.nombre}`;
                                badge.target = "_blank";
                                badge.className = "btn btn-sm shadow-sm fw-bold d-flex align-items-center";
                                badge.style.cssText = `font-size: 0.75rem; background-color: ${item.color}; color: ${item.textColor}; border-radius: 20px; padding: 8px 15px;`;
                                badge.innerHTML = `${item.nombre} <span class="badge bg-light text-dark ms-2" style="opacity: 0.9">${item.cantidad}</span>`;
                                contenedor.appendChild(badge);
                            });
                        }
                    }

                    // --- LÓGICA PARA USUARIOS ACTIVOS ---
                    const listaU = document.getElementById("listaUsuariosActivos");
                    const countU = document.getElementById("countActivos");

                    if (listaU && data.usuariosActivos) {
                        listaU.innerHTML = "";
                        countU.innerText = data.usuariosActivos.length;
                        
                        if (data.usuariosActivos.length > 0) {
                            data.usuariosActivos.forEach(user => {
                                listaU.innerHTML += `
                                    <li class="list-group-item d-flex align-items-center py-2">
                                        <div class="position-relative me-3">
                                            <i class="bi bi-person-circle fs-4 text-secondary"></i>
                                            <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-light rounded-circle"></span>
                                        </div>
                                        <div class="overflow-hidden">
                                            <div class="fw-bold small text-truncate">${user.nombre}</div>
                                            <div class="text-muted" style="font-size: 0.65rem;">
                                                En: ${user.ubicacion} • hace ${user.hace} min.
                                            </div>
                                        </div>
                                    </li>`;
                            });
                        } else {
                            listaU.innerHTML = `<li class="list-group-item text-muted text-center small py-3">No hay usuarios activos</li>`;
                        }
                    }

                    // --- GRÁFICOS (PROTEGIDOS) ---
                    // Solo se ejecutan si los Canvas existen en el HTML
                    const canvasVentas = document.getElementById('ventasChart');
                    if (canvasVentas) {
                        new Chart(canvasVentas.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: data.ventasAnuales.labels,
                                datasets: [{ label: 'Ventas ($)', data: data.ventasAnuales.data, borderColor: 'rgb(75, 192, 192)', tension: 0.1 }]
                            },
                            options: { responsive: true, maintainAspectRatio: false }
                        });
                    }

                    const canvasFuente = document.getElementById('clientesFuenteChart');
                    if (canvasFuente) {
                        new Chart(canvasFuente.getContext('2d'), {
                            type: 'pie',
                            data: {
                                labels: data.clientesPorFuente.labels,
                                datasets: [{ data: data.clientesPorFuente.data, backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0'] }]
                            },
                            options: { responsive: true, maintainAspectRatio: false }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los datos del dashboard:', error);
                    // Ya no intentamos escribir en IDs fijos aquí para evitar más errores
                });
        }

        let mesOffset = 0;

        function cargarAcumulado(offset) {
            // 1. Elementos que vamos a manipular
            const totalElem = document.getElementById("accTotal");
            const btnSiguiente = document.getElementById("btnSiguiente");
            
            // 2. Mostrar indicador de progreso (Spinner de Bootstrap)
            // Guardamos el contenido original por si acaso, o simplemente ponemos el spinner
            totalElem.innerHTML = `<div class="spinner-border spinner-border-sm text-success" role="status"></div>`;
            
            // Opcional: Deshabilitar botones mientras carga para evitar colisiones
            btnSiguiente.disabled = true;

            fetch(`dashboard/includes/data_acumulado.php?xmes=${offset}`)
                .then(response => response.json())
                .then(data => {
                    // 3. Renderizar los datos (esto elimina el spinner automáticamente al usar innerText)
                    totalElem.innerText = data.total;
                    document.getElementById("accMesAnterior").innerText = data.mesAnteriorCant;
                    document.getElementById("lblMesAnterior").innerText = data.mesAnteriorNombre;
                    document.getElementById("accPromedio").innerText = data.promedio;
                    document.getElementById("accMesActual").innerText = data.mesActualCant;
                    document.getElementById("lblMesActual").innerText = data.mesActualNombre;
                    
                    // 4. Lógica de habilitación del botón
                    btnSiguiente.disabled = (offset <= 0);
                })
                .catch(error => {
                    console.error('Error:', error);
                    totalElem.innerText = "!"; // Indicador de error visual
                    btnSiguiente.disabled = (offset <= 0);
                });
        }

        function cambiarMes(valor) {
            mesOffset += valor;
            if (mesOffset < 0) mesOffset = 0;
            cargarAcumulado(mesOffset);
        }

        // Llama a la función al cargar la página
        document.addEventListener("DOMContentLoaded", function() {
            cargarDatosDashboard(); // Tu función original
            cargarAcumulado(0);     // La nueva función
        });
    </script>
<?= GetDebugMessage() ?>
