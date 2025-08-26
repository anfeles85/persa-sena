@extends('templates.base')
@section('title', 'Crear Permiso')
@section('header', 'Crear Permiso')
@section('content')
    <div>
        <label class="fs-3">Crear permiso</label>
        <div class="col-12 mb-4">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="permission_date">Fecha Permiso</label>
                        <input type="date" class="form-control" name="permission_date" id="permission_date"
                        required value="{{ old('permission_date', date('Y-m-d')) }}" readonly>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="start_time">Hora Inicio</label>
                        <input type="time" class="form-control" name="start_time" id="start_time"
                         required value="{{ old('start_time') }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="end_time">Hora Fin</label>
                        <input type="time" class="form-control" name="end_time" id="end_time"
                         required value="{{ old('end_time') }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="reasons">Razón de Salida</label>
                        <input type="text" class="form-control" name="reasons" id="reasons" 
                        required value="{{ old('reasons') }}">
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="location_id">Lugar</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location['id'] }}" 
                                @if(old('location_id') == $location['id']) selected @endif>
                                    {{ $location['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <label for="permission_type_id">Tipo de Permiso</label>
                        <select name="permission_type_id" id="permission_type_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($permissionTypes as $permission_type)
                                <option value="{{ $permission_type['id'] }}" 
                                @if(old('permission_type_id') == $permission_type['id']) selected @endif>
                                    {{ $permission_type['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2 flex-column flex-md-row">
                        <button type="submit" class="btn btn-success w-100 w-md-50">Guardar</button>
                        <a href="{{ route('permission.index') }}" class="btn btn-danger w-100 w-md-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
