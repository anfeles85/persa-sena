@extends('templates.base')
@section('title', 'Tipos de Permiso')
@section('header', 'Tipos de Permiso')
@section('content')



<label class="fs-2">Tipo de permisos</label>
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
                    <td id="buttons_DE" class="d-flex align-items-center justify-content-center gap-2 no-label-bg" style="border-top: none;">
                        <a href="{{ route('permission_type.edit', $permissionType["id"]) }}" class="btn btn-primary btn-circle table-btn" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>

                        <form id="form-delete-{{ $permissionType['id'] }}" action="{{ route('permission_type.destroy', $permissionType["id"]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger btn-circle table-btn" title="Eliminar" 
                            onclick="remove(event, {{ $permissionType['id'] }})">
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