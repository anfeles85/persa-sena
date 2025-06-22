@extends('templates.base')
@section('title', 'Crear Carrera')
@section('header', 'Crear Carrera')
@section('content')

    <div class="mt-8">
        <div class="col-lg-12 mb-4">
            <form action="{{ route('career.store') }}" method="POST">
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
                        <label for="type">Tipo</label>
                        <input type="text" class="form-control" name="type" id="type"
                         required value="{{ old('type') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-50">Guardar</button>
                    <a href="{{ route('career.index') }}" class="btn btn-secondary w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection