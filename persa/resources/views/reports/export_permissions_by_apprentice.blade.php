@extends('templates.base_reports')

@section('header', 'Reporte permisos por aprendiz')

@section('content')
    <section id="results">
        @if ($permissions->isNotEmpty())
            <h4>Aprendiz: {{ $apprentice->fullname }} (Documento: {{ $apprentice->document }})</h4>
            <table id="reportTable">
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
                            <td>{{ \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($permission->start_time)->format('H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($permission->end_time)->format('H:i') }}</td>
                            <td>{{ $permission->reasons }}</td>
                            <td>{{ $permission->location->name ?? 'N/A' }}</td>
                            <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                            <td>{{ ucfirst(strtolower($permission->status)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte.</strong></p>
        @endif
    </section>
@endsection