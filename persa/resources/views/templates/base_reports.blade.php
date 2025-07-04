<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
</head>
<body>
    <section id="header">
        <table width="100%" style="border-collapse:collapse; border: 1px solid">
            <tr>
                <th>
                    <div style="text-align: center">
                        <img src="{{ asset('img/persa-logo.png') }}" alt="logo">
                        <img src="{{ asset('img/sena-logo.png') }}" alt="logo">
                    </div>
                </th>
                <th>
                    <p style="text-align: center; font-size: 14px">
                        @yield('header')
                    </p> 
                </th> 
            </tr>
        </table>
    </section>
    <br>
    <form action="reporte.php" method="GET">
        <label for="fecha_inicio">Desde:</label>
        <input type="date" name="created_at" required>

        <label for="fecha_fin">Hasta:</label>
        <input type="date" name="created_at" required>
    </form>
    <br>
        <form action="buscar_permiso.php" method="GET">
            <label for="documento">Documento del aprendiz:</label>
            <input type="text" id="apprendice_course" name="apprendice_course" required>
        </form>
    <br>
        <form action="permisos_por_ficha.php" method="GET">
            <label for="ficha">Número de ficha:</label>
            <input type="text" id="course" name="course" required>
        </form>
    <br>


    <section id="infoReport">
        <p style="font-size: 14px">
            <strong>Fecha reporte: </strong>
            @php
                $time = time();
                echo date('Y-m-d (H:i:s)', $time);
            @endphp
        </p>
    </section>

    <br>

    @yield('content')

    <footer id="version_text">
        <p>Generado por Persa 1.0</p>
    </footer>

</body>
</html>