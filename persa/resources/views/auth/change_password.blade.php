@extends('templates.base')
@section('title', 'Cambiar contraseña')
@section('header', 'Cambiar contraseña')
@section('content')
@yield('scripts')

<div>
    <label class="fs-3">Cambiar contraseña</label>
    <div class="col-lg-12 mb-4">
        <form action="{{ route('auth.changePassword') }}" method="POST">
            @csrf

            <div class="row form-group">
                <div class="col-lg-12 mb-4">
                    <label for="current_password">Contraseña actual</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>

                <div class="col-lg-12 mb-4">
                    <label for="password">Nueva contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="col-lg-12 mb-4">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            <div class="row">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">Cambiar contraseña</button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection