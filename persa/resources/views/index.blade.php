@extends('templates.base')
@section('title', 'Inicio')
@section('header', 'Inicio')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-4">
        <p class="mb-4" align="justify">
            PERSA es un aplicativo para la administración de permisos y salidas de los aprendices.
            En él podrá gestionar los siguientes módulos:
        </p>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-folder fa-2x mb-2 text-success"></i>
                        <h5 class="card-title">Permisos</h5>
                        <p class="card-text">Administración de permisos de salida.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-folder-open fa-2x mb-2 text-warning"></i>
                        <h5 class="card-title">Tipo de permisos</h5>
                        <p class="card-text">Tipos y categorías de permisos.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-users-viewfinder fa-2x mb-2 text-danger"></i>
                        <h5 class="card-title">Fichas</h5>
                        <p class="card-text">Gestión de fichas académicas.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-building fa-2x mb-2 text-secondary"></i>
                        <h5 class="card-title">Sedes</h5>
                        <p class="card-text">Administración de sedes.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-book fa-2x mb-2 text-info"></i>
                        <h5 class="card-title">Programa</h5>
                        <p class="card-text">Administración de los Programas de formación.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection