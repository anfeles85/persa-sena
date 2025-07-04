@extends('templates.base')
@section('title', 'Crear Sede')
@section('header', 'Crear Sede')
@section('content')

    <div>
        <label class="fs-3">Crear sede</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('location.store') }}" method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name"
                         required value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="address">Direccion</label>
                        <input type="text" class="form-control" name="address" id="address"
                         required value="{{ old('address') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50" onclick="{{ create() }}">Guardar</button>
                    <a href="{{ route('location.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection