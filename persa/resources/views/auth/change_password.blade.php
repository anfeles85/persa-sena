@extends('templates.base')
@section('title', 'Cambiar contraseña')
@section('header', 'Cambiar contraseña')
@section('content')
@yield('scripts')

<br>
<div>
    <label class="fs-3">Cambiar contraseña</label>
        <div class="col-lg-12 mb-4">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>¡Éxito!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>¡Atención!</strong> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('auth.changePassword.update') }}" method="POST">
                @csrf

                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="current_password">Contraseña actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>

                    <div class="col-lg-12 mb-4">
                        <label for="password">Nueva contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" id="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-12 mb-4">
                        <label for="password_confirmation">Confirmar contraseña</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                            name="password_confirmation" id="password_confirmation" required>
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success w-50">Cambiar contraseña</button>
                        <a href="{{ route('index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
    </label>
</div>
@endsection

