@extends('templates.base')
@section('title', 'Crear Sede')
@section('header', 'Crear Sede')
@section('content')

<br>
    <div>
        <label class="fs-3">Crear Sede</label>
        <div class="col-lg-12 mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="guard">¿Tiene guardia?</label>
                        <select name="guard" id="guard" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('guard') == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('guard') == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('location.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection