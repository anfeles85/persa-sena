@extends('templates.base')
@section('title', 'Editar tipo de permiso')
@section('header', 'Editar tipo de permiso')
@section('content')

<br>
<div>
    <label for="" class="fs-3">Editar Tipo de Permiso</label>
        <div class="col-lg-12-mb-4">
            <form action="{{ route('permission_type.update', $permission_type['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $permission_type['name'] }}">
                    </div>
                </div>
{{-- BUTTONS --}}
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('permission_type.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
                
            </form>
        </div>
    </label>
</div>

@endsection