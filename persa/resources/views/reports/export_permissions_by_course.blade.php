@extends('templates.base_reports')

@section('header', 'Reporte permisos por ficha')

@section('content')
    <section id="results">
        @if (isset($course) && $apprentices->count() > 0)
            <h4>Grupo: {{ $course->number_group ?? $course->id }}</h4>
            <p><strong>Programa:</strong> {{ $course->career->name ?? 'N/A' }}</p>
            <p><strong>Jornada:</strong> {{ $course->shift }} - {{ $course->year }}</p>
            <hr>

            @php
                $apprenticesWithPermissions = $apprentices->filter(function($apprentice) {
                    return $apprentice->permissions->isNotEmpty();
                });
            @endphp

            @if($apprenticesWithPermissions->isEmpty())
                <p><strong>No existen permisos registrados para esta ficha.</strong></p>
            @else
                @foreach ($apprenticesWithPermissions as $apprentice)
                    <h5>Aprendiz: {{ $apprentice->fullname }} (Documento: {{ $apprentice->document }})</h5>

                    <table id="reportTable">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de Permiso</th>
                                <th>Sede</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apprentice->permissions as $permission)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') }}</td>
                                    <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                                    <td>{{ $permission->location->name ?? 'N/A' }}</td>
                                    <td>{{ $permission->reasons }}</td>
                                    <td>{{ ucfirst(strtolower($permission->status)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <br>
                @endforeach
            @endif
        @else
            <p><strong>No existen resultados en el reporte.</strong></p>
        @endif
    </section>
@endsection