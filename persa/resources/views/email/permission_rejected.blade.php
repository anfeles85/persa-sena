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
            color: #d32f2f;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            color: #d32f2f;
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
            border-left: 4px solid #d32f2f;
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
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ $message->embed(asset('img/persa-logo-readme.png')) }}" alt="Logo Persa">
        <img src="{{ $message->embed(asset('img/sena-logo.png')) }}" alt="Logo SENA">
    </div>

    <div class="content">
        <h1>Permiso Rechazado</h1>
        <p>Aprendiz <strong>{{ $apprentice->fullname ?? 'N/A' }}</strong>, lamentamos informarle que su solicitud de permiso ha sido <strong>rechazada</strong>.</p>

        <div class="section-title">Información del Permiso:</div>
        <table class="info-table">
            <tr>
                <td class="label">Fecha del Permiso:</td>
                <td>{{ $permission->permission_date ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Hora de Inicio:</td>
                <td>{{ $permission->start_time ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Hora de Fin:</td>
                <td>{{ $permission->end_time ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Motivo:</td>
                <td>{{ $permission->reasons ?? 'N/A' }}</td>
            </tr>
        </table>

        @if(isset($reason) && $reason)
        <div class="section-title">Motivo del Rechazo:</div>
        <div class="reason-box">
            <p style="margin: 0;">{{ $reason }}</p>
        </div>
        @endif

        <p>Si tiene alguna pregunta o necesita más información, por favor contacte a su instructor.</p>
    </div>

    <div class="footer">
        <em>Persa - Este es un correo generado automáticamente.
            Por favor, no responda a este mensaje.
        </em>
    </div>
</div>
</body>
</html>
