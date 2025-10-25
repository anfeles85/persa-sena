<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PERSA</title>
    <link rel="stylesheet" href="{{ asset('css/report.css') }}">
    <style>
        @page {
            margin: 40px 40px 50px 40px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
        }
    </style>
</head>
<body>
    <section id="header">
        <table width="100%" style="border-collapse:collapse; border: 2px solid rgb(39, 174, 96);">
            <tr>
                <th style="width: 25%; padding: 15px; vertical-align: middle;">
                    <div style="text-align: center;">
                        <img src="{{ asset('img/persa-logo.png') }}" 
                             alt="Logo PERSA" 
                             style="max-height: 60px; max-width: 180px;">
                    </div>
                </th>
                <th style="width: 75%; padding: 15px; vertical-align: middle;">
                    <div class="title-section">
                        <h1 class="report-title" style="font-size: 20px; font-weight: bold; color: rgb(39, 174, 96); margin: 10px 0; text-transform: uppercase;">
                            @yield('header')
                        </h1>
                        @hasSection('subtitle')
                            <div class="report-subtitle" style="font-size: 12px; color: rgb(30, 132, 73); margin: 8px 0; text-align: left;">
                                @yield('subtitle')
                            </div>
                        @endif
                    </div>
                </th>
            </tr>
        </table>
        
        <div class="line-separator" style="height: 2px; background-color: rgb(39, 174, 96); margin: 10px 0;"></div>
    </section>

    <section id="infoReport">
        <p style="font-size: 10px; font-style: italic; color: #666; text-align: right; margin: 5px 0;">
            <strong style="color: #333;">Generado el: </strong>
            @php
                date_default_timezone_set('America/Bogota');
                echo date('d/m/Y H:i:s');
            @endphp
        </p>
    </section>

    <section id="content" style="margin-top: 15px;">
        @yield('content')
    </section>

    <footer id="version_text">
        <p style="text-align: center; font-size: 9px; font-style: italic; color: #666; margin-top: 30px; padding-top: 10px; border-top: 1px solid #e0e0e0;">
            Página <span class="pagenum"></span> – Generado por PERSA 1.0
        </p>
    </footer>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 9;
            $font = $fontMetrics->getFont("Helvetica");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>
</html>