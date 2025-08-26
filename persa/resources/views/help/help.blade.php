@extends('templates.base')
@section('title', 'Manual de ayuda')
@section('header', 'Manual de ayuda')

@push('styles')
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
@endpush

@section('content')
<main class="main-content position-relative h-auto border-radius-lg">
    <div class="container-fluid py-2">

        {{-- Título --}}
        <div class="mb-4 px-2 text-center text-md-start">
            <h3 class="mb-2 h4 font-weight-bolder">Manual de ayuda</h3>
            <p class="mb-0 text-muted">
                Bienvenido a la sección de ayuda de Persa. Aquí encontrarás guías
                    para registrarte, iniciar sesión, recuperar o cambiar tu contraseña
                    y resolver dudas frecuentes.
            </p>
        </div>

         {{-- Contenido de ayuda --}}
        <div class="px-2">
            <h5 class="fw-bold mt-4"><i class="fas fa-sign-in-alt me-2"></i> Cómo iniciar sesión</h5>
            <p>Para iniciar sesión, dirígete a la página de acceso e ingresa tu correo electrónico y contraseña registrados. Si tus datos son correctos, accederás a tu panel principal.</p>

            <h5 class="fw-bold mt-4"><i class="fas fa-key me-2"></i> Cómo recuperar contraseña</h5>
            <p>Si olvidaste tu contraseña, haz clic en la opción <strong>"¿Olvidaste tu contraseña?"</strong> en la pantalla de inicio de sesión. Ingresa tu correo y recibirás instrucciones para restablecerla.</p>

            <h5 class="fw-bold mt-4"><i class="fas fa-user-edit me-2"></i> Cómo editar mi perfil de usuario</h5>
            <p>Accede al menú superior derecho y selecciona <strong>"Perfil"</strong>. Allí podrás modificar tu nombre, correo, foto de perfil y contraseña. No olvides guardar los cambios.</p>

            <h5 class="fw-bold mt-4"><i class="fas fa-user-graduate me-2"></i> Rol de Aprendiz</h5>
            <p>El rol de <strong>Aprendiz</strong> permite acceder a los programas de formación, consultar permisos otorgados y visualizar la información de bienestar institucional.</p>

            <h5 class="fw-bold mt-4"><i class="fas fa-chalkboard-teacher me-2"></i> Rol de Instructor</h5>
            <p>El rol de <strong>Instructor</strong> permite gestionar programas de formación, aprobar permisos de aprendices y realizar seguimientos académicos.</p>

            <h5 class="fw-bold mt-4"><i class="fas fa-hand-holding-heart me-2"></i> Rol de Bienestar</h5>
            <p>El rol de <strong>Bienestar</strong> tiene acceso a los reportes generales de aprendices, control de permisos y apoyo en el acompañamiento institucional.</p>
        </div>

    </div>
</main>
@endsection

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   
    
</script>