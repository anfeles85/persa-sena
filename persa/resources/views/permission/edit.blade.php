@extends('templates.base')
@section('title', 'Editar Permiso')
@section('header', 'Editar Permiso')
@section('content')

    <div>
        <label class="fs-3">Editar Permiso</label>
        <div class="col-lg-12-mb-4">
            <form action="{{ route('permission.update', $permission['id']) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="permission_date">Fecha de permiso</label>
                        <input type="date" class="form-control" id="permission_date" name="permission_date" required value="{{ $permission['permission_date'] }}"readonly>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="start_time">Hora de inicio</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required value="{{ $permission['start_time'] }}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="end_time">Hora de fin</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required value="{{ $permission['end_time'] }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                            <label for="reasons">Razón de salida</label>
                            <input type="text" class="form-control" name="reasons" id="reasons" required 
                            value="{{ $permission['reasons'] }}">
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="location_id">Lugar</label>
                        <select name="location_id" id="location_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location['id'] }}" 
                                    @if($location['id'] == $permission['location_id']) selected 
                                    @endif>
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
                                    @if($permission_type['id'] == $permission['permission_type_id']) selected 
                                    @endif>
                                    {{ $permission_type['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    
{{-- BUTTONS --}}
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
