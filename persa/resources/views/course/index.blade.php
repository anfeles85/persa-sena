@extends('templates.base')
@section('title', 'Grupos')
@section('header', 'Grupos')
@section('content')

<label class="fs-2">Grupos</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <div class="d-flex gap-2">
        <form action="{{ route('course.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required class="form-control form-control-sm" />
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel me-1"></i> Importar Excel de Fichas
            </button>
        </form>
        <a href="{{ route('course.create') }}" class="btn btn-success">Crear</a>
        
        
        <a href="{{ asset('template_excel/cursos.xlsx') }}" class="btn btn-primary d-flex align-items-center justify-content-center" download="cursos.xlsx">
            <i class="fas fa-file-download me-1"></i> Plantilla
        </a>
        
        
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
                            
                            <a href="{{ route('course.edit', $course->id) }}" 
                                class="btn btn-primary btn-circle table-btn w-100 w-md-auto" 
                                title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            
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

 
<div id="helpWindowContent" class="d-none help-popup">
    <div class="help-content-box">
        <h4>Formato Requerido para Importación de Grupos</h4>
        <p>La hoja de cálculo para la importación de grupos debe contener exactamente los siguientes encabezados en la primera fila. La información de cada columna debe seguir el formato del ejemplo:</p>

        <table class="table-bordered help-table">
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Descripción</th>
                    <th>Ejemplo</th>
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
            <img src="{{ asset('template_excel/Example_course.jpeg') }}" alt="Ejemplo de archivo Excel/CSV para importación de grupos" class="help-img img-fluid" />
        </div>

        <div class="alert-info help-alert">
            Utilice el botón "Plantilla" para descargar un archivo con los encabezados listos para ser diligenciados.
        </div>
        <div class="text-end mt-3">
             <button class="help-close-btn" onclick="window.close()">Cerrar</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')

    <script src="{{ asset('js/general.js') }}"></script>
    
    <script>
    function openHelpWindow(e) {
        if (e && e.preventDefault) e.preventDefault();

        const el = document.getElementById('helpWindowContent');
        if (!el) {
            alert('Contenido de ayuda no encontrado.');
            return;
        }

        const content = el.innerHTML;
        const baseTag = document.querySelector('base');
        const baseHref = baseTag ? baseTag.href : window.location.origin + '/';
        const customCss = @json(asset('css/custom.css?v=2.1.0'));

        const helpWindow = window.open('', 'Ayuda_de_exportacion', 'width=900,height=700,scrollbars=yes,resizable=yes');
        if (!helpWindow) {
            alert('Popup bloqueado. Por favor permite popups para este sitio.');
            return;
        }

        try {
            helpWindow.document.open();
            helpWindow.document.write('<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Ayuda de exportación - Grupos</title>');
            helpWindow.document.write('<base href="' + baseHref + '">');
            helpWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            helpWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">');
            helpWindow.document.write('<link rel="stylesheet" href="' + customCss + '">');
            helpWindow.document.write('</head><body class="help-window-body">');
            helpWindow.document.write(content);
            helpWindow.document.write('</body></html>');
            helpWindow.document.close();
        } catch (err) {
            console.error('Error abriendo ventana de ayuda:', err);
            alert('No se pudo abrir la ventana de ayuda.');
        }
    }
    </script>
@endsection