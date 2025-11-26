@extends('templates.base')
@section('title', 'Tipos de Permiso')
@section('header', 'Tipos de Permiso')
@section('content')

<br>
<label class="fs-2">Tipo de Permisos</label>

<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('permission_type.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissionTypes as $permissionType)
                <tr>
                    <td data-label="Id">{{ $permissionType['id'] }}</td>
                    <td data-label="Nombre">{{ $permissionType['name'] }}</td>
                    <td id="buttons_DE" style="border-top: none;">
                        <div class="row justify-content-center gx-2">
                            <div class="col-lg-6 col-12 mb-2">
                                <a href="{{ route('permission_type.edit', $permissionType["id"]) }}" class="btn btn-primary table-btn w-100" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                            <div class="col-lg-6 col-12">
                                <form id="form-delete-{{ $permissionType['id'] }}" action="{{ route('permission_type.destroy', $permissionType["id"]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger table-btn w-100" title="Eliminar" 
                                        onclick="remove(event, {{ $permissionType['id'] }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
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
