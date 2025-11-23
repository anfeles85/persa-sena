@extends('templates.base')
@section('title', 'Crear Programa')
@section('header', 'Crear Programa')
@section('content')

    <div>
        <label class="fs-3">Crear Programa</label>
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
                        <select name="type" id="type" class="form-control" required value="{{ old('type') }}">
                            @foreach ($types as $type)
                                <option value="{{ $type['value'] }}" @if(old('type') == $type['name']) selected @endif>
                                    {{ $type['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50" >Guardar</button>
                    <a href="{{ route('career.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection