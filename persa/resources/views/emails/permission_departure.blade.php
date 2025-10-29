<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
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
            color: #004080;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #004080;
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
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 15px;
            background-color: #f4f4f4;
        }
        .highlight {
            background-color: #e8f5e9;
            padding: 15px;
            border-left: 4px solid #4caf50;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ $message->embed(asset('img/persa-logo-readme.png')) }}" alt="Logo Persa">
        <img src="{{ $message->embed(asset('img/sena-logo.png')) }}" alt="Logo SENA">
    </div>

    <div class="content">
        <h1>Salida Registrada - Permiso Aprobado</h1>
        
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
