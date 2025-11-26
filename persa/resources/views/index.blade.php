@extends('templates.base')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('styles')
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
    <style>
        /* Small UI tweaks for the dashboard */
        .stat-card .card-header { padding: 1rem; }
        .stat-card .card-body { padding: 1.25rem; display:flex; align-items:center; justify-content:space-between }
        .stat-value { font-size: 1.75rem; font-weight:700; }
        .chart-container { padding: .5rem; }
        .table-top5 td, .table-top5 th { vertical-align: middle; }
        @media (max-width: 767px) {
            .stat-value { font-size: 1.4rem; }
        }
    </style>
@endpush

@section('content')
<main class="main-content position-relative h-auto border-radius-lg">
    <div class="container-fluid py-2">

        {{-- Título --}}
        <div class="mb-4 px-2 text-center text-md-start">
            <br>
            <h3 class="mb-2 h4 font-weight-bolder">Dashboard</h3>
            <p class="mb-0 text-muted">
                En este sitio podrás ver diferentes datos sobre los permisos que existen en el sistema
            </p>
        </div>
{{-- Cards responsivas --}}
        <div class="row g-3 mb-5">
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header p-3 text-white rounded-top"
                         style="background: linear-gradient(240deg, #344767 0%, #071e41 100%);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <p class="text-sm mb-1 fw-semibold">Aprendices registrados</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $apprenticeActives }}</h4>
                            </div>
                            <div class="icon icon-md bg-white text-dark shadow rounded-circle d-flex align-items-center justify-content-center mt-2 mt-md-0">
                                <i class="fa fa-user fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header p-3 text-white rounded-top"
                         style="background: linear-gradient(240deg, #344767 20%, #071e41 100%);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <p class="text-sm mb-1 fw-semibold">Permisos sin aprobar</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $pendingPermissions }}</h4>
                            </div>
                            <div class="icon icon-md bg-white text-dark shadow rounded-circle d-flex align-items-center justify-content-center mt-2 mt-md-0">
                                <i class="fas fa-address-card fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header p-3 text-white rounded-top"
                         style="background: linear-gradient(240deg, #344767 20%, #071e41 100%);">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <p class="text-sm mb-1 fw-semibold">Cursos / Grupos</p>
                                <h4 class="mb-0 fw-bold text-white">{{ $groupsCount ?? 0 }}</h4>
                            </div>
                            <div class="icon icon-md bg-white text-dark shadow rounded-circle d-flex align-items-center justify-content-center mt-2 mt-md-0">
                                <i class="fas fa-layer-group fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    {{-- Gráficas responsivas --}}
    <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Permisos por ubicación</div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:40vh; width:100%; display: flex; justify-content: center; align-items: center;">
                            <canvas id="chart-permisos-programa"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">Permisos por estado</div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:40vh; width:100%; display: flex; justify-content: center; align-items: center;">
                            <canvas id="chart-permisos-estado"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gráfico: Permisos por grupo --}}
        <div class="row mb-4">
            <div class="col-12 col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">Permisos por grupo</div>
                    <div class="card-body">
                        <div class="chart-container" style="position: relative; height:40vh; width:100%">
                            <canvas id="chart-permisos-grupo"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">Top 5 aprendices con mas permisos</div>
                    <div class="card-body">
                        @if(isset($quantityOfpermissionPerson) && $quantityOfpermissionPerson->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-top5 mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Aprendiz</th>
                                            <th class="text-end">Permisos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quantityOfpermissionPerson as $name => $count)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $name }}</td>
                                                <td class="text-end">{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">No hay datos disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart 1
        new Chart(document.getElementById('chart-permisos-programa'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($quantityOfpermissionLocation->keys()->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($quantityOfpermissionLocation->values()->toArray()) !!},
                    backgroundColor: [
                        'rgba(0, 45, 131, 0.8)',
                        'rgba(51, 47, 189, 0.88)',
                        'rgba(44, 135, 75, 0.88)',
                        'rgba(244, 67, 54, 0.7)',
                        'rgba(156, 39, 176, 0.7)'
                    ],
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        // Chart 2
        new Chart(document.getElementById('chart-permisos-estado'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($quantityOfpermissionStatus->keys()->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($quantityOfpermissionStatus->values()->toArray()) !!},
                    backgroundColor: [
                        'rgba(0, 45, 131, 0.8)',
                        'rgba(51, 47, 189, 0.88)',
                        'rgba(44, 135, 75, 0.88)',
                        'rgba(244, 67, 54, 0.7)'
                    ],
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        // Chart: permisos por grupo 
        new Chart(document.getElementById('chart-permisos-grupo'), {
            type: 'bar',
            data: {
                labels: {!! json_encode((isset($quantityOfpermissionGroup) ? $quantityOfpermissionGroup->keys()->toArray() : [])) !!},
                datasets: [{
                    label: 'Número de permisos',
                    data: {!! json_encode((isset($quantityOfpermissionGroup) ? $quantityOfpermissionGroup->values()->toArray() : [])) !!},
                    backgroundColor: 'rgba(153, 102, 255, 0.85)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    y: {
                        ticks: { autoSkip: false }
                    }
                }
            }
        });
    });
</script>