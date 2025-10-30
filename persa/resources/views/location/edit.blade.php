@extends('templates.base')
@section('title', 'Editar Sede')
@section('header', 'Editar Sede')
@section('content')

<div>
    <label for="" class="fs-3">Editar sede</label>
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
            <form action="{{ route('location.update', $location['id']) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $location['name']) }}">
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address" required value="{{ old('address', $location['address']) }}">
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label for="guard">¿Tiene guardia?</label>
                        <select name="guard" id="guard" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="SI" {{ old('guard', $location['guard']) == 'SI' ? 'selected' : '' }}>Sí</option>
                            <option value="NO" {{ old('guard', $location['guard']) == 'NO' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
{{-- BUTTONS --}}
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('location.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
                
            </form>
        </div>
    </label>
</div>

@endsection