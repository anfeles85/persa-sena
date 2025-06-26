@extends('templates.base')
@section('title', 'Crear Permiso')
@section('header', 'Crear Permiso')
@section('content')
    <div>
        <label class="fs-3">Crear permiso</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('permission.store') }}" method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="permission_date">Fecha Permiso</label>
                        <input type="date" class="form-control" name="permission_date" id="permission_date"
                         required value="{{ old('permission_date') }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="start_time">Hora Inicio</label>
                        <input type="time" class="form-control" name="start_time" id="start_time"
                         required value="{{ old('start_time') }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="end_time">Hora Fin</label>
                        <input type="time" class="form-control" name="end_time" id="end_time"
                         required value="{{ old('end_time') }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="departure_time">Hora Salida</label>
                        <input type="time" class="form-control" name="departure_time" id="departure_time"
                         required value="{{ old('departure_time') }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="reasons">Razon de Salida</label>
                        <input type="text" class="form-control" name="reasons" id="reasons" 
                        required value="{{ old('reasons') }}">
                    </div>
                </div>
                 <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="instructor_id">Instructor</label>
                        <select name="instructor_id" id="instructor_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor['id'] }}" 
                                @if(old('instructor_id') == $instructor['id']) selected @endif>
                                    {{ $instructor['fullname'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="guard_id">Guarda</label>
                        <select name="guard_id" id="guard_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($guards as $guard)
                                <option value="{{ $guard['id'] }}" 
                                @if(old('guard_id') == $guard['id']) selected @endif>
                                    {{ $guard['fullname'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="type">Estado</label>
                        <select name="status" id="status" class="form-control" required value="{{ old('status') }}">
                            @foreach ($status as $status)
                                <option value="{{ $status['value'] }}" @if(old('status') == $status['name']) selected @endif>
                                    {{ $status['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
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
                </div>
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
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
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('permission.index') }}" class="btn btn-secondary w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection
