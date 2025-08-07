<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
                <div class="col-lg-6 login-left">
                    <div class="logo-container">
                        <div class="logo">
                            <img src="{{ asset('img/sena-logo.png') }}" alt="SENA Logo">
                        </div>
                        <div class="text-logo">
                            <h2 class="system-title">P.E.R.S.A</h2>
                            <p class="system-subtitle">Bienvenido al sistema de permisos de salidas de aprendices del SENA.</p>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6 login-right">
                    <img src="{{ asset('img/persa-logo.png') }}" alt="register" class="img-fluid logo-persa">
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
                            <input type="text" name="email" class="form-control" placeholder="Ingrese su correo eléctronico" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Ingrese su contraseña" required>
                        </div>

                        <button type="submit" class="btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            INGRESAR
                        </button>
                    </form>

                    <div class="forgot-password">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
</body>
</html>