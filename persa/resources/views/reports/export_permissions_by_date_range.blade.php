@extends('templates.base_reports')

@section('header', 'Reporte permisos por rango de fechas')

@section('content')
    <section id="results">
        @if ($permissions->count() > 0)
            <p><strong>Fecha de legalización desde: </strong>{{ \Carbon\Carbon::parse($date1)->format('d/m/Y') }}</p>
            <p><strong>Fecha de legalización hasta: </strong>{{ \Carbon\Carbon::parse($date2)->format('d/m/Y') }}</p>
            <br>
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de permiso</th>
                        <th>Motivo</th>
                        <th>Aprendiz</th>
                        <th>Documento</th>
                        <th>Grupo</th>
                        <th>Estado</th>
                        <th>Sede</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') }}</td>
                            <td>{{ $permission->reasons }}</td>
                            
                            <td>{{ $permission->apprentice_user ? $permission->apprentice_user->fullname : 'Usuario Eliminado' }}</td>
                            <td>{{ $permission->apprentice_user ? $permission->apprentice_user->document : 'N/A' }}</td>
                            
                            <td>
                                @if ($permission->apprentice_user && $permission->apprentice_user->courses->isNotEmpty())
                                    @foreach ($permission->apprentice_user->courses as $course)
                                        {{ $course->number_group ?? 'N/A' }}
                                        @if (!$loop->last), @endif
                                    @endforeach
                                @else
                                    No tiene ficha asignada
                                @endif
                            </td>
                            <td>{{ ucfirst(strtolower($permission->status)) }}</td>
                            <td>{{ $permission->location->name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte</strong></p>
        @endif
    </section>
@endsection