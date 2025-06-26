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
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Hora de incio</th>
                    <th>Hora de fin</th>
                    <th>Hora de llegada</th>
                    <th>Razón</th>
                    <th>Sede</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission['id'] }}</td>
                    <td>{{ $permission['permission_date'] }}</td>
                    <td>{{ $permission['start_time'] }}</td>
                    <td>{{ $permission['end_time'] }}</td>
                    <td>{{ $permission['departure_time'] }}</td>
                    <td>{{ $permission['reasons'] }}</td>
                    <td>{{ $permission->location->name }}</td>
                    <td>{{ $permission['status'] }}</td>
                    <td class="d-flex align-items-center justify-content-center gap-2" style="border-top: none;">
                        <a href="{{ route('permission.edit', $permission["id"]) }}" class="btn btn-primary btn-circle" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>

                       <form id="form-delete-{{ $permission['id'] }}" action="{{ route('permission.destroy', $permission["id"]) }}"
                            method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-circle" title="Eliminar" 
                            onclick="event.preventDefault(); remove({{ $permission['id'] }})">
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
            Swal.fire("Permiso creado exitosamente");
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#table_permission').DataTable({
            });
        });
    </script>
@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection