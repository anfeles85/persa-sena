@extends('templates.base')
@section('title', 'Reportes')
@section('header', 'Reportes')
@section('content')   
   
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reporte permisos por rango de fechas</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.permission_date') }}" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-3">
                                <label for="date1">Fecha de legalización desde:</label>
                            </div>
                            <div class="col-lg-2">                                
                                <input type="date" name="date1" id="date1" class="form-control" required>                                
                            </div>
                            <div class="col-lg-3">
                                <label for="date2">Fecha de legalización hasta:</label>
                            </div>
                            <div class="col-lg-2">
                                <input type="date" name="date2" id="date2" class="form-control" required>                                
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-danger btn-block" title="PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </button>
                            </div>
                        </div>
                    </form>                     
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reporte permisos por aprendiz</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.permission_apprentice') }}" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-2">
                                <label for="apprentice_id">Aprendiz:</label>
                            </div>
                            <div class="col-lg-5">
                            <select name="apprentice_id" id="apprentice_id" class="form-control" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->fullname }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-lg-5">
                                <button type="submit" class="btn btn-danger btn-block col-lg-3" title="PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </button>
                            </div>
                        </div>
                    </form>                     
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reporte permisos por curso</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.permissions_course') }}" method="POST">
                        @csrf
                        <div class="row form-group">
                            <div class="col-lg-2">
                                <label for="course_id">Curso:</label>
                            </div>
                            <div class="col-lg-5">
                            <select name="course_id" id="course_id" class="form-control" required>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->number_group }} - {{ $course->career->name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="col-lg-5">
                                <button type="submit" class="btn btn-danger btn-block col-lg-3" title="PDF">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </button>
                            </div>
                        </div>
                    </form>                     
                </div>
            </div>
        </div>
    </div>

@endsection
