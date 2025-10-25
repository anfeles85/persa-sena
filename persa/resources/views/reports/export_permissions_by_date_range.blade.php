@extends('templates.base_reports')

@section('header', 'Reporte de Permisos por Rango de Fechas')

@section('subtitle')
    <strong>Desde:</strong> {{ \Carbon\Carbon::parse($date1)->format('d/m/Y') }} | 
    <strong>Hasta:</strong> {{ \Carbon\Carbon::parse($date2)->format('d/m/Y') }}
@endsection

@section('content')
    <section id="results">
        @if ($permissions->count() > 0)
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de permiso</th>
                        <th>Motivo</th>
                        <th>Aprendiz</th>
                        <th>Documento</th>
                        <th>Carrera</th>
                        <th>Estado</th>
                        <th>Sede</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->permission_date ? \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') : 'N/A' }}</td>
                            <td style="text-align: left;">{{ $permission->reasons ?? 'Sin motivo' }}</td>
                            <td>{{ $permission->apprentice_user->fullname ?? 'N/A' }}</td>
                            <td>{{ $permission->apprentice_user->document ?? 'N/A' }}</td>
                            <td>
                                @if ($permission->apprentice_user && $permission->apprentice_user->courses->isNotEmpty())
                                    {{ $permission->apprentice_user->courses->first()->career->name ?? 'N/A' }}
                                @else
                                    Sin ficha
                                @endif
                            </td>
                            <td><strong>{{ $permission->status ?? 'N/A' }}</strong></td>
                            <td>{{ $permission->location->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data-message">
                <p><strong>No hay permisos en el rango especificado.</strong></p>
            </div>
        @endif
    </section>
@endsection