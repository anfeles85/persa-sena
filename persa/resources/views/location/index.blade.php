@extends('templates.base')
@section('title', 'Sede')
@section('header', 'Sedes')
@section('content')

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
        <tr>
          <td>1</td>
          <td>Tipo de actividad prueba</td>
          <td>carrera 23 #4-23</td>
          <td class="d-flex align-items-center justify-content-center gap-2">
            <a href="#" class="btn btn-primary btn-circle" title="Editar">
                <i class="far fa-edit"></i>
            </a>
            <a href="#" class="btn btn-danger btn-circle" title="Eliminar" onclick="return remove();">
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