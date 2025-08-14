
@extends('templates.base')
@section('title', 'Buscar aprendiz')
@section('header', 'Buscar aprendiz')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="">
                    <div class=" text-white">
                        <h5 class="fs-3"><i class="fas fa-search me-2"></i>Buscar Aprendices por Ficha</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('apprentice.index') }}" method="GET" id="searchForm">
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="fas fa-users me-1"></i>Seleccionar Ficha
                                        </label>
                                        <select class="form-control form-select" name="course_id" id="course_select" onchange="this.form.submit()">
                                            <option value="">-- Seleccione una ficha --</option>
                                            @if(isset($courses) && $courses->count() > 0)
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" 
                                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                        Ficha {{ $course->number_group }} - {{ $course->career->name }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>No hay fichas disponibles</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <button type="submit" class="btn btn-primary me-2">
                                            <i class="fas fa-search me-1"></i>Buscar
                                        </button>
                                        <a href="{{ route('apprentice.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i>Limpiar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resultados de la búsqueda -->
        @if(request('course_id'))
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Aprendices Encontrados
                                @if(isset($courses))
                                    @php
                                        $selectedCourse = $courses->where('id', request('course_id'))->first();
                                    @endphp
                                    @if($selectedCourse)
                                        - Ficha {{ $selectedCourse->number_group }}
                                    @endif
                                @endif
                            </h5>
                            @if(isset($apprentices) && $apprentices->count() > 0)
                                <span class="badge bg-light text-dark fs-6">
                                    Total: {{ $apprentices->count() }} aprendices
                                </span>
                            @endif
                        </div>
                        <div class="card-body">
                            @if(isset($apprentices) && $apprentices->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">
                                                    <i class="fas fa-id-card me-1"></i>Documento
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-user me-1"></i>Nombre Completo
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-envelope me-1"></i>Correo Electrónico
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-graduation-cap me-1"></i>Programa
                                                </th>
                                                <th scope="col">
                                                    <i class="fas fa-circle me-1"></i>Estado
                                                </th>
                                                <th scope="col" class="text-center">
                                                    <i class="fas fa-cogs me-1"></i>Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($apprentices as $apprentice)
                                                <tr>
                                                    <td class="fw-bold">{{ $apprentice->document }}</td>
                                                    <td>{{ $apprentice->fullname }}</td>
                                                    <td>
                                                        <a href="mailto:{{ $apprentice->email }}" class="text-decoration-none">
                                                            {{ $apprentice->email }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($apprentice->courses->isNotEmpty())
                                                            <small class="text-muted">
                                                                {{ $apprentice->courses->first()->career->name ?? 'N/A' }}
                                                            </small>
                                                        @else
                                                            <span class="text-muted">Sin programa asignado</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($apprentice->status == 'ACTIVO')
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle me-1"></i>Activo
                                                            </span>
                                                        @else
                                                            <span class="badge bg-danger">
                                                                <i class="fas fa-times-circle me-1"></i>Inactivo
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="#" class="btn btn-sm btn-outline-info" title="Ver detalles">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-sm btn-outline-primary" title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-outline-warning" title="Permisos">
                                                                <i class="fas fa-key"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No se encontraron aprendices</h5>
                                    <p class="text-muted">
                                        No hay aprendices registrados en esta ficha o la ficha no tiene aprendices asignados.
                                    </p>
                                    <a href="{{ route('apprentice.index') }}" class="btn btn-primary">
                                        <i class="fas fa-arrow-left me-1"></i>Seleccionar otra ficha
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Mensaje cuando no se ha seleccionado ninguna ficha -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow border-0">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-search fa-4x text-primary mb-4"></i>
                            <h4 class="text-muted mb-3">Buscar Aprendices</h4>
                            <p class="text-muted mb-4">
                                Selecciona una ficha del menú desplegable para ver todos los aprendices registrados en esa ficha.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection