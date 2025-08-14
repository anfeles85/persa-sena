@extends('templates.base_reports')

@section('header', 'Reporte permisos por ficha')

@section('content')
    <section id="results">
        @if (isset($course) && $apprentices->count() > 0)
            <h4>Ficha: {{ $course->number_group ?? $course->id }}</h4>
            <hr>

            @foreach ($apprentices as $apprentice)
                <h5>Aprendiz: {{ $apprentice->fullname }} (ID: {{ $apprentice->id }})</h5>

                @if ($apprentice->permissions->isEmpty())
                    <p>No tiene permisos registrados.</p>
                @else
                    <table border="1" cellspacing="0" cellpadding="5" width="100%">
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
                                    <td>{{ $permission->permission_date }}</td>
                                    <td>{{ $permission->permissionType->name ?? 'N/A' }}</td>
                                    <td>{{ $permission->location->name ?? 'N/A' }}</td>
                                    <td>{{ $permission->reasons }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                <br>
            @endforeach
        @else
            <p><strong>No existen resultados en el reporte.</strong></p>
        @endif
    </section>
@endsection
