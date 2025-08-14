@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

@section('content')

<div class="mb-4 d-flex gap-2">
    <a href="{{ route('user.index') }}" class="btn btn-outline-primary">Todos</a>
    <a href="{{ route('user.aprendices') }}" class="btn btn-outline-success">Aprendices</a>
    <a href="{{ route('user.instructores') }}" class="btn btn-outline-secondary">Instructores</a>
    <a href="{{ route('user.create') }}" class="btn btn-success ms-auto">Crear usuario</a>
</div>

<table id="table_data" class="table table-striped text-center">
    <thead>
        <tr>
            <th>Documento</th>
            <th>Nombre completo</th>
            <th>Correo</th>
            @unless($viewMode === 'aprendices')
                <th>Ficha</th>
            @endunless
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

                @unless($viewMode === 'aprendices')
                    <td>
                        @if($viewMode === 'instructores' && $user->instructorCourses->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($user->instructorCourses as $course)
                                    <li>{{ $course->career->name ?? 'Sin carrera' }}</li>
                                @endforeach
                            </ul>
                        @elseif($user->apprenticeCourses->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($user->apprenticeCourses as $course)
                                    <li>{{ $course->career->name ?? 'Sin carrera' }}</li>
                                @endforeach
                            </ul>
                        @else
                            N/A
                        @endif
                    </td>
                @endunless

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
