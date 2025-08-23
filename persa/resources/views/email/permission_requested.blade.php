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
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ $message->embed(asset('img/persa-logo-readme.png')) }}" alt="Logo Persa">
        <img src="{{ $message->embed(asset('img/sena-logo.png')) }}" alt="Logo SENA">
    </div>

    <div class="content">
        <h1>Salida del aprendiz</h1>
        <p>Aprendiz <strong>{{ $apprentice->fullname }}</strong>. El guarda ha <strong>aprobado</strong> su salida.</p>

        <!-- Datos del aprendiz -->
        <div class="section-title">Datos del aprendiz</div>
        <table class="info-table">
            <tr><td class="label">Nombre</td><td>{{ $apprentice->fullname }}</td></tr>
            <tr><td class="label">Correo</td><td>{{ $apprentice->email }}</td></tr>
            <tr><td class="label">Estado</td><td>{{ $apprentice->status }}</td></tr>
        </table>

        <!-- Ficha -->
        <div class="section-title">Ficha</div>
        <table class="info-table">
            <tr><td class="label">Número</td><td>#{{ $course->id }}</td></tr>
            <tr><td class="label">Programa</td><td>{{ $course->career->name }} ({{ $course->career->type }})</td></tr>
        </table>

        <!-- Datos del permiso -->
        <div class="section-title">Permiso</div>
        <table class="info-table">
            <tr><td class="label">Fecha</td><td>{{ $permission->permission_date }}</td></tr>
            <tr><td class="label">Hora de inicio</td><td>{{ $permission->start_time }}</td></tr>
            <tr><td class="label">Hora de fin</td><td>{{ $permission->end_time }}</td></tr>
            <tr><td class="label">Hora de salida</td><td>{{ $permission->departure_time }}</td></tr>
            <tr><td class="label">Motivo</td><td>{{ $permission->reasons }}</td></tr>
            <tr><td class="label">Tipo</td><td>{{ $permission->type->name }}</td></tr>
            <tr><td class="label">Lugar</td><td>{{ $permission->location->name }} - {{ $permission->location->address }}</td></tr>
            <tr><td class="label">Estado</td><td style="color: green;"><strong>{{ $permission->status }}</strong></td></tr>
        </table>
    </div>

    <div align="center">
        <em>Persa - Este es un correo generado automáticamente.
            Por favor, no responda a este mensaje.
        </em>
    </div>
</div>
</body>
</html>

