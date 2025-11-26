@extends('templates.base')

@section('title', 'Permisos')
@section('header', 'Permisos')

@section('content')

<br>
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
            <option value="TERMINADO" {{ request('status')=='TERMINADO' ? 'selected' : '' }}>Terminado</option>
        </select>
    </div>

    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
        <div class="col-12 col-md-auto">
            <select name="course_id" class="form-control" {{ $courses->isEmpty() ? 'disabled' : '' }}>
                <option value="">
                    {{ $courses->isEmpty() ? 'Sin fichas asignadas' : 'Ficha' }}
                </option>
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

                                 @if( Auth::user()->role_id == 4 && $permission['status'] == 'APROBADO' && is_null($permission['departure_time']))
                                    <form id="form-terminate-{{ $permission['id'] }}"
                                            action="{{ route('permission.registerDeparture', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-circle table-btn w-100" title="Registrar salida">
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

                                {{-- Editar: Admin siempre puede, Aprendiz solo si está PENDIENTE --}}
                                @if(Auth::user()->role_id == 1 || (Auth::user()->role_id == 3 && $permission['status'] == 'PENDIENTE'))
                                    <a href="{{ route('permission.edit', $permission['id']) }}"
                                       class="btn btn-primary btn-circle table-btn w-100"
                                       title="Editar">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endif

                                {{-- Aprobar (SOLO instructor) - SOLO si está PENDIENTE --}}
                                
                                @if(Auth::user()->role_id == 2 && $permission['status'] == 'PENDIENTE')
                                    <form id="form-approve-{{ $permission['id'] }}"
                                          action="{{ route('permission.approve', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-circle table-btn w-100" title="Aprobar">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Rechazar (SOLO instructor) - SOLO si está PENDIENTE --}}
                                @if(Auth::user()->role_id == 2 && $permission['status'] == 'PENDIENTE')
                                    <form id="form-reject-{{ $permission['id'] }}"
                                          action="{{ route('permission.reject', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-circle table-btn w-100" title="Rechazar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- Aprendiz puede cancelar su permiso PENDIENTE --}}
                                @if(Auth::user()->role_id == 3 && $permission['status'] == 'PENDIENTE')
                                    <form id="form-cancel-{{ $permission['id'] }}"
                                          action="{{ route('permission.cancel', $permission['id']) }}"
                                          method="post" class="w-100 w-md-auto">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger btn-circle table-btn w-100" title="Cancelar solicitud">
                                            <i class="fas fa-ban"></i>
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
                                    @if($permission->apprentice_user)
                                        <p class="mb-2"><strong>Número de documento: </strong>{{ $permission->apprentice_user->document }}</p>
                                        <p class="mb-2"><strong>Aprendiz: </strong>{{ $permission->apprentice_user->fullname }}</p>
                                        <p class="mb-2"><strong>Correo: </strong>{{ $permission->apprentice_user->email }}</p>
                                    @endif
                                    
                                    @if($permission->permissionType)
                                        <p class="mb-2"><strong>Tipo permiso: </strong>{{ $permission->permissionType->name }}</p>
                                    @endif
                                    
                                    <p class="mb-2"><strong>Motivo: </strong>{{ $permission->reasons ?? 'No especificado' }}</p>
                                    <p class="mb-2"><strong>Programa: </strong>{{ $permission->apprentice_user?->courses?->first()?->career?->name ?? 'No asignado' }}</p>
                                    <p class="mb-2"><strong>Tipo de programa: </strong>{{ $permission->apprentice_user?->courses?->first()?->career?->type ?? 'No asignado' }}</p>
                                    <p class="mb-0"><strong>Ficha: </strong>{{ $permission->apprentice_user?->courses?->first()?->number_group ?? 'No asignado' }}</p>                                </div>
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
                                                    text: 'REPORTE GENERAL DE PERMISOS',
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