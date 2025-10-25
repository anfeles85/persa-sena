@extends('templates.base_reports')

@section('header', 'Reporte de Permisos por Aprendiz')

@section('subtitle')
    <strong>Aprendiz:</strong> {{ $apprentice->fullname }} | <strong>Documento:</strong> {{ $apprentice->document }}
@endsection

@section('content')
    <section id="results">
        @if ($permissions->isNotEmpty())
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
                            <td>{{ $permission->permission_date ? \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $permission->start_time ? \Carbon\Carbon::parse($permission->start_time)->format('H:i') : 'N/A' }}</td>
                            <td>{{ $permission->end_time ? \Carbon\Carbon::parse($permission->end_time)->format('H:i') : 'N/A' }}</td>
                            <td style="text-align: left;">{{ $permission->reasons ?? 'Sin motivo' }}</td>
                            <td>{{ $permission->location->name ?? 'N/A' }}</td>
                            <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                            <td><strong>{{ $permission->status ?? 'N/A' }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data-message">
                <p><strong>No hay permisos registrados para este aprendiz.</strong></p>
            </div>
        @endif
    </section>
@endsection