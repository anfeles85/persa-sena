@extends('templates.base')
@section('title', 'Sede')
@section('header', 'Sedes')
@section('content')


<label class="fs-2">Sedes</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('location.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>


<div class="row">
  <div class="col-lg-12 mb-4">
    <table id="table_data" class="table table-striped align-items-center text-center">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nombre</th>
          <th>Direccion</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($locations as $location)
        <tr>
            <td data-label="Id">{{ $location['id'] }}</td>
            <td data-label="Nombre">{{ $location['name'] }}</td>
            <td data-label="Direccion">{{ $location['address'] }}</td>
            <td id="buttons_DE" style="border-top: none;">
            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                <div class="col-lg-6 mb-4">
                    <a href="{{ route('location.edit', $location["id"]) }}" class="btn btn-primary btn-circle table-btn w-100" title="Editar">
                        <i class="far fa-edit"></i>
                    </a>
                </div>
                <div class="col-lg-6 mb-4">
                    <form id="form-delete-{{ $location['id'] }}" action="{{ route('location.destroy', $location["id"]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-circle table-btn w-100" title="Eliminar" 
                            onclick="remove(event, {{ $location['id'] }})">
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