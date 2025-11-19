<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permiso Aprobado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
       body {
            background-color: #f4f4f4;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ddd;
        }
        .header {
            background-color: #f6f6f6;
            text-align: center;
            padding: 20px;
        }
        .header img {
            height: 60px;
            margin: 0 10px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            font-size: 22px;
            color: #39A900;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #39A900;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }
        .info-table td.label {
            background-color: #f0f0f0;
            font-weight: bold;
            width: 40%;
        }
        .reason-box {
            background-color: #ffebee;
            border-left: 4px solid #39A900;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 15px;
            background-color: #f4f4f4;
        }
    </style>
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <img class="persa-logo" src="{{ $message->embed(asset('img/persa-logo.png')) }}" alt="Logo Persa">
                <h1 class="header-title">¡PERMISO APROBADO!</h1>
            </div>
            <div class="content">
                <div class="greeting">
                    <strong>{{ $apprentice->fullname }}</strong>,<br>
                    Tu solicitud de permiso ha sido aprobada por tu instructor.
                </div>
                <div class="info-card">
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="info-content">
                            <div class="info-label">Instructor</div>
                            <div class="info-value">{{ $permission->instructor_user ? $permission->instructor_user->fullname : 'No asignado' }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-clipboard-list"></i></div>
                        <div class="info-content">
                            <div class="info-label">Ficha</div>
                            <div class="info-value">#{{ $course->number_group }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-calendar-check"></i></div>
                        <div class="info-content">
                            <div class="info-label">Fecha del Permiso</div>
                            <div class="info-value">{{ $permission->permission_date }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div class="info-content">
                            <div class="info-label">Horario</div>
                            <div class="info-value">{{ $permission->start_time }} - {{ $permission->end_time }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <div class="info-label">Lugar</div>
                            <div class="info-value">{{ $permission->location?->name }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-comment-alt"></i></div>
                        <div class="info-content">
                            <div class="info-label">Motivo</div>
                            <div class="info-value">{{ $permission->reasons }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <strong>PERSA - Sistema de Permisos SENA</strong><br>
                Este es un correo automático. Por favor, no responder.
            </div>
        </div>
    </div>
</body>
</html>
