@extends('templates.base')
@section('title', 'Grupos')
@section('header', 'Grupos')
@section('content')


{{-- FIX: Código CSS inyectado para eliminar el margen superior del body y alinear el encabezado azul --}}
<style>
    body {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    /* Si tu plantilla principal usa un contenedor para todo el contenido (ej: .wrapper), también le quitamos el margen. */
    .main-content, .wrapper {
        padding-top: 0 !important;
        margin-top: 0 !important;
    }
</style>


<label class="fs-2">Grupos</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <div class="d-flex gap-2">
        <form action="{{ route('course.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required class="form-control form-control-sm" />
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-file-import me-1"></i> Importar
            </button>
        </form>
        <a href="{{ route('course.create') }}" class="btn btn-success">Crear</a>
        
        {{-- Botones para descargar la plantilla en excel --}}
        <a href="{{ asset('template_excel/cursos.xlsx') }}" class="btn btn-primary d-flex align-items-center justify-content-center" download="cursos.xlsx">
            <i class="fas fa-file-download me-1"></i> Plantilla
        </a>
        
        {{-- Botón de Ayuda de exportacion --}}
        <button id="help_import" class="btn btn-primary" onclick="openHelpWindow(event)" title="Ver formato de archivo de importación">
            <i class="fas fa-search me-1"></i> Ayuda de exportación
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Ficha</th>
                    <th>Programa</th>
                    <th>Jornada</th>
                    <th>Trimestre</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr>
                    <td data-label="Id">{{ $course['id'] }}</td>
                    <td data-label="Ficha">{{ $course['number_group'] }}</td>
                    <td data-label="Nombre">{{ $course->career->name ?? 'Sin programa' }}</td>
                    <td data-label="Jornada">{{ $course['shift'] }}</td>
                    <td data-label="Trimestre">{{ $course['trimester'] }}</td>
                    <td data-label="Año">{{ $course['year'] }}</td>
                    <td data-label="Estado">{{ $course['status'] }}</td>
                    <td id="buttons_DE" style="border-top: none;">
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 w-100">
                            {{-- Botón Editar --}}
                            <a href="{{ route('course.edit', $course->id) }}" 
                                class="btn btn-primary btn-circle table-btn w-100 w-md-auto" 
                                title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- Botón Eliminar --}}
                            <form id="form-delete-{{ $course->id }}" 
                                    action="{{ route('course.destroy', $course->id) }}" 
                                    method="POST" class="w-100 w-md-auto">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-danger btn-circle table-btn w-100 w-md-auto" 
                                        title="Eliminar"
                                        onclick="remove(event, {{ $course->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Contenido Oculto para la Ventana Pop-up (Ayuda de exportarcion) --}}
<div id="helpWindowContent" style="display: none;">
    {{-- ESTILOS para la ventana emergente --}}
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; margin: 0; }
        .content-box { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .table-primary th { background-color: #0d6efd; color: white; }
        .table-bordered th, .table-bordered td { border: 1px solid #dee2e6; padding: 8px; }
        .text-center { text-align: center; }
        .alert-info { background-color: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 5px; margin-top: 15px; border: 1px solid #bee5eb; }
        .img-fluid { max-width: 90%; height: auto; border: 1px solid #ccc; border-radius: 4px; margin-top: 10px; }
        h4 { margin-bottom: 20px; color: #0d6efd; }
        h6 { margin-top: 20px; }
        /* Estilo para la tabla de formato */
        .table-format {
            width: 90%; 
            margin: 0 auto; 
            border-collapse: collapse;
        }
    </style>
    <div class="content-box">
        <h4>Formato Requerido para Importación de Grupos</h4>
        <p>La hoja de cálculo para la importación de grupos debe contener exactamente los siguientes encabezados en la primera fila. La información de cada columna debe seguir el formato del ejemplo:</p>
        
        <table class="table-bordered table-format">
            <thead class="table-primary">
                <tr>
                    <th style="background-color: #0d6efd; color: white;">Columna</th>
                    <th style="background-color: #0d6efd; color: white;">Descripción</th>
                    <th style="background-color: #0d6efd; color: white;">Ejemplo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>number_group</code></td>
                    <td>Número de ficha del grupo (Ej: 2282218).</td>
                    <td><code>2282218</code></td>
                </tr>
                <tr>
                    <td><code>id_career</code></td>
                    <td>ID numérico de la carrera/programa asociado (debe consultar los IDs en la base de datos).</td>
                    <td><code>5</code></td>
                </tr>
                <tr>
                    <td><code>shift</code></td>
                    <td>Jornada. Debe ser <code>DIURNA</code>, <code>NOCTURNA</code> o <code>MIXTA</code>.</td>
                    <td><code>DIURNA</code></td>
                </tr>
                <tr>
                    <td><code>trimester</code></td>
                    <td>Trimestre actual (número).</td>
                    <td><code>3</code></td>
                </tr>
                <tr>
                    <td><code>year</code></td>
                    <td>Año de inicio del grupo.</td>
                    <td><code>2023</code></td>
                </tr>
                <tr>
                    <td><code>status</code></td>
                    <td>Estado del grupo. Debe ser <code>ACTIVO</code> o <code>INACTIVO</code>.</td>
                    <td><code>ACTIVO</code></td>
                </tr>
            </tbody>
        </table>
        
        <h6>Ejemplo visual del archivo de importación:</h6>
        <div class="text-center">
            <img src="{{ asset('template_excel/Example_course.jpeg') }}" alt="Ejemplo de archivo Excel/CSV para importación de grupos" class="img-fluid" />
        </div>

        <div class="alert-info">
            Utilice el botón "Plantilla" para descargar un archivo con los encabezados listos para ser diligenciados.
        </div>
        <div style="text-align: right; margin-top: 15px;">
             <button onclick="window.close()" style="padding: 8px 15px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Cerrar</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- FUNCIÓN DE VENTANA POP-UP (SOLUCIÓN TIPO VISOR) --}}
    <script>
    function openHelpWindow(e) {
        // ESTO EVITA QUE LA PÁGINA SALTE AL HACER CLIC EN EL BOTÓN
        e.preventDefault(); 
        
        // 1. Obtener el contenido HTML de la ayuda (incluyendo los estilos inline)
        const content = document.getElementById('helpWindowContent').innerHTML;

        // 2. Abrir una nueva ventana con dimensiones personalizadas
        const helpWindow = window.open('', 'Ayuda_de_exportacion', 'width=850,height=650,scrollbars=yes,resizable=yes');
        
        // 3. Construir el documento HTML completo para la nueva ventana
        helpWindow.document.write('<!DOCTYPE html><html><head><title> Ayuda de expotacion - Grupos</title>');
        // Incluye Font Awesome para los iconos
        helpWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">'); 
        helpWindow.document.write('</head><body>');
        
        // Escribe el contenido del DIV (que incluye los estilos y la estructura)
        helpWindow.document.write(content);
        
        helpWindow.document.write('</body></html>');
        helpWindow.document.close(); // Finaliza la escritura del documento
    }
    </script>
@endsection