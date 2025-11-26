@extends('templates.base')
@section('title', 'Grupos')
@section('header', 'Grupos')
@section('content')

<br>
<label class="fs-2">Grupos</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-flex flex-column flex-md-row gap-2">
        <form action="{{ route('course.import') }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="d-flex flex-column flex-md-row align-items-md-center gap-2 flex-grow-1">
            @csrf
            <input type="file" 
                   name="archivo" 
                   accept=".xlsx,.xls,.csv" 
                   required 
                   class="form-control form-control-sm" />
            <button type="submit" 
                    id="importBtn" 
                    class="btn btn-primary btn-sm text-nowrap">
                <i class="fas fa-file-excel me-1"></i> Importar Excel de Fichas
            </button>
        </form>
        
        <div class="d-flex gap-2">
            <a href="{{ route('course.create') }}" class="btn btn-success">Crear</a>
            <a href="{{ asset('template_excel/cursos.xlsx') }}" 
               class="btn btn-primary" 
               download="cursos.xlsx"
               title="Descargar plantilla">
                <i class="fas fa-file-download me-1"></i> Plantilla
            </a>
            <button id="help_import" 
                    class="btn btn-primary" 
                    onclick="openHelpWindow(event)" 
                    title="Ver formato de archivo de importación">
                <i class="fas fa-search me-1"></i> Ayuda
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped text-center align-middle">
            <thead class="align-middle text-center">
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
                <tr class="d-block d-md-table-row border rounded mb-3 mb-md-0 p-2">
                    <td data-label="Id" class="fw-bold d-block d-md-table-cell">{{ $course['id'] }}</td>
                    <td data-label="Ficha" class="d-block d-md-table-cell">{{ $course['number_group'] }}</td>
                    <td data-label="Programa" class="d-block d-md-table-cell">{{ $course->career->name ?? 'Sin programa' }}</td>
                    <td data-label="Jornada" class="d-block d-md-table-cell">{{ $course['shift'] }}</td>
                    <td data-label="Trimestre" class="d-block d-md-table-cell">{{ $course['trimester'] }}</td>
                    <td data-label="Año" class="d-block d-md-table-cell">{{ $course['year'] }}</td>
                    <td data-label="Estado" class="d-block d-md-table-cell">
                        <span class="badge bg-{{ $course['status'] === 'ACTIVO' ? 'success' : 'secondary' }}">
                            {{ $course['status'] }}
                        </span>
                    </td>
                    <td data-label="Acciones" class="d-block d-md-table-cell">
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">
                            <a href="{{ route('course.edit', $course->id) }}" 
                               class="btn btn-primary btn-circle table-btn w-100 w-md-auto" 
                               title="Editar">
                                <i class="far fa-edit"></i>
                            </a>
                            <form id="form-delete-{{ $course->id }}" 
                                  action="{{ route('course.destroy', $course->id) }}" 
                                  method="POST" 
                                  class="w-100 w-md-auto">
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

<!-- Modal de ayuda (mantener igual) -->
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
                <br>
            </tbody>
        </table>

        <h6>Ejemplo visual del archivo de importación:</h6>
        <div class="text-center">
            <img src="{{ asset('template_excel/Example_course.png') }}" alt="Ejemplo de archivo Excel/CSV para importación de grupos" class="help-img img-fluid" />
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
        function openHelpWindow(event) {
            event.preventDefault();
            const helpContent = document.getElementById('helpWindowContent').innerHTML;
            const newWindow = window.open('', '_blank', 'width=900,height=700,scrollbars=yes');
            newWindow.document.write(`
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Ayuda - Formato de Importación</title>
                    <link rel="stylesheet" href="{{ asset('css/help.css') }}">
                </head>
                <body>${helpContent}</body>
                </html>
            `);
            newWindow.document.close();
        }
    </script>
@endsection