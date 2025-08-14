@extends('templates.base_reports')

@section('header', 'Reporte permisos por aprendiz')

@section('content')
    <section id="results">
        @if ($permissions->isNotEmpty())
            <h4>Aprendiz: {{ $apprentice->fullname }}</h4>
            <table border="1" cellspacing="0" cellpadding="5" width="100%">
                <thead>
                    <tr>
                        <th>Fecha de permiso</th>
                        <th>Hora de inicio</th>
                        <th>Hora de fin</th>
                        <th>Motivo</th>
                        <th>Sede</th>
                        <th>Tipo de permiso</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->permission_date }}</td>
                            <td>{{ $permission->start_time }}</td>
                            <td>{{ $permission->end_time }}</td>
                            <td>{{ $permission->reasons }}</td>
                            <td>{{ $permission->location->name ?? 'N/A' }}</td>
                            <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                            <td>{{ $permission->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte.</strong></p>
        @endif
    </section>
@endsection