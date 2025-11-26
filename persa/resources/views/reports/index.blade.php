@extends('templates.base')
@section('title', 'Reportes')
@section('header', 'Reportes')
@section('content')   

<label class="fs-2 mb-4">Reportes</label>

{{-- Reporte por rango de fechas --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-calendar-alt me-2"></i>Reporte permisos por rango de fechas
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.permission_date') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-6 col-lg-5">
                            <label for="date1" class="form-label">Fecha desde:</label>
                            <input type="date" 
                                   name="date1" 
                                   id="date1" 
                                   class="form-control" 
                                   required>                                
                        </div>
                        <div class="col-12 col-md-6 col-lg-5">
                            <label for="date2" class="form-label">Fecha hasta:</label>
                            <input type="date" 
                                   name="date2" 
                                   id="date2" 
                                   class="form-control" 
                                   required>                                
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" 
                                    class="btn btn-danger w-100" 
                                    title="Generar PDF">
                                <i class="fa-solid fa-file-pdf me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </form>                     
            </div>
        </div>
    </div>
</div>

{{-- Reporte por aprendiz --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-graduate me-2"></i>Reporte permisos por aprendiz
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.permission_apprentice') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-lg-10">
                            <label for="apprentice_id" class="form-label">Seleccione un aprendiz:</label>
                            <select name="apprentice_id" 
                                    id="apprentice_id" 
                                    class="form-control select2-apprentice" 
                                    required>
                                <option value="">Buscar por nombre o documento...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->document }} - {{ $user->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" 
                                    class="btn btn-danger w-100" 
                                    title="Generar PDF">
                                <i class="fa-solid fa-file-pdf me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </form>                     
            </div>
        </div>
    </div>
</div>

{{-- Reporte por curso --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users me-2"></i>Reporte permisos por curso
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.permissions_course') }}" method="POST">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-lg-10">
                            <label for="course_id" class="form-label">Seleccione una ficha:</label>
                            <select name="course_id" 
                                    id="course_id" 
                                    class="form-control select2-course" 
                                    required>
                                <option value="">Buscar por número de ficha o programa...</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" 
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->number_group }} - {{ $course->career->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" 
                                    class="btn btn-danger w-100" 
                                    title="Generar PDF">
                                <i class="fa-solid fa-file-pdf me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </form>                     
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-apprentice').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar por nombre o documento...',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            }
        });

        $('.select2-course').select2({
            theme: 'bootstrap-5',
            placeholder: 'Buscar por número de ficha o programa...',
            allowClear: true,
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                },
                searching: function() {
                    return "Buscando...";
                }
            }
        });
    });
</script>
@endsection