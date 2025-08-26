@extends('templates.base') 
@section('title', 'Perfil del Aprendiz')
@section('header', 'Perfil del Aprendiz')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('apprentice.index') }}">Aprendices</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Perfil de {{ $apprentice->fullname }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            Editar Perfil del Aprendiz
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('apprentice.profile.update', $apprentice->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="document" class="form-label fw-bold">
                                            Documento de Identidad <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('document') is-invalid @enderror" 
                                               id="document" 
                                               name="document" 
                                               value="{{ old('document', $apprentice->document) }}" 
                                               maxlength="20" 
                                               required>
                                        @error('document')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label fw-bold">
                                            Estado <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status" 
                                                required>
                                            <option value="ACTIVO" {{ old('status', $apprentice->status) == 'ACTIVO' ? 'selected' : '' }}>
                                                Activo
                                            </option>
                                            <option value="INACTIVO" {{ old('status', $apprentice->status) == 'INACTIVO' ? 'selected' : '' }}>
                                                Inactivo
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="fullname" class="form-label fw-bold">
                                    Nombre Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('fullname') is-invalid @enderror" 
                                       id="fullname" 
                                       name="fullname" 
                                       value="{{ old('fullname', $apprentice->fullname) }}" 
                                       maxlength="500" 
                                       required>
                                @error('fullname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label fw-bold">
                                    Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $apprentice->email) }}" 
                                       maxlength="255" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="course_id" class="form-label fw-bold">
                                    Ficha <span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-select @error('course_id') is-invalid @enderror" 
                                        id="course_id" 
                                        name="course_id" 
                                        required>
                                    <option value="">-- Seleccione una ficha --</option>
                                    @foreach($courses as $course)
                                        @php
                                            $currentCourseId = $apprentice->courses->first()->id ?? null;
                                        @endphp
                                        <option value="{{ $course->id }}" 
                                            {{ old('course_id', $currentCourseId) == $course->id ? 'selected' : '' }}>
                                            {{ $course->number_group }} - {{ $course->career->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Guardar Cambios
                                </button>
                                <a href="{{ route('apprentice.index') }}" class="btn btn-success text-white">
                                    Volver
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            Información Actual
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Estado:</strong>
                            @if($apprentice->status == 'ACTIVO')
                                <span class="badge bg-success ms-2">Activo</span>
                            @else
                                <span class="badge bg-danger ms-2">Inactivo</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <strong>Documento:</strong>
                            <div class="text-muted">{{ $apprentice->document }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Nombre:</strong>
                            <div class="text-muted">{{ $apprentice->fullname }}</div>
                        </div>

                        <div class="mb-3">
                            <strong>Email:</strong>
                            <div class="text-muted">{{ $apprentice->email }}</div>
                        </div>

                        @if($apprentice->courses->count() > 0)
                            @php $course = $apprentice->courses->first(); @endphp
                            <div class="mb-3">
                                <strong>Ficha Actual:</strong>
                                <div class="text-muted">
                                    {{ $course->number_group }} - {{ $course->career->name ?? 'N/A' }}<br>
                                    <small>{{ $course->shift ?? 'N/A' }} - {{ $course->year ?? 'N/A' }}</small>
                                </div>
                            </div>
                        @endif

                        <hr>

                    </div>
                </div>
            </div>
        </div>

        {{-- Mensajes de éxito y error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
@endsection
