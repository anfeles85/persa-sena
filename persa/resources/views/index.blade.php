@extends('templates.base')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@push('styles')
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <!-- CSS Files -->
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
@endpush

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-2">
            {{-- Dashboard content starts here --}}
            <div class="row">
                <div class="ms-3">
                    <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                    <p class="mb-4">
                        En este sitio podrás ver diferentes datos sobre los permisos que existen en el sistema
                    </p>
                </div>
                <!-- Cards -->
                <div class="row g-4 justify-content-center mb-5">
                    <div class="col-12 col-sm-4">
                        <!-- Card 1 -->
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header p-3 text-white rounded-top" style="background: linear-gradient(240deg, #344767 0%, #071e41 100%);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-sm mb-1 text-capitalize fw-semibold">Programas</p>
                                        <h4 class="mb-0 fw-bold text-white">{{ $careers->count() }}</h4>
                                    </div>
                                    <div class="icon icon-md icon-shape bg-white text-dark text-sm opacity-10 shadow text-center border-radius-lg d-flex align-items-center justify-content-center">
                                        <i class="fas fa-users-viewfinder fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-0 p-3">
                            
                            </div>
                        </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <!-- Card 2 -->
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header p-3 text-white rounded-top" style="background: linear-gradient(240deg, #344767 20%, #071e41 100%);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-sm mb-1 text-capitalize fw-semibold">Total de permisos</p>
                                            <h4 class="mb-0 fw-bold text-white">{{ $permissions->count() }}</h4>
                                        </div>
                                        <div class="icon icon-md icon-shape bg-white text-dark text-sm opacity-10 shadow text-center border-radius-lg d-flex align-items-center justify-content-center">
                                            <i class="fas fa-address-card fa-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-0 p-3">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <!-- Card 3 -->
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header p-3 text-white rounded-top" style="background: linear-gradient(240deg, #344767 20%, #071e41 100%);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="text-sm mb-1 text-capitalize fw-semibold">Usuarios registrados</p>
                                            <h4 class="mb-0 fw-bold text-white">{{ $users->count() }}</h4>
                                        </div>
                                        <div class="icon icon-md icon-shape bg-white text-dark text-sm opacity-10 shadow text-center border-radius-lg d-flex align-items-center justify-content-center">
                                            <i class="fa fa-user fa-lg"></i>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>
                </div>

<div class="row">
    {{-- Chart 1: Permisos por ubicación --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                Permisos por ubicación
            </div>
            <div class="card-body">
                <canvas id="chart-permisos-programa" style="max-height: 350px"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart 2: Permisos por estado --}}
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                Permisos por estado
            </div>
            <div class="card-body">
                <canvas id="chart-permisos-estado" style="max-height: 350px"></canvas>
            </div>
        </div>
    </div>
</div>




               </div>
                </a>
            </div>
        </div>
    </main>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart 1: Permisos por ubicación
        var ctx1 = document.getElementById('chart-permisos-programa').getContext('2d');
var labels1 = {!! json_encode($quantityOfpermissionLocation->keys()->toArray()) !!};
var data1 = {!! json_encode($quantityOfpermissionLocation->values()->toArray()) !!};
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: labels1,
                datasets: [{
                    label: 'Permisos',
                    data: data1,
                    backgroundColor: [
                        'rgba(0, 45, 131, 0.8)',
                        'rgba(51, 47, 189, 0.88)',
                        'rgba(44, 135, 75, 0.88)',
                        'rgba(244, 67, 54, 0.7)',
                        'rgba(156, 39, 176, 0.7)'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Chart 2: Permisos por estado
        var ctx2 = document.getElementById('chart-permisos-estado').getContext('2d');
var labels2 = {!! json_encode($quantityOfpermissionStatus->keys()->toArray()) !!};
var data2 = {!! json_encode($quantityOfpermissionStatus->values()->toArray()) !!};
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: labels2,
                datasets: [{
                    label: 'Permisos',
                    data: data2,
                    backgroundColor: [
                        'rgba(0, 45, 131, 0.8)',
                        'rgba(51, 47, 189, 0.88)',
                        'rgba(44, 135, 75, 0.88)',
                        'rgba(244, 67, 54, 0.7)'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>