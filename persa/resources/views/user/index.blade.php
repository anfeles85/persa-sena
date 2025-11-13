@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

@section('content')



<label class="fs-2">Usuarios</label>

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
    
        <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required class="form-control form-control-sm" style="width:200px;">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-file-excel me-1"></i> Importar Excel Instructores
            </button>
        </form>
    </div>
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-flex justify-content-md-start">
        <a href="{{ route('user.create') }}" class="btn btn-success">Crear</a>
        
        
        <button id="exportExcelBtn" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button id="exportPdfBtn" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> PDF
        </button>

        
        <a href="{{ asset('template_excel/usuarios.xlsx') }}" class="btn btn-primary d-flex align-items-center justify-content-center" download="usuarios.xlsx">
            <i class="fas fa-file-download me-1"></i> Plantilla
        </a>
        
        
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
                                
                                <a href="{{ route('user.edit', $user->id) }}"
                                    class="btn btn-primary btn-circle table-btn w-100"
                                    title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>

                                
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


<div id="helpWindowContent" class="d-none help-popup">
    <div class="help-content-box">
        <h4>Formato Requerido para Importación de Usuarios</h4>
        <p>La hoja de cálculo para la importación de usuarios debe contener exactamente los siguientes encabezados en la primera fila. La información de cada columna debe seguir el formato del ejemplo:</p>

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
            </tbody>
        </table>

        <h6>Ejemplo visual del archivo de importación:</h6>
        <div class="text-center">
            <img src="{{ asset('template_excel/Example_user.jpeg') }}" alt="Ejemplo de archivo Excel/CSV para importación de usuarios" class="help-img img-fluid" />
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

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

        const helpWindow = window.open('', 'AyudaImportacion', 'width=900,height=700,scrollbars=yes,resizable=yes');
        if (!helpWindow) {
            alert('Popup bloqueado. Por favor permite popups para este sitio.');
            return;
        }

        try {
            helpWindow.document.open();
            helpWindow.document.write('<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Ayuda de Importación</title>');
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

                        doc.pageMargins = [35, 80, 35, 45];
                        doc.defaultStyle = {
                            fontSize: 9,
                            color: '#333333'
                        };
                        doc.styles.tableHeader = {
                            fillColor: '#27AE60',
                            color: '#FFFFFF',
                            bold: true,
                            fontSize: 10,
                            alignment: 'center'
                        };

                        doc.header = function() {
                            return {
                                margin: [35, 15, 35, 0],
                                stack: [
                                    {
                                        columns: [
                                            {
                                                image: 'data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/persa-logo.png"))) }}',
                                                width: 60,
                                                alignment: 'left'
                                            },
                                            {
                                                text: 'REPORTE DE USUARIOS',
                                                bold: true,
                                                fontSize: 16,
                                                color: '#27AE60',
                                                alignment: 'center',
                                                margin: [0, 15, 0, 0]
                                            }
                                        ]
                                    },
                                    {
                                        canvas: [{
                                            type: 'line',
                                            x1: 0, y1: 0, x2: 520, y2: 0,
                                            lineWidth: 1.5,
                                            lineColor: '#27AE60'
                                        }],
                                        margin: [0, 5, 0, 0]
                                    },
                                    {
                                        text: 'Generado el {{ date("d/m/Y H:i:s") }}',
                                        fontSize: 9,
                                        italics: true,
                                        alignment: 'right',
                                        color: '#666',
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
                                            x1: 0, y1: 0, x2: 520, y2: 0,
                                            lineWidth: 1,
                                            lineColor: '#E0E0E0'
                                        }],
                                        margin: [0, 0, 0, 8]
                                    },
                                    {
                                        text: 'Página ' + currentPage + ' de ' + pageCount + ' – Generado por PERSA 1.0',
                                        alignment: 'center',
                                        fontSize: 9,
                                        italics: true,
                                        color: '#666'
                                    }
                                ]
                            };
                        };

                        const tableNode = doc.content[doc.content.length - 1];
                        if (tableNode && tableNode.table) {
                            const rowCount = tableNode.table.body.length;
                            tableNode.table.widths = new Array(tableNode.table.body[0].length).fill('*');
                            tableNode.alignment = 'center';
                            tableNode.margin = [0, 10, 0, 0];

                            for (let i = 1; i < rowCount; i++) {
                                tableNode.table.body[i].forEach(cell => {
                                    cell.fillColor = (i % 2 === 0) ? '#C8E6C9' : '#FFFFFF';
                                    cell.alignment = 'center';
                                    cell.fontSize = 9;
                                    cell.margin = [5, 5, 5, 5];
                                });
                            }

                            tableNode.layout = {
                                hLineWidth: (i, node) => (i === 0 || i === node.table.body.length) ? 1 : 0.5,
                                vLineWidth: () => 0.5,
                                hLineColor: () => '#E0E0E0',
                                vLineColor: () => '#E0E0E0'
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