@extends('templates.base')
@section('title', 'Permisos')
@section('header', 'Permisos')
@section('content')


<label class="fs-2">Permisos</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('permission.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead class="align-middle text-center" >
                <tr class="text-center">
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Hora de salida</th>
                    <th>Razón</thh>
                    <th>Sede</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td data-label="Id">{{ $permission['id'] }}</td>
                    <td data-label="Fecha">{{ $permission['permission_date'] }}</td>
                    <td data-label="Hora de inicio">{{ $permission['start_time'] }}</td>
                    <td data-label="Hora de fin">{{ $permission['end_time'] }}</td>
                    <td data-label="Hora de salida">{{ $permission['departure_time'] }}</td>
                    <td data-label="Razón">{{ $permission['reasons'] }}</td>
                    <td data-label="Sede">{{ $permission->location->name }}</td>
                    <td data-label="Estado">{{ $permission['status'] }}</td>
                    <td id="buttons_DE" class="d-flex align-items-center justify-content-center gap-2" style="border-top: none;">
                        <a href="{{ route('permission.edit', $permission["id"]) }}" class="btn btn-primary btn-circle table-btn" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>

                        <form id="form-delete-{{ $permission['id'] }}" action="{{ route('permission.destroy', $permission["id"]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-circle table-btn" title="Eliminar" 
                                onclick="remove({{ $permission['id'] }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection