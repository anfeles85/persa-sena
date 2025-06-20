@extends('templates.base')
@section('title', 'permission_type')
@section('header', 'permission_type')
@section('content')

<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('permission_type.create') }}" class="btn btn-primary">Crear</a>
    </div>
</div>



<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped table-hover">
            <thead>
                <tr>
                <th>Id</th>
                <th>Nombre</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Tipo de actividad prueba</td>
                    <td>
                        <a href="#"  class="btn btn-primary btn-circle btn-sm" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-circle btn-sm" title="Eliminar" onclick="return remove();">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection