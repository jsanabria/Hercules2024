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
    </style>
    <!--<h1 class="mt-4">HERCULES - Sistema de Control de Operaciones Funerarias</h1>-->
    <p class="lead">Sistema de Control de Operaciones Funerarias. <b><small>Sistema H&eacute;rcules</small></b> <a href="ScoExpedienteAdd?showdetail=" class="btn btn-primary">Apertura Expediente</a> </p>

    <div class="button-area">
        <a href="Disponibilidad" class="btn btn-success">Disponibilidad</a>
        <a href="dashboard/MonitorServicios.php" target="_blank" class="btn btn-warning">Monitor</a>
        <a href="dashboard/PizarraServicios.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn btn-primary">Pizarra</a>
        <a href="dashboard/PizarraCremaciones.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn btn-danger">Cremaciones</a>
        <a href="dashboard/PizarraInhumaciones.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn btn-info">Inhumaciones</a>
        <a href="dashboard/PizarraCremacionMascota.php?username=<?= CurrentUserName() ?>" target="_blank" class="btn btn-secondary">Mascotas</a>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Función para cargar datos desde PHP
            function cargarDatosDashboard() {
                fetch('dashboard/includes/data_indicadores.php') // Ruta a tu script PHP que devuelve JSON
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar los indicadores
                        document.getElementById("ventasMes").innerText = data.indicadores.ventasMes;
                        document.getElementById("nuevosClientes").innerText = data.indicadores.nuevosClientes;
                        document.getElementById("tasaConversion").innerText = data.indicadores.tasaConversion;
                        document.getElementById("tasaBCV").innerText = " Bs. " + data.tasaBCV[0].tasa + " por 1 " + data.tasaBCV[0].moneda;
                        document.getElementById("fechaBCV").innerText = "Fecha valor: " + data.tasaBCV[0].fecha;

                        // Actualizar los gráficos
                        // Ventas Anuales
                        const ventasCtx = document.getElementById('ventasChart').getContext('2d');
                        new Chart(ventasCtx, {
                            type: 'line',
                            data: {
                                labels: data.ventasAnuales.labels,
                                datasets: [{
                                    label: 'Ventas ($)',
                                    data: data.ventasAnuales.data,
                                    borderColor: 'rgb(75, 192, 192)',
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });

                        // Clientes por Fuente
                        const clientesCtx = document.getElementById('clientesFuenteChart').getContext('2d');
                        new Chart(clientesCtx, {
                            type: 'pie',
                            data: {
                                labels: data.clientesPorFuente.labels,
                                datasets: [{
                                    label: 'Clientes',
                                    data: data.clientesPorFuente.data,
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgb(255, 205, 86)',
                                        'rgb(75, 192, 192)'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar los datos del dashboard:', error);
                        // Manejar el error, por ejemplo, mostrando un mensaje al usuario
                        document.getElementById("ventasMes").innerText = "Error";
                        document.getElementById("nuevosClientes").innerText = "Error";
                        document.getElementById("tasaConversion").innerText = "Error";
                        document.getElementById("tasaBCV").innerText = "Error";
                    });
            }

            // Llamar a la función para cargar los datos al cargar la página
            cargarDatosDashboard();
        });
    </script>
<?= GetDebugMessage() ?>
