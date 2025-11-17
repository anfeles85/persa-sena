@extends('templates.base')
@section('title', 'Crear Grupo')
@section('header', 'Crear Grupo')
@section('content')
    <div>
        <label class="fs-3">Crear Grupos</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('course.store') }}" method="POST">
                @csrf
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="shift">Jornada</label>
                        <select name="shift" id="shift" class="form-control" required value="{{ old('shift') }}">
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift['value'] }}" @if(old('shift') == $shift['name']) selected @endif>
                                    {{ $shift['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <label for="trimester">Trimestre</label>
                        <select name="trimester" id="trimester" class="form-control" required value="{{ old('trimester') }}">
                            @foreach ($trimesters as $trimester)
                                <option value="{{ $trimester['value'] }}" @if(old('trimester') == $trimester['name']) selected @endif>
                                    {{ $trimester['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="year">Año</label>
                        <input type="number" class="form-control" name="year" id="year"
                         required value="{{ old('year') }}">
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="type">Estado</label>
                        <select name="status" id="status" class="form-control" required value="{{ old('status') }}">
                            @foreach ($status as $status)
                                <option value="{{ $status['value'] }}" @if(old('status') == $status['name']) selected @endif>
                                    {{ $status['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="career_id">Programa</label>
                        <select name="career_id" id="career_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($careers as $career)
                                <option value="{{ $career['id'] }}" 
                                @if(old('career_id') == $career['id']) selected @endif>
                                    {{ $career['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="number_group">Numero de ficha</label>
                        <input type="number" class="form-control" name="number_group" id="number_group"
                         required value="{{ old('number_group') }}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50" >Guardar</button>
                    <a href="{{ route('course.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection