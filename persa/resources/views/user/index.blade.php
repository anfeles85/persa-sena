@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

@section('content')

<div class="mb-4 d-flex gap-2">
    <a href="{{ route('user.index') }}" class="btn btn-outline-primary">Todos</a>
    <a href="{{ route('user.apprentices') }}" class="btn btn-outline-success">Aprendices</a>
    <a href="{{ route('user.instructors') }}" class="btn btn-outline-secondary">Instructores</a>
    <a href="{{ route('user.guard') }}" class="btn btn-outline-warning">Guardas</a>
</div>

<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('user.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<table id="table_data" class="table table-striped text-center">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Nombre completo</th>
            <th>Correo</th>
            @if($viewMode === 'aprendices')
                <th>Ficha</th>
            @endif
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->document }}</td>
                <td>{{ $user->fullname }}</td>
                <td>{{ $user->email }}</td>

                @if($viewMode === 'aprendices')
                    <td>
                        @if($user->apprenticeCourses->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($user->apprenticeCourses as $course)
                                    <li>{{ $course->number_group ?? 'Sin carrera' }}</li>
                                @endforeach
                            </ul>
                        @else
                            N/A
                        @endif
                    </td>
                @endif

                <td>{{ $user->role->name ?? 'Sin rol' }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <form id="form-delete-{{ $user->id }}" action="{{ route('user.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" title="Eliminar"
                                onclick="remove(event, {{ $user->id }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>

@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection
