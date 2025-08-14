@extends('templates.base')

@section('title', 'Mi Perfil')
@section('header', 'Mi Perfil')
@section('content')

<label class="fs-2">Mi Perfil de Aprendiz</label>

<!-- Mensajes de éxito y error en la parte superior -->
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
                                <input type="text" class="form-control" value="Aprendiz" readonly>
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

                    <!-- Información de cursos -->
                    <div class="form-group mb-4">
                        <label class="form-label"><strong>Ficha(s) Asignada(s):</strong></label>
                        <div class="table-responsive">
                            <table class="table table-striped align-items-center text-center">
                                <thead>
                                    <tr>
                                        <th>Horario</th>
                                        <th>Programa</th>
                                        <th>Codigo de ficha</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($user->courses && $user->courses->count() > 0)
                                        @foreach($user->courses as $course)
                                            <tr>
                                                <td>{{ $course->shift ?? 'N/A' }}</td>
                                                <td>{{ $course->career->name ?? 'N/A' }}</td>
                                                <td>{{ $course->id ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $course->status === 'ACTIVO' ? 'success' : 'secondary' }}">
                                                        {{ $course->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-muted">No tienes fichas asignadas.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="row">
                        <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block text-end">
                            <button type="button" class="btn btn-primary" onclick="window.history.back()">
                                <i class="fas fa-arrow-left"></i> Volver
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Actualizar Email
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


            
        </div>
    </div>
</div>

@endsection


