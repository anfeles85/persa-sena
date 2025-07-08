@extends('templates.base_reports')
@section('header', 'Reporte permisos por aprendiz')
@section('content')
    <section id="results">
        @if (count($permissions) !=0)
            <h4>Aprendiz: </h4>
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>Fecha de permiso</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                        <th>Motivo</th>
                        <th>sede</th>
                        <th>tipo de permiso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission )
                    <tr>
                        <td>{{ $permission['permission_date'] }}</td>
                        <td>{{ $permission['start_time'] }}</td>
                        <td>{{ $permission['end_time'] }}</td>
                        <td>{{ $permission['reasons'] }}</td>
                        <td>{{ $permission['location_id'] }}</td>
                        <td>{{ $permission->permissionType->name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte</strong></p>
        @endif
    </section>
@endsection
