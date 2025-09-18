@extends('templates.base')

@section('title', 'Permisos')
@section('header', 'Permisos')

@section('content')

<label class="fs-2">Permisos</label>

@if(Auth::user()->role_id == 3)
    <div class="row">
        <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
            <a href="{{ route('permission.create') }}" class="btn btn-success">Crear</a>
        </div>
    </div>
@endif

<form method="GET" action="{{ route('permission.index') }}" class="row g-2 mb-3">

    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="col-12 col-md-auto">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control"
                   placeholder="Documento o nombre...">
        </div>
    @endif

    <div class="col-12 col-md-auto">
        <select name="status" class="form-control">
            <option value="">Estado</option>
            <option value="PENDIENTE" {{ request('status')=='PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
            <option value="APROBADO"  {{ request('status')=='APROBADO' ? 'selected' : '' }}>Aprobado</option>
            <option value="RECHAZADO" {{ request('status')=='RECHAZADO' ? 'selected' : '' }}>Rechazado</option>
            <option value="CANCELADO" {{ request('status')=='CANCELADO' ? 'selected' : '' }}>Cancelado</option>
        </select>
    </div>

    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="col-12 col-md-auto">
            <select name="course_id" class="form-control">
                <option value="">Ficha</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id')==$course->id ? 'selected' : '' }}>
                        {{ $course->number_group }} - {{ $course->career->name }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif

    <div class="col-12 col-md-auto d-flex gap-2">
        <button type="submit" class="btn btn-primary flex-fill">Filtrar</button>
        <a href="{{ route('permission.index') }}" class="btn btn-secondary flex-fill">Limpiar</a>
        {{-- botones de exportación --}}
        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <button id="exportExcelBtn" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Excel
        </button>
        <button id="exportPdfBtn" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> PDF
        </button>
        @endif
    </div>
</form>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead class="align-middle text-center">
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Hora de salida</th>
                    <th>Motivo</th>
                    <th>Sede</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td data-label="Id">{{ $permission['id'] }}</td>
                        <td data-label="Fecha">{{ $permission['permission_date'] }}</td>
                        <td data-label="Hora de inicio">{{ $permission['start_time'] }}</td>
                        <td data-label="Hora de fin">{{ $permission['end_time'] }}</td>
                        <td data-label="Hora de salida">{{ $permission['departure_time'] }}</td>
                        <td data-label="Motivo">{{ $permission['reasons'] }}</td>
                        <td data-label="Sede">{{ $permission->location->name }}</td>
                        <td data-label="Estado">{{ $permission['status'] }}</td>
                        <td id="buttons_DE" style="border-top: none;">
                            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2">

                                 @if( Auth::user()->role_id == 4 && $permission['status'] == 'APROBADO')
                                    <form id="form-approve-{{ $permission['id'] }}"
                                          action="{{ route('permission.registerDeparture', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-circle table-btn w-100">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Botón de detalles visible para Coordinador/Instructor/Guarda --}}
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                    <button class="btn btn-info btn-circle table-btn w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailsModal{{ $permission->id }}"
                                            title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif

                                {{-- SOLO admin/aprendiz pueden editar --}}
                                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                    <a href="{{ route('permission.edit', $permission['id']) }}"
                                       class="btn btn-primary btn-circle table-btn w-100"
                                       title="Editar">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endif

                                {{-- Aprobar (instructor / guarda) --}}
                                
                                @if(Auth::user()->role_id == 2 )
                                    <form id="form-approve-{{ $permission['id'] }}"
                                          action="{{ route('permission.approve', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-circle table-btn w-100">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Cancelar (instructor / guarda) --}}
                                @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 4)
                                    <form id="form-cancel-{{ $permission['id'] }}"
                                          action="{{ route('permission.cancel', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-circle table-btn w-100" title="Cancelar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- SOLO aprendiz puede eliminar --}}
                                @if(Auth::user()->role_id == 3)
                                    <form id="form-delete-{{ $permission['id'] }}"
                                          action="{{ route('permission.destroy', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-circle table-btn w-100"
                                                title="Eliminar"
                                                onclick="remove(event, {{ $permission['id'] }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </td>
                    </tr>

                    {{-- Modal con detalles del permiso --}}
                    <div class="modal fade" id="detailsModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header" style="background-color: #00304D;">
                                    <h5 class="modal-title text-white">
                                        <i class="fas fa-info-circle me-2"></i>Detalles del permiso
                                    </h5>
                                </div>
                                <div class="modal-body text-black">
                                    <p class="mb-2"><strong>Número de documento: </strong>{{ $permission->apprentice_user->document }}</p>
                                    <p class="mb-2"><strong>Aprendiz: </strong>{{ $permission->apprentice_user->fullname }}</p>
                                    <p class="mb-2"><strong>Correo: </strong>{{ $permission->apprentice_user->email }}</p>
                                    <p class="mb-2"><strong>Tipo permiso: </strong>{{ $permission->permissionType->name }}</p>
                                    <p class="mb-2"><strong>Programa: </strong>{{ $permission->apprentice_user->courses->first()->career->name ?? 'No asignado' }}</p>
                                    <p class="mb-2"><strong>Tipo de programa: </strong>{{ $permission->apprentice_user->courses->first()->career->type ?? 'No asignado' }}</p>
                                    <p class="mb-0"><strong>Ficha: </strong>{{ $permission->apprentice_user->courses->first()->number_group ?? 'No asignado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    className: 'd-none',
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
