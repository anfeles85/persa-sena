<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('img/sena-logo.png') }}">
    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Argon Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.css') }}?v=2">
    <link rel="stylesheet" href="{{ asset('css/argon-dashboard.min.css') }}?v=2">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v=2">
</head>
<body>
    <div class="login-container body-login">
        <div class="login-card">
            <div class="row g-0 h-100">
                <!-- Columna izquierda -->
                <div class="col-lg-6 login-left d-flex flex-column justify-content-center align-items-center text-center p-4">
                    <div class="logo mb-3">
                        <img src="{{ asset('img/sena-logo.png') }}" 
                             alt="SENA Logo" 
                             class="img-fluid" 
                             style="max-width: 160px; height: auto;">
                    </div>
                    <div class="text-logo">
                        <h2 class="system-title mb-2">P.E.R.S.A</h2>
                        <p class="system-subtitle mb-0">
                            Bienvenido al sistema de permisos de salidas de aprendices del SENA.
                        </p>
                    </div>
                </div>

                <!-- Columna derecha -->
                <div class="col-lg-6 login-right">
                    <img src="{{ asset('img/persa-logo.png') }}" 
                         alt="register" 
                         class="img-fluid logo-persa">

                    <div class="login-tabs">
                        <span class="tab-button active">Iniciar sesión</span>
                        <a href="{{ route('auth.register') }}" class="tab-button">Registrarse</a>
                    </div>

                    @if($errors->any())
                        <div class="alert no-credentials">
                            <ul style="margin-bottom: 0;">
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

                    <form class="login-form" action="{{ route('auth.login') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <input type="text" 
                                   name="email" 
                                   class="form-control" 
                                   placeholder="Ingrese su correo eléctronico" 
                                   value="{{ old('email') }}" 
                                   required>
                        </div>

                        <div class="form-group">
                            <div class="input-password-wrapper">
                                <input type="password" 
                                       id="password-login"
                                       name="password" 
                                       class="form-control password-input" 
                                       placeholder="Ingrese su contraseña" 
                                       required>
                                <i class="fa fa-eye toggle-password-icon" toggle="#password-login"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Recordar contraseña
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            INGRESAR
                        </button>

                        <div class="form-group text-center" 
                             style="display: flex; justify-content: center; align-items: center; margin: 5px 0; padding: 5px;">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display(['data-theme' => 'light']) !!}
                        </div>
                    </form>
                    
                    <div class="forgot-password">
                        <a href="{{ route('auth.forget-password') }}">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
        <a class="help" href="{{ route('help.help') }}" target="_blank">
            <button class="Btn">
                <i class="fa-solid fa-question btn-help"></i>
                <span class="tooltip">¿Necesitas ayuda?</span>
            </button>
        </a>
    </div>
    <!-- Script pestañas -->
    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.textContent.includes('Registrarse')) {
                    window.location.href = "{{ route('auth.register') }}";
                }
            });
        });
    </script>

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

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡OK!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    
</body>
</html>
