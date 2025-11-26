@extends('templates.base')
@section('title', 'Editar Programa')
@section('header', 'Editar Programa')
@section('content')

<br>
<div>
    <label for="" class="fs-3">Editar Programa</label>
        <div class="col-lg-12-mb-4">
            <form action="{{ route('career.update', $career['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ $career['name'] }}">
                    </div>
                    <div class="row form-group">
                        <div class="col-lg-12 mb-4">
                            <label for="type">Tipo</label>
                            <select name="type" id="type" class="form-control" required value="{{ $career['type'] }}">
                                @foreach ($types as $type)
                                    <option value="{{ $type['value'] }}" @if(old('type') == $type['name']) selected @endif>
                                        {{ $type['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
{{-- BUTTONS --}}
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('career.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
                
            </form>
        </div>
    </label>
</div>

@endsection