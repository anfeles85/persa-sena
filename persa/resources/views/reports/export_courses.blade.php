@extends('templates.base_reports')
@section('header', 'Reporte general de cursos')
@section('content')
    <section id="results">
        @if ($courses)
            <table id="reportTable">
                <thead>
                    <th>Jornada</th>
                    <th>Trimestre</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Carrera</th>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        <tr>
                            <td>{{ $course['shift'] }}</td>
                            <td>{{ $course['trimester'] }}</td>
                            <td>{{ $course['year'] }}</td>
                            <td>{{ $course['status'] }}</td>
                            <td>{{ $course->career->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte</strong></p>
        @endif
    </section>

@endsection