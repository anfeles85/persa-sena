<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reestablecer Contraseña</title>
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #ddd;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .header {
            background-color: #f6f6f6;
            text-align: center;
            padding: 25px;
        }
        .header img {
            height: 60px;
            margin: 0 15px;
        }
        .content {
            padding: 30px 25px;
            line-height: 1.6;
        }
        .content h1 {
            font-size: 22px;
            color: #004080;
            margin-bottom: 20px;
            text-align: center;
        }
        .content p {
            font-size: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #004080;
            color: #fff !important;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #003366;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding: 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
        }
        .footer em {
            color: #555;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header con logos -->
    <div class="header">
        <img src="{{ $message->embed(asset('img/persa-logo.png')) }}" alt="Logo Persa">
        <img src="{{ $message->embed(asset('img/sena-logo.png')) }}" alt="Logo SENA">
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <h1>Reestablece tu contraseña</h1>

        <p>Has solicitado cambiar tu contraseña. Haz clic en el botón a continuación para continuar con el proceso.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('reset.password.get', $token) }}" class="btn">Reestablecer Contraseña</a>
        </div>

        <p style="font-size: 13px; color: #666;">
            Si no solicitaste este cambio, simplemente ignora este mensaje.
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <em>Persa - Este es un correo generado automáticamente.<br>
            Por favor, no respondas a este mensaje.</em>
    </div>
</div>
</body>
</html>
