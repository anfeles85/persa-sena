<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permiso Aprobado</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
            width: 100%;
        }
        .container {
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
        }
        .header {
            background: linear-gradient(135deg, #39A900 0%, #2d8000 100%);
            padding: 40px 20px 30px;
            text-align: center;
            position: relative;
        }
        .persa-logo {
            height: 70px;
            width: auto;
            max-width: 90%;
            display: block;
            margin: 0 auto 15px;
        }
        .header-title {
            color: white;
            font-size: clamp(20px, 5vw, 28px);
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .status-badge {
            background: #ffffff;
            color: #39A900;
            padding: 12px 25px;
            border-radius: 50px;
            display: inline-block;
            font-size: clamp(14px, 3vw, 18px);
            font-weight: bold;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: clamp(16px, 3vw, 18px);
            color: #333;
            margin-bottom: 25px;
            line-height: 1.6;
            text-align: center;
        }
        .greeting strong {
            color: #39A900;
        }
        .info-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .info-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            background: #39A900;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .info-icon i {
            color: white;
            font-size: 20px;
        }
        .info-content {
            flex: 1;
            min-width: 0;
        }
        .info-label {
            font-size: clamp(10px, 2vw, 12px);
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
            font-weight: 600;
        }
        .info-value {
            font-size: clamp(14px, 3vw, 16px);
            color: #333;
            font-weight: bold;
            word-wrap: break-word;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: clamp(11px, 2vw, 12px);
            border-top: 3px solid #39A900;
        }
        @media only screen and (max-width: 480px) {
            body {
                padding: 10px;
            }
            .container {
                border-radius: 15px;
            }
            .header {
                padding: 30px 15px 25px;
            }
            .persa-logo {
                height: 60px;
            }
            .content {
                padding: 25px 15px;
            }
            .info-card {
                padding: 15px;
            }
            .info-icon {
                width: 35px;
                height: 35px;
                min-width: 35px;
                font-size: 18px;
                margin-right: 12px;
            }
            .info-icon i {
                font-size: 18px;
            }
            .status-badge {
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <img class="persa-logo" src="{{ $message->embed(asset('img/persa-logo.png')) }}" alt="Logo Persa">
                <h1 class="header-title">¡PERMISO APROBADO!</h1>
                <div class="status-badge">✓ APROBADO Y REGISTRADO</div>
            </div>
            <div class="content">
                <div class="greeting">
                    Hola <strong>{{ $apprentice->fullname }}</strong>,<br>
                    Tu solicitud de permiso ha sido aprobada por tu instructor.
                </div>
                <div class="info-card">
                    <div class="info-row">
                        <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="info-content">
                            <div class="info-label">Instructor</div>
                            <div class="info-value">{{ $permission->instructor_user?->fullname ?? 'No asignado' }}</div>
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
