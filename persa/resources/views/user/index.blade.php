@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

@section('content')

<label class="fs-2">Usuarios</label>

{{-- Filtros responsivos --}}
<form method="GET" action="{{ url()->current() }}" class="row g-2 mb-3">
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.index') }}" class="btn btn-outline-primary w-100">Todos</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.apprentices') }}" class="btn btn-outline-success w-100">Aprendices</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.instructors') }}" class="btn btn-outline-secondary w-100">Instructores</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.guard') }}" class="btn btn-outline-warning w-100">Guardas</a>
    </div>
</form>

<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('user.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped text-center align-items-center">
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
                        <td data-label="Documento">{{ $user->document }}</td>
                        <td data-label="Nombre completo">{{ $user->fullname }}</td>
                        <td data-label="Correo">{{ $user->email }}</td>

                        @if($viewMode === 'aprendices')
                            <td data-label="Ficha">
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

                        <td data-label="Rol">{{ $user->role->name ?? 'Sin rol' }}</td>
                        <td data-label="Estado">{{ $user->status }}</td>
                        <td id="buttons_DE" style="border-top: none;">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 w-100">
                                {{-- Botón Editar --}}
                                <a href="{{ route('user.edit', $user->id) }}" 
                                class="btn btn-primary btn-circle table-btn w-100" 
                                title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>

                                {{-- Botón Eliminar --}}
                                <form id="form-delete-{{ $user->id }}" 
                                    action="{{ route('user.destroy', $user->id) }}" 
                                    method="POST" class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-danger btn-circle table-btn w-100" 
                                            title="Eliminar"
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
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection