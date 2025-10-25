@extends('templates.base')

@section('title', 'Usuarios')
@section('header', 'Usuarios')

@section('content')

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
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-flex justify-content-md-start">
        <a href="{{ route('user.create') }}" class="btn btn-success">Crear</a>
        
        {{-- Botones de exportación --}}
        <button id="exportExcelBtn" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button id="exportPdfBtn" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> PDF
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

                    doc.pageMargins = [35, 100, 35, 45];
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
                            margin: [35, 10, 35, 0],
                            stack: [
                                {
                                    table: {
                                            widths: ['25%', '75%'],
                                            body: [[
                                                {
                                                    image: 'data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/persa-logo.png"))) }}',
                                                    width: 130,
                                                    alignment: 'center',
                                                    border: [true, true, true, true],
                                                    margin: [5, 8, 5, 8]
                                                },
                                                {
                                                    text: 'REPORTE GENERAL DE USUARIOS',
                                                    bold: true,
                                                    fontSize: 18,
                                                    color: primary,
                                                    alignment: 'center',
                                                    margin: [0, 12, 0, 8],
                                                    border: [true, true, true, true]
                                                }
                                            ]]
                                        },
                                    layout: {
                                        hLineWidth: () => 2,
                                        vLineWidth: () => 2,
                                        hLineColor: () => primary,
                                        vLineColor: () => primary
                                    }
                                },
                                {
                                    canvas: [{
                                        type: 'line',
                                        x1: 0, y1: 0, x2: 710, y2: 0,
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
                                        x1: 0, y1: 0, x2: 710, y2: 0,
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

                        const rowCount = tableNode.table.body.length;
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
