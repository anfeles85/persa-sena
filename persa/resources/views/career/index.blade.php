@extends('templates.base')
@section('title', 'Programa')
@section('header', 'Programa')
@section('content')

<br>
<label class="fs-2">Programas</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-flex justify-content-md-start">
        <a href="{{ route('career.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped text-center align-middle">
            <thead class="align-middle text-center">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($careers as $career)
                <tr class="d-block d-md-table-row border rounded mb-3 mb-md-0 p-2">
                    <td data-label="Id" class="fw-bold d-block d-md-table-cell">{{ $career['id'] }}</td>
                    <td data-label="Nombre" class="d-block d-md-table-cell">{{ $career['name'] }}</td>
                    <td data-label="Tipo" class="d-block d-md-table-cell">{{ $career['type'] }}</td>
                    <td data-label="Acciones" class="d-block d-md-table-cell">
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                            <a href="{{ route('career.edit', $career['id']) }}" 
                               class="btn btn-primary btn-circle table-btn w-100 w-md-auto" 
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>
                            <form id="form-delete-{{ $career['id'] }}" 
                                  action="{{ route('career.destroy', $career['id']) }}" 
                                  method="POST" 
                                  class="w-100 w-md-auto">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-danger btn-circle table-btn w-100 w-md-auto" 
                                        title="Eliminar" 
                                        onclick="remove(event, {{ $career['id'] }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
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
