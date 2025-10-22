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
                    title: 'Reporte de {{ ucfirst($viewMode) }}',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'd-none',
                    title: 'Reporte de {{ ucfirst($viewMode) }}',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ':not(:last-child)'
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


    <script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#table_data')) {
            $('#table_data').DataTable().destroy();
        }

        const table = $('#table_data').DataTable({
            pageLength: 10,
            lengthChange: false,
            language: {
                paginate: { previous: "Anterior", next: "Siguiente" },
                search: "Buscar:",
                info: "Mostrando START a END de TOTAL registros",
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
                    exportOptions: { columns: ':not(:last-child)' },
                    customize: function (doc) {
                        doc.pageOrientation = 'portrait';
                        doc.pageMargins = [7, 0, 0, 7];
                        doc.defaultStyle.fontSize = 10;
                        doc.defaultStyle.font = 'Roboto';

                        doc.content.splice(0, 0, 
                            {
                                image: 'data:image/png;base64,{{ base64_encode(file_get_contents(public_path("img/persa-logo.png"))) }}',
                                width: 320,
                                alignment: 'center',
                                margin: [10, 10, 10, 10]
                            }
                        );

                        doc.content.splice(2, 0, {
                            text: 'Generado el: {{ date("Y-m-d (H:i:s)") }}',
                            fontSize: 11,
                            margin: [0, 0, 0, 20],
                            alignment: 'left'
                        });

                        doc.styles.tableHeader = {
                            fillColor: '#39a900',
                            color: 'white',
                            bold: true,
                            fontSize: 11,
                            alignment: 'center',
                            margin: [0, 5, 0, 5]
                        };

                        var rowCount = doc.content[doc.content.length - 1].table.body.length;
                        for (var i = 1; i < rowCount; i++) {
                            if (i % 2 === 0) {
                                doc.content[doc.content.length - 1].table.body[i].forEach(function(cell) {
                                    cell.fillColor = '#f2f2f2';
                                });
                            }
                            doc.content[doc.content.length - 1].table.body[i].forEach(function(cell) {
                                cell.alignment = 'center';
                            });
                        }

                        doc.content[doc.content.length - 1].layout = {
                            hLineWidth: function (i, node) { return 0.2; }, 
                            vLineWidth: function (i, node) { return 0.2; }, 
                            hLineColor: function (i, node) { return '#000000'; }, 
                            vLineColor: function (i, node) { return '#000000'; }, 
                        };

                        doc.footer = function(currentPage, pageCount) {
                            return {
                                columns: [
                                    {
                                        text: 'Generado por Persa 1.0',
                                        alignment: 'center',
                                        fontSize: 8,
                                        italics: true,
                                        margin: [0, 0, 0, 10]
                                    },
                                    {
                                        text: currentPage.toString() + ' de ' + pageCount,
                                        alignment: 'right',
                                        fontSize: 8,
                                        margin: [0, 0, 40, 0]
                                    }
                                ]
                            };
                        };
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
