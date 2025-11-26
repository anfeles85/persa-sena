@extends('templates.base_reports')

@section('header', 'Reporte permisos por aprendiz')

@section('content')
    <section id="results">
        @if ($permissions->isNotEmpty())
            <div style="margin-bottom: 20px; padding: 10px; background-color: #f8f9fa; border-left: 4px solid #39a900;">
                <h4 style="margin: 0 0 10px 0; color: #333;">Información del Aprendiz</h4>
                <p style="margin: 5px 0;"><strong>Nombre:</strong> {{ $apprentice->fullname }}</p>
                <p style="margin: 5px 0;"><strong>Documento:</strong> {{ $apprentice->document }}</p>
                <p style="margin: 5px 0;"><strong>Correo:</strong> {{ $apprentice->email }}</p>
                
                @if($course)
                    <p style="margin: 5px 0;"><strong>Grupo:</strong> {{ $course->number_group }}</p>
                    <p style="margin: 5px 0;"><strong>Programa de Formación:</strong> {{ $course->career->name ?? 'N/A' }}</p>
                    <p style="margin: 5px 0;"><strong>Jornada:</strong> {{ $course->shift }} - {{ $course->year }}</p>
                @else
                    <p style="margin: 5px 0; color: #dc3545;"><strong>Ficha:</strong> Sin ficha asignada</p>
                @endif
            </div>

            <h4 style="margin-top: 20px;">Historial de Permisos</h4>
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