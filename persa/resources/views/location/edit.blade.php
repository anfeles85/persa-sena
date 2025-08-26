@extends('templates.base')
@section('title', 'Editar Sede')
@section('header', 'Editar Sede')
@section('content')

<div>
    <label for="" class="fs-3">Editar sede</label>
        <div class="col-lg-12-mb-4">
            <form action="{{ route('location.update', $location['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $location['name'] }}">
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label for="address">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address" required value="{{ $location['address'] }}">
                    </div>
                    <div class="col-lg-12 mb-4">
                        <label for="type">Tipo</label>
                        <select name="type" id="type" class="form-control" required>
                            @foreach ($types as $type)
                                <option value="{{ $type['value'] }}" @if(old('type', $location['type'] ?? '') == $type['value']) selected @endif>
                                    {{ $type['name'] }}
                                </option>
                            @endforeach
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