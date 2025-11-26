@extends('templates.base')

@section('title', 'Crear usuario')
@section('header', 'Crear usuario')

@section('content')

<br>
<div class="col-12 col-md-10 mx-auto">
    <label class="fs-3">Crear Usuario</label>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-lg-6 mb-3">
                <label for="fullname">Nombre completo</label>
                <input type="text" class="form-control" name="fullname" id="fullname" 
                    value="{{ old('fullname') }}" required>
                @error('fullname') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" name="email" id="email" 
                    value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label for="document">Documento</label>
                <input type="text" class="form-control" name="document" id="document" 
                    value="{{ old('document') }}" required>
                @error('document') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-lg-6 mb-3">
                <label for="role_id">Rol</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach ($roles as $role)
                        @if(in_array(strtoupper($role->name), ['INSTRUCTOR', 'GUARDA']))
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            
            <div class="col-lg-6 mb-3">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" id="password" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            
            <div class="col-lg-6 mb-3">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="col-lg-12 mb-3">
            <label for="status">Estado</label>
            <select name="status" id="status" class="form-control" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status['value'] }}" 
                        {{ old('status') == $status['value'] ? 'selected' : '' }}>
                        {{ $status['name'] }}
                    </option>
                @endforeach
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="row">
            <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success w-50">Guardar</button>
            <a href="{{ route('user.index') }}" class="btn btn-danger w-50">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection