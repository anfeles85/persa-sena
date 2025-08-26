<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro - PERSA</title>

    <!-- Fuentes e iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,900" rel="stylesheet" />

    <!-- Argon Dashboard -->
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.min.css') }}?v=2">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v=2">
</head>
<body>
<div class="login-container body-login login-container-register">
    <div class="login-card login-card-register">
        <div class="row g-0 h-100">

            <!-- Columna izquierda (Logo SENA + info) -->
            <div class="col-lg-6 login-left d-flex flex-column justify-content-center align-items-center text-center p-4">
                    <div class="logo mb-3">
                        <img src="{{ asset('img/sena-logo.png') }}" 
                             alt="SENA Logo" 
                             class="img-fluid" 
                             style="max-width: 160px; height: auto;">
                    </div>
                    <div class="text-logo">
                        <h2 class="system-title mb-2">P.E.R.S.A</h2>
                        <p class="system-subtitle mb-1">
                            Bienvenido al sistema de permisos de salidas de aprendices del SENA.
                        </p>
                        <p class="system-subtitle">
                            Crea tu cuenta como aprendiz para ingresar al sistema.
                        </p>
                    </div>
                </div>

            <!-- Columna derecha (Formulario) -->
            <div class="col-12 col-lg-6 login-right login-right-register 
                        d-flex flex-column justify-content-center p-4">
                
                <!-- Logo Persa -->
                <div class="text-center mb-3">
                    <img src="{{ asset('img/persa-logo.png') }}" 
                         alt="PERSA Logo" 
                         class="img-fluid logo-persa"
                         style="max-width: 120px; height: auto;">
                </div>

                <!-- Tabs -->
                <div class="login-tabs text-center mb-3">
                    <a href="{{ route('auth.login') }}" class="tab-button">Iniciar sesión</a>
                    <span class="tab-button active">Registrarse</span>
                </div>

                <!-- Errores -->
                @if($errors->any())
                    <div class="alert no-credentials">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert correct-credentials">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('auth.store') }}" 
                      class="form-login form-login-register">
                    @csrf
                    <div class="row">
                        <!-- Documento -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <input type="text" name="document" class="form-control" 
                                   placeholder="Documento" value="{{ old('document') }}">
                        </div>

                        <!-- Curso -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <select class="form-control" name="course_id" required>
                                <option value="">Seleccione una ficha:</option>
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" 
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->number_group }} - {{ $course->career->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Nombres -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <input type="text" name="name" class="form-control" 
                                   placeholder="Nombres" value="{{ old('name') }}">
                        </div>

                        <!-- Apellidos -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <input type="text" name="lastname" class="form-control" 
                                   placeholder="Apellidos" value="{{ old('lastname') }}">
                        </div>

                        <!-- Correo -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <input type="email" name="email" class="form-control" 
                                   placeholder="Correo electrónico" value="{{ old('email') }}">
                        </div>

                        <!-- Confirmar correo -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <input type="email" name="email_confirmation" class="form-control" 
                                   placeholder="Confirmar correo electrónico" value="{{ old('email_confirmation') }}">
                        </div>

                        <!-- Contraseña -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <div class="input-password-wrapper">
                                <input type="password" id="password" name="password" 
                                       class="form-control password-input" 
                                       placeholder="Contraseña" required>
                                <i class="fa fa-eye toggle-password-icon" toggle="#password"></i>
                            </div>
                        </div>

                        <!-- Confirmar contraseña -->
                        <div class="form-group col-12 col-md-6 mb-3">
                            <div class="input-password-wrapper">
                                <input type="password" id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control password-input" 
                                       placeholder="Confirmar contraseña" required>
                                <i class="fa fa-eye toggle-password-icon" toggle="#password_confirmation"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botón -->
                    <button type="submit" class="btn-login w-100 mt-3">
                        Registrarse
                    </button>

                    <!-- Enlace -->
                    <div class="forgot-password text-center mt-2">
                        <a href="{{ route('auth.login') }}">Ya tengo una cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para mostrar/ocultar contraseñas -->
<script>
    document.querySelectorAll('.toggle-password-icon').forEach(function (element) {
        element.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

</body>
</html>