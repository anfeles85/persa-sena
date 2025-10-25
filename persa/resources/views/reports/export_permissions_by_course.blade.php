@extends('templates.base_reports')

@section('header', 'Reporte de Permisos por Curso')

@section('subtitle')
    <strong>Ficha:</strong> {{ $course->number_group ?? $course->id }} | 
    <strong>Programa:</strong> {{ $course->career->name ?? 'N/A' }}
@endsection

@section('content')
    <section id="results">
        @if (isset($course) && $apprentices->count() > 0)

            @foreach ($apprentices as $apprentice)
                <h5>Aprendiz: {{ $apprentice->fullname }} (Documento: {{ $apprentice->document}})</h5>

                @if ($apprentice->permissions->isEmpty())
                    <p style="color: #666; font-style: italic; padding-left: 20px;">No tiene permisos registrados.</p>
                @else
                    <table id="reportTable">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo de Permiso</th>
                                <th>Ubicación</th>
                                <th>Motivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apprentice->permissions as $permission)
                                <tr>
                                    <td>{{ $permission->permission_date ? \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                                    <td>{{ $permission->location->name ?? 'N/A' }}</td>
                                    <td style="text-align: left;">{{ $permission->reasons ?? 'Sin motivo' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <br>
            @endforeach
        @else
            <div class="no-data-message">
                <p><strong>No hay permisos para esta ficha.</strong></p>
            </div>
        @endif
    </section>
@endsection