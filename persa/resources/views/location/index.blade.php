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
          <td>{{ $location['id'] }}</td>
          <td>{{ $location['name'] }}</td>
          <td>{{ $location['address'] }}</td>
          <td class="d-flex align-items-center justify-content-center gap-2">
            <a href="{{ route('location.edit', $location["id"]) }}" class="btn btn-primary btn-circle" title="Editar">
                <i class="far fa-edit"></i>
            </a>
            <form id="form-delete-{{ $location['id'] }}" action="{{ route('location.destroy', $location["id"]) }}"
              method="post">
              @csrf
              @method('DELETE')

              <button type="submit" class="btn btn-danger btn-circle" title="Eliminar" 
              onclick="event.preventDefault(); remove({{ $location['id'] }})">
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

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡OK!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        function remove(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            });
    
        }
    </script>    
    @if(session('created_successfully'))
        <script>
            Swal.fire("Sede creado exitosamente");
        </script>
    @endif
    <script src="{{ asset('js/DataTables.js') }}"></script>
    <script src="{{ asset('js/general.js') }}"></script>
@endsection