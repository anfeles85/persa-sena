@extends('templates.base_reports')
@section('header', 'Reporte órdenes por rango de fechas')
@section('content')
    <section id="results">
        @if (count($permissions) != 0)
            <p><strong>Fecha de legalización desde: </strong>{{ $date1 }}</p>
            <p><strong>Fecha de legalización hasta: </strong>{{ $date2 }}</p>
            <br>
            <table id="reportTable">
                <thead>
                    <th>Id</th>
                    <th>Fecha de permiso</th>
                    <th>Motivo</th>
                    <th>Aprendiz</th>
                    <th>Estado</th>
                    <th>Sede</th>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission['id'] }}</td>
                            <td>{{ $permission['permission_date'] }}</td>
                            <td>{{ $permission['reasons'] }}</td>
                            <td>{{ $permission->apprentice_user->fullname }}</td>
                            <td>{{ $permission['status'] }}</td>
                            <td>{{ $permission->location->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p><strong>No existen resultados en el reporte</strong></p>
        @endif
    </section>

@endsection