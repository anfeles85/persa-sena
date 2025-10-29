@extends('templates.base')

@section('title', 'Mi Perfil')
@section('header', 'Mi Perfil')
@section('content')

<label class="fs-2">Mi Perfil</label>

<!-- Mensajes de éxito y error en la parte superior -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- Información no editable -->
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label"><strong>Documento:</strong></label>
                                <input type="text" class="form-control" value="{{ $user->document }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label"><strong>Nombre Completo:</strong></label>
                                <input type="text" class="form-control" value="{{ $user->fullname }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label"><strong>Estado:</strong></label>
                                <input type="text" class="form-control @if($user->status === 'ACTIVO') text-success @else text-danger @endif" 
                                       value="{{ $user->status }}" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label"><strong>Rol:</strong></label>
                                <input type="text" class="form-control" value="{{ $user->role->name ?? 'Sin rol' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Campo editable: Email -->
                    <div class="form-group mb-3">
                        <label for="email" class="form-label"><strong>Correo Electrónico <span class="text-danger">*</span>:</strong></label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">Este es el único campo que puedes modificar.</small>
                    </div>

                    <!-- Botones de acción -->
                    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block text-end mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Actualizar Email
                        </button>
                        <a href="{{ route('auth.changePassword') }}" class="btn btn-primary">
                            Cambiar contraseña <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if($user->role_id == 3)
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Mi Ficha</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-items-center text-center">
                            <thead>
                                <tr>
                                    <th>Número de Ficha</th>
                                    <th>Programa</th>
                                    <th>Jornada</th>
                                    <th>Trimestre</th>
                                    <th>Año</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($user->courses && $user->courses->count() > 0)
                                    @foreach($user->courses as $course)
                                        <tr>
                                            <td>{{ $course->number_group ?? 'N/A' }}</td>
                                            <td>{{ $course->career->name ?? 'N/A' }}</td>
                                            <td>{{ $course->shift ?? 'N/A' }}</td>
                                            <td>{{ $course->trimester ?? 'N/A' }}</td>
                                            <td>{{ $course->year ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $course->status === 'ACTIVO' ? 'success' : 'secondary' }}">
                                                    {{ $course->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-muted">No tienes fichas asignadas.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(Auth::user()->role_id == 2)
<label class="fs-2">Fichas asignadas</label>
    <div class="card mt-4">
        <div class="card-body table-responsive">
            @if($user->instructorCourses->count() > 0)
                <table class="table table-striped align-items-center text-center">
                    <thead>
                        <tr>
                            <th>Ficha</th>
                            <th>Programa</th>
                            <th>Jornada</th>
                            <th>Trimestre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user->instructorCourses as $course)
                            <tr>
                                <td>{{ $course->number_group }}</td>
                                <td>{{ $course->career ? $course->career->name : 'N/A' }}</td>
                                <td>{{ $course->shift }}</td>
                                <td>{{ $course->trimester }} ({{ $course->year }})</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No tienes fichas asignadas.</p>
            @endif
        </div>
    </div>
@endif

@endsection