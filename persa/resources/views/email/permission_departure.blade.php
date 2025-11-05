<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida Registrada</title>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .header {
            background: linear-gradient(135deg, #0066cc 0%, #004999 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            margin-bottom: 20px;
        }
        .logo-container img {
            height: 80px;
            background: transparent;
            padding: 0;
            border: none;
            box-shadow: none;
        }
        .header-title {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .status-badge {
            background: #ffffff;
            color: #0066cc;
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 30px;
            line-height: 1.6;
            text-align: center;
        }
        .greeting strong {
            color: #0066cc;
        }
        .highlight-box {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 5px solid #28a745;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: center;
        }
        .highlight-time {
            font-size: 36px;
            font-weight: bold;
            color: #28a745;
            margin: 10px 0;
        }
        .highlight-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            font-weight: 600;
        }
        .info-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
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
            background: #0066cc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            color: white;
            font-size: 18px;
            font-weight: bold;
        }
        .info-content {
            flex: 1;
        }
        .info-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
            font-weight: 600;
        }
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 12px;
            border-top: 3px solid #0066cc;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="container">
            <!-- Header con logos -->
            <div class="header">
                <div class="logo-container">
                    <img src="{{ $message->embed(asset('img/persa-logo-readme.png')) }}" alt="Logo Persa">
                </div>
                <h1 class="header-title">¡SALIDA REGISTRADA!</h1>
                <div class="status-badge">✓ PERMISO COMPLETADO</div>
            </div>

            <!-- Contenido -->
            <div class="content">
                <div class="greeting">
                    <strong>{{ $apprentice->fullname }}</strong>,<br>
                    Tu salida ha sido registrada exitosamente por el personal de guardia.
                </div>

                <!-- Hora de salida destacada -->
                <div class="highlight-box">
                    <div class="highlight-label">Hora de Salida Registrada</div>
                    <div class="highlight-time">{{ $permission->departure_time }}</div>
                </div>

                <!-- Información del permiso -->
                <div class="info-card">
                    <div class="info-row">
                        <div class="info-icon">👤</div>
                        <div class="info-content">
                            <div class="info-label">Instructor Aprobador</div>
                            <div class="info-value">{{ $permission->instructor_user?->fullname ?? 'No asignado' }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📋</div>
                        <div class="info-content">
                            <div class="info-label">Ficha</div>
                            <div class="info-value">#{{ $course->number_group }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📅</div>
                        <div class="info-content">
                            <div class="info-label">Fecha del Permiso</div>
                            <div class="info-value">{{ $permission->permission_date }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">🕐</div>
                        <div class="info-content">
                            <div class="info-label">Horario Autorizado</div>
                            <div class="info-value">{{ $permission->start_time }} - {{ $permission->end_time }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <div class="info-label">Lugar</div>
                            <div class="info-value">{{ $permission->location?->name }}</div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-icon">📝</div>
                        <div class="info-content">
                            <div class="info-label">Motivo</div>
                            <div class="info-value">{{ $permission->reasons }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <strong>PERSA - Sistema de Permisos SENA</strong><br>
                Este es un correo automático. Por favor, no responder.
            </div>
        </div>
    </div>
</body>
</html>
        
        <div class="highlight">
            <p><strong>{{ $permission->apprentice_user->fullname }}</strong>, el guarda de seguridad ha registrado tu salida.</p>
            <p>Tu permiso ha sido completado exitosamente.</p>
        </div>

        <!-- Datos del aprendiz -->
        <div class="section-title">Datos del aprendiz</div>
        <table class="info-table">
            <tr><td class="label">Nombre</td><td>{{ $permission->apprentice_user->fullname }}</td></tr>
            <tr><td class="label">Correo</td><td>{{ $permission->apprentice_user->email }}</td></tr>
            <tr><td class="label">Documento</td><td>{{ $permission->apprentice_user->document }}</td></tr>
        </table>

        @if($permission->apprentice_user->courses->isNotEmpty())
        <!-- Ficha -->
        <div class="section-title">Ficha</div>
        <table class="info-table">
            @php
                $course = $permission->apprentice_user->courses->first();
            @endphp
            <tr><td class="label">Número de Ficha</td><td>#{{ $course->number_group }}</td></tr>
            <tr><td class="label">Programa</td><td>{{ $course->career?->name }}</td></tr>
        </table>
        @endif

        <!-- Datos del permiso -->
        <div class="section-title">Detalles del Permiso</div>
        <table class="info-table">
            <tr><td class="label">Fecha</td><td>{{ \Carbon\Carbon::parse($permission->permission_date)->format('d/m/Y') }}</td></tr>
            <tr><td class="label">Hora de inicio</td><td>{{ $permission->start_time }}</td></tr>
            <tr><td class="label">Hora de fin</td><td>{{ $permission->end_time }}</td></tr>
            <tr><td class="label">Motivo</td><td>{{ $permission->reasons }}</td></tr>
            <tr><td class="label">Tipo</td><td>{{ $permission->permissionType?->name }}</td></tr>
            <tr><td class="label">Lugar</td><td>{{ $permission->location?->name }} - {{ $permission->location?->address }}</td></tr>
            <tr><td class="label">Hora de Salida Registrada</td><td style="color: #4caf50;"><strong>{{ $permission->departure_time }}</strong></td></tr>
            <tr><td class="label">Estado</td><td style="color: green;"><strong>{{ $permission->status }}</strong></td></tr>
        </table>

        <p style="margin-top: 20px; color: #666;">
            Tu permiso fue aprobado por el instructor y la salida ha sido registrada por el personal de seguridad.
        </p>
    </div>

    <div align="center">
        <em>Persa - Este es un correo generado automáticamente.
            Por favor, no responda a este mensaje.
        </em>
    </div>
</div>
</body>
</html>
