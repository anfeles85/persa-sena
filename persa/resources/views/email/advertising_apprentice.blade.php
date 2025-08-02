<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        body{
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: Arial, Helvetica, sans-serif;
        }

        img{
            display: block;
            height: auto;
            border: 0;
            width: 25%;
        }

        pre{
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
    <div align="center">
        <img src="{{ $message->embed(asset('img/persa-logo.png')) }}" alt="logo-persa" >
        <img src="{{ $message->embed(asset('img/sena-logo.png')) }}" alt="logo-sena" >
    </div>

    <div align="justify">
        <p>Aprendiz <strong>{{ $apprentice->fullname }}</strong></p>
        <p>Programa de formación: {{ $apprentice->course->career->name }}</p>
        <p>Jornada: {{ $apprentice->course->shift }}</p>
    </div>

    <br><hr>

    <div align="center">
        <em>Persa 1.0. Este es un correo generado automáticamente.
            Por favor, no responda a este mensaje.
        </em>
    </div>
</body>
</html>
