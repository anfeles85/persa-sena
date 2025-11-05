@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

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

<label class="fs-2">Usuarios</label>

{{-- Filtros de roles --}}
<form method="GET" action="{{ url()->current() }}" class="row g-2 mb-3">
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.index') }}" class="btn btn-outline-primary w-100">Todos</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.apprentices') }}" class="btn btn-outline-success w-100">Aprendices</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.instructors') }}" class="btn btn-outline-secondary w-100">Instructores</a>
    </div>
    <div class="col-6 col-md-auto d-grid">
        <a href="{{ route('user.guard') }}" class="btn btn-outline-warning w-100">Guardas</a>
    </div>
</form>

<div class="row">
    <div class="col-lg-12 mb-4 gap-2 d-md-flex justify-content-md-start">
        {{-- Formulario de importación --}}
        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required class="form-control form-control-sm" style="width:200px;">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-file-import me-1"></i> Importar Excel Instructores
            </button>
        </form>
    </div>
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-flex justify-content-md-start">
        <a href="{{ route('user.create') }}" class="btn btn-success">Crear</a>
        
        {{-- Botones de exportación --}}
        <button id="exportExcelBtn" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button id="exportPdfBtn" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> PDF
        </button>

        {{-- Botones para descargar la plantilla en excel --}}
        <a href="{{ asset('template_excel/usuarios_cursos.xlsx') }}" class="btn btn-primary d-flex align-items-center justify-content-center" download="usuarios.xlsx">
            <i class="fas fa-file-download me-1"></i> Plantilla
        </a>
        
        {{-- Botón de Ayuda de expostacion --}}
        <button id="help_import" class="btn btn-primary" onclick="openHelpWindow()" title="Ver formato de archivo de importación">
            <i class="fas fa-search me-1"></i> Ayuda de exportacion
        </button>
    </div>
</div>


<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped text-center align-items-center">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre completo</th>
                    <th>Correo</th>
                    @if($viewMode === 'aprendices')
                        <th>Ficha</th>
                    @endif
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td data-label="Documento">{{ $user->document }}</td>
                        <td data-label="Nombre completo">{{ $user->fullname }}</td>
                        <td data-label="Correo">{{ $user->email }}</td>

                        @if($viewMode === 'aprendices')
                            <td data-label="Ficha">
                                @if($user->apprenticeCourses->isNotEmpty())
                                    <ul class="list-unstyled mb-0">
                                        @foreach($user->apprenticeCourses as $course)
                                            <li>{{ $course->number_group ?? 'Sin carrera' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    N/A
                                @endif
                            </td>
                        @endif

                        <td data-label="Rol">{{ $user->role->name ?? 'Sin rol' }}</td>
                        <td data-label="Estado">{{ $user->status }}</td>
                        <td id="buttons_DE" style="border-top: none;">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 w-100">
                                {{-- Botón Editar --}}
                                <a href="{{ route('user.edit', $user->id) }}"
                                   class="btn btn-primary btn-circle table-btn w-100"
                                   title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>

                                {{-- Botón Eliminar --}}
                                <form id="form-delete-{{ $user->id }}"
                                      action="{{ route('user.destroy', $user->id) }}"
                                      method="POST" class="w-100">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            class="btn btn-danger btn-circle table-btn w-100"
                                            title="Eliminar"
                                            onclick="remove(event, {{ $user->id }})">
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

{{-- Contenido Oculto para la Ventana Pop-up (Ayuda de exportacion) --}}
<div id="helpWindowContent" style="display: none;">
    {{-- estilos para la ventana emergente --}}
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
        .table-format {
            width: 90%; 
            margin: 0 auto; 
            border-collapse: collapse;
        }
    </style>
    <div class="content-box">
        <h4><i class="fas fa-search me-2"></i> Formato Requerido para Importación de Usuarios</h4>
        <p>La hoja de cálculo para la importación de usuarios debe contener exactamente los siguientes encabezados en la primera fila. La información de cada columna debe seguir el formato del ejemplo:</p>
        
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
                    <td><code>document</code></td>
                    <td>Número de documento de identidad del usuario.</td>
                    <td><code>123456789</code></td>
                </tr>
                <tr>
                    <td><code>fullname</code></td>
                    <td>Nombre completo del usuario.</td>
                    <td><code>Juan Pérez</code></td>
                </tr>
                <tr>
                    <td><code>email</code></td>
                    <td>Correo electrónico del usuario.</td>
                    <td><code>juan.perez@sena.edu.co</code></td>
                </tr>
                <tr>
                    <td><code>password</code></td>
                    <td>Contraseña inicial.</td>
                    <td><code>123456789</code></td>
                </tr>
                <tr>
                    <td><code>status</code></td>
                    <td>Estado del usuario. Debe ser <code>ACTIVO</code> o <code>INACTIVO</code>.</td>
                    <td><code>ACTIVO</code></td>
                </tr>
                <tr>
                    <td><code>role_id</code></td>
                    <td>ID numérico del rol (debe consultar los IDs en la base de datos).</td>
                    <td><code>2</code></td>
                </tr>
            </tbody>
        </table>
        
        <h6>Ejemplo visual del archivo de importación:</h6>
        <div class="text-center">
            <img src="{{ asset('template_excel/Example_user.jpeg') }}" alt="Ejemplo de archivo Excel/CSV para importación de usuarios" class="img-fluid" />
        </div>

        <div class="alert-info">
            <i class="fas fa-exclamation-triangle me-1"></i>
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

    <script>
    // FUNCIÓN DE VENTANA POP-UP (SOLUCIÓN TIPO VISOR)
    function openHelpWindow() {
        // Obtener el contenido HTML de la ayuda (incluyendo los estilos inline)
        const content = document.getElementById('helpWindowContent').innerHTML;

        //Abrir una nueva ventana con dimensiones personalizadas
        const helpWindow = window.open('', 'AyudaImportacion', 'width=850,height=650,scrollbars=yes,resizable=yes');
        
        // Construir el documento HTML completo para la nueva ventana
        helpWindow.document.write('<!DOCTYPE html><html><head><title>Ayuda de Importación</title>');
        // Incluye Font Awesome para el icono de lupa
        helpWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">'); 
        helpWindow.document.write('</head><body>');
        
        // Escribe el contenido del DIV (que incluye los estilos y la estructura)
        helpWindow.document.write(content);
        
        helpWindow.document.write('</body></html>');
        helpWindow.document.close(); // Finaliza la escritura del documento
    }
    
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#table_data')) {
            $('#table_data').DataTable().destroy();
        }

        
        const primary = 'rgb(39, 174, 96)';
        const secondary = 'rgb(30, 132, 73)';
        const lightGreen = 'rgb(200, 230, 201)';
        const grayText = '#666';
        const tableBorder = '#e0e0e0';

        const table = $('#table_data').DataTable({
            pageLength: 10,
            lengthChange: false,
            columnDefs: [{
                targets: -1,
                visible: true,
                searchable: false,
                orderable: false
            }],
            language: {
                paginate: { previous: "Anterior", next: "Siguiente" },
                search: "Buscar:",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "No hay registros para mostrar",
                emptyTable: "No existen registros"
            },
            dom: 'frtipB',
            buttons: [
                {
                    extend: 'excelHtml5',
                    className: 'd-none',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'd-none',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: { columns: ':not(:last-child)' },

                    customize: function (doc) {

                    if (doc.content[0] && (doc.content[0].text || doc.content[0].style === 'title')) {
                        doc.content.splice(0, 1);
                    }

                    
                    if (doc.content[0]) {
                        doc.content[0].margin = [0, 20, 0, 0];
                    }

                    
                    var primary = '#27AE60';
                    var secondary = '#1E8449';
                    var lightGreen = '#C8E6C9';
                    var grayText = '#666666';
                    var tableBorder = '#E0E0E0';



                        
                        doc.pageMargins = [35, 80, 35, 45]; 
                        doc.defaultStyle = {
                            fontSize: 9,
                            color: '#333333',
                            font: 'Roboto'
                        };
                        doc.styles.tableHeader = {
                            fillColor: primary,
                            color: '#FFFFFF',
                            bold: true,
                            fontSize: 10,
                            alignment: 'center'
                        };

                        
                        doc.header = function() {
                            return {
                                margin: [0, -20, 0, 0], // Margen negativo para jalar el encabezado hacia arriba
                                stack: [
                                    {
                                        table: {
                                            widths: ['15%', '85%'], 
                                            body: [[
                                                {
                                                    image: 'data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/persa-logo.png"))) }}',
                                                    width: 80, 
                                                    alignment: 'center',
                                                    border: [false, false, false, false], 
                                                    margin: [0, 5, 0, 0] 
                                                },
                                                {
                                                    text: 'REPORTE GENERAL DE PERMISOS',
                                                    bold: true,
                                                    fontSize: 18,
                                                    color: primary,
                                                    alignment: 'center',
                                                    margin: [0, 12, 0, 8],
                                                    border: [false, false, false, false]
                                                }
                                            ]]
                                        },
                                        layout: {
                                            hLineWidth: () => 0, 
                                            vLineWidth: () => 0, 
                                            hLineColor: () => primary,
                                            vLineColor: () => primary
                                        }
                                    },
                                    {
                                        canvas: [{
                                            type: 'line',
                                            x1: 0, y1: 0, x2: 790, y2: 0, 
                                            lineWidth: 2,
                                            lineColor: primary
                                        }],
                                        margin: [0, 8, 0, 0]
                                    },
                                    {
                                        text: [
                                            { text: 'Generado el: ', bold: true, color: '#333', fontSize: 10 },
                                            { text: '{{ date("d/m/Y H:i:s") }}', color: grayText, fontSize: 10 }
                                        ],
                                        italics: true,
                                        alignment: 'right',
                                        margin: [0, 3, 10, 0]
                                    }
                                ]
                            };
                        };

                        
                        doc.footer = function(currentPage, pageCount) {
                            return {
                                margin: [35, 5, 35, 10],
                                stack: [
                                    {
                                        canvas: [{
                                            type: 'line',
                                            x1: 0, y1: 0, x2: 790, y2: 0, 
                                            lineWidth: 1,
                                            lineColor: '#e0e0e0'
                                        }],
                                        margin: [0, 0, 0, 8]
                                    },
                                    {
                                        text: 'Página ' + currentPage + ' de ' + pageCount + ' – Generado por PERSA 1.0',
                                        alignment: 'center',
                                        fontSize: 9,
                                        italics: true,
                                        color: grayText
                                    }
                                ]
                            };
                        };

                        const tableNode = doc.content[doc.content.length - 1];
                        if (tableNode && tableNode.table) {
                            
                            tableNode.table.widths = new Array(tableNode.table.body[0].length).fill('*'); 
                            tableNode.alignment = 'center';
                            tableNode.margin = [0, 10, 0, 0];

                            for (let i = 1; i < rowCount; i++) {
                                tableNode.table.body[i].forEach(cell => {
                                    cell.fillColor = (i % 2 === 0) ? lightGreen : '#fff';
                                    cell.alignment = 'center';
                                    cell.fontSize = 9;
                                    cell.margin = [5, 5, 5, 5];
                                });
                            }

                            tableNode.layout = {
                                hLineWidth: (i, node) => (i === 0 || i === node.table.body.length) ? 1 : 0.5,
                                vLineWidth: () => 0.5,
                                hLineColor: () => tableBorder,
                                vLineColor: () => tableBorder,
                                paddingLeft: () => 5,
                                paddingRight: () => 5,
                                paddingTop: () => 4,
                                paddingBottom: () => 4
                            };
                        }
                    }
                }
            ]
        });

        $('#exportExcelBtn').on('click', function(e) {
            e.preventDefault();
            table.button('.buttons-excel').trigger();
        });

        $('#exportPdfBtn').on('click', function(e) {
            e.preventDefault();
            table.button('.buttons-pdf').trigger();
        });
    });
</script>

@endsection