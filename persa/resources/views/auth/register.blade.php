<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.min.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v=2">
</head>
<body>
<div class="login-container body-login login-container-register">
    <div class="login-card login-card-register">
        <div class="row g-0 h-100">
            <div class="col-lg-6 login-left login-left-register">
                <div class="logo-container">
                    <div class="logo">
                        <img src="{{ asset('img/sena-logo.png') }}" alt="Logo SENA">
                    </div>
                    <div class="text-logo">
                        <h2 class="system-title">P.E.R.S.A</h2>
                        <p class="system-subtitle">Bienvenido al sistema de permisos de salidas de aprendices del SENA.</p>
                        <p class="system-subtitle">Crea tu cuenta como aprendiz para ingresar al sistema</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 login-right login-right-register">
                <img src="{{ asset('img/persa-logo.png') }}" alt="register" class="img-fluid logo-persa">
                <div class="login-tabs">
                    <a href="{{ route('auth.login') }}" class="tab-button">Iniciar sesión</a>
                    <span class="tab-button active">Registrarse</span>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.store') }}" class="form-login form-login-register">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mb-3">
                            <input type="text" name="document" class="form-control" placeholder="Documento" value="{{ old('document') }}">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <select class="form-control" name="course_id" required>
                                <option value="">Seleccione una ficha:</option>
                                @if(isset($courses))
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->number_group }} - {{ $course->career->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <input type="text" name="name" class="form-control" placeholder="Nombres" value="{{ old('name') }}">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <input type="text" name="lastname" class="form-control" placeholder="Apellidos" value="{{ old('lastname') }}">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" value="{{ old('email') }}">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <input type="email" name="email_confirmation" class="form-control" placeholder="Confirmar correo electrónico" value="{{ old('email_confirmation') }}">
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <div class="input-password-wrapper">
                                <input type="password" id="password" name="password" class="form-control password-input" placeholder="Contraseña" required>
                                <i class="fa fa-eye toggle-password-icon" toggle="#password"></i>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <div class="input-password-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control password-input" placeholder="Confirmar contraseña" required>
                                <i class="fa fa-eye toggle-password-icon" toggle="#password_confirmation"></i>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-login w-100 mt-3">
                        Registrarse
                    </button>
                    <div class="forgot-password text-center mt-2">
                        <a href="{{ route('auth.login') }}">Ya tengo una cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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