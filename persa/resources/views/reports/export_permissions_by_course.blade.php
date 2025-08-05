@extends('templates.base_reports')
@section('header', 'Reporte permisos por cursos')
@section('content')
    <section id="results">
        @if (isset($course) && isset($cantidadPermisos))
            <h4>Curso/Ficha: {{ $course->name ?? $course->id }}</h4>
            <p>Cantidad total de permisos: <strong>{{ $cantidadPermisos }}</strong></p>
        @else
            <p><strong>No existen resultados en el reporte</strong></p>
        @endif
    </section>
@endsection

