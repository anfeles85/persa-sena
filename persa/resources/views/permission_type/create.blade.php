@extends('templates.base')
@section('title', 'Crear Tipo de permiso')
@section('header', 'Crear Tipo de permiso')
@section('content')

    <div>
        <label class="fs-3">Crear Tipo de Permiso</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('permission_type.store') }}" method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name"
                         required value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('permission_type.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection