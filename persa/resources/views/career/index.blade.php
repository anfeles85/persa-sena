@extends('templates.base')
@section('title', 'Carerra')
@section('header', 'Carerra')
@section('content')


<label class="fs-2">Programas</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('career.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($careers as $career)
                <tr>
                    <td>{{ $career['id'] }}</td>
                    <td>{{ $career['name'] }}</td>
                    <td>{{ $career['type'] }}</td>
                    <td class="d-flex align-items-center justify-content-center gap-2" style="border-top: none;">
                        <a href="{{ route('career.edit', $career["id"]) }}" class="btn btn-primary btn-circle" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>

                       <form id="form-delete-{{ $career['id'] }}" action="{{ route('career.destroy', $career["id"]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-circle" title="Eliminar" 
                            onclick="remove({{ $career['id'] }})">
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
