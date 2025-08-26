@extends('templates.base')
@section('title', 'Editar Curso')
@section('header', 'Editar Curso')
@section('content')
    <div>
        <label class="fs-3">Editar Curso</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('course.update', $course['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row form-group col-lg-12">
                    <div class="col-lg-6 mb-4">
                        <label for="shift">Jornada</label>
                        <select name="shift" id="shift" class="form-control" required value="{{ $course['shift'] }}">
                            @foreach ($shifts as $shift)
                                <option value="{{ $shift['value'] }}" @if($shift['value'] == $course['shift']) selected @endif>
                                    {{ $shift['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="trimester">Trimestre</label>
                        <select name="trimester" id="trimester" class="form-control" required value="{{ $course['trimester'] }}">
                            @foreach ($trimesters as $trimester)
                                <option value="{{ $trimester['value'] }}" @if($trimester['value'] == $course['trimester']) selected @endif>
                                    {{ $trimester['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group col-lg-12">
                    <div class="col-lg-6 mb-4">
                        <label for="year">Año</label>
                        <input type="number" class="form-control" name="year" id="year" 
                         required value="{{ $course['year'] }}">
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="status">Estado</label>
                        <select name="status" id="status" class="form-control" required value="{{ $course['status'] }}">
                            @foreach ($status as $status)
                                <option value="{{ $status['value'] }}" @if($status['value'] == $course['status']) selected @endif>
                                    {{ $status['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row form-group col-lg-12">
                    <div class="col-lg-6 mb-4">
                        <label for="career_id">Carrera</label>
                        <select name="career_id" id="career_id" class="form-control">
                            <option value="">Seleccione</option>
                            @foreach ($careers as $career)
                                <option value="{{ $career['id'] }}" 
                                @if($career['id'] == $course['career_id']) selected @endif>
                                    {{ $career['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <label for="number_group">Numero de ficha</label>
                        <input type="number" class="form-control" name="number_group" id="number_group" 
                         required value="{{ $course['number_group'] }}">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-50">Guardar</button>
                    <a href="{{ route('course.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div> 
@endsection