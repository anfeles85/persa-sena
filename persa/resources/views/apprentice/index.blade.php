@extends('templates.base')
@section('title', 'Buscar aprendiz')
@section('header', 'Buscar aprendiz')

@section('content')
<div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <label class="fs-2">Buscar aprendices por ficha</label>
            <div class="card-body">
                <form action="{{ route('apprentice.index') }}" method="GET" id="searchForm">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Seleccionar Ficha</label>
                                <select class="form-control form-select" name="course_id" id="course_select" onchange="this.form.submit()">
                                    <option value="">Seleccione una ficha</option>
                                    @if(isset($courses) && $courses->count() > 0)
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->number_group }} - {{ $course->career->name }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay fichas disponibles</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3 d-flex gap-2">
                                <a href="{{ route('apprentice.index') }}" class="btn btn-secondary text-white flex-fill">
                                    Limpiar
                                </a>
                                {{-- Solo muestra los botones si hay una ficha seleccionada --}}
                                @if(request('course_id'))
                                <button type="button" id="exportExcelBtn" class="btn btn-success flex-fill">
                                    <i class="fas fa-file-excel"></i> Excel
                                </button>
                                <button type="button" id="exportPdfBtn" class="btn btn-danger flex-fill">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(request('course_id'))
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header text-white d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <h5 class="mb-2 mb-md-0">
                            Aprendices Encontrados
                            @if(isset($courses))
                                @php
                                    $selectedCourse = $courses->where('id', request('course_id'))->first();
                                @endphp
                                @if($selectedCourse)
                                    - {{ $selectedCourse->career->name }} ({{ $selectedCourse->shift }} - {{ $selectedCourse->year }})
                                @endif
                            @endif
                        </h5>
                        @if(isset($apprentices) && $apprentices->count() > 0)
                            <span class="badge bg-light text-dark fs-6">
                                Total: {{ $apprentices->count() }} aprendices
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if(isset($apprentices) && $apprentices->count() > 0)
                            <div class="col-lg-12 mb-4">
                                <table id="table_data" class="table table-striped text-center align-middle">
                                    <thead class="align-middle text-center">
                                        <tr>
                                            <th>Documento</th>
                                            <th>Nombre Completo</th>
                                            <th>Correo Electrónico</th>
                                            <th>Programa</th>
                                            <th>Jornada/Año</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($apprentices as $apprentice)
                                            <tr class="d-block d-md-table-row border rounded mb-3 mb-md-0 p-2">
                                                <td data-label="Documento" class="fw-bold d-block d-md-table-cell">{{ $apprentice->document }}</td>
                                                <td data-label="Nombre" class="d-block d-md-table-cell">{{ $apprentice->fullname }}</td>
                                                <td data-label="Correo" class="d-block d-md-table-cell">
                                                    <a href="mailto:{{ $apprentice->email }}" class="text-decoration-none">{{ $apprentice->email }}</a>
                                                </td>
                                                <td data-label="Programa" class="d-block d-md-table-cell">
                                                    <small class="text-muted">{{ $apprentice->career_name ?? 'N/A' }}</small>
                                                </td>
                                                <td data-label="Jornada/Año" class="d-block d-md-table-cell">
                                                    <small class="text-muted">{{ $apprentice->course_shift ?? 'N/A' }} - {{ $apprentice->course_year ?? 'N/A' }}</small>
                                                </td>
                                                <td data-label="Estado" class="d-block d-md-table-cell">{{ $apprentice->status }}</td>
                                                <td id="buttons_DE" style="border-top: none;">
                                                <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 w-100">
                                                    @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                        <form action="{{ route('apprentice.toggleStatus', $apprentice->id) }}"
                                                            method="POST"
                                                            id="statusForm{{ $apprentice->id }}" class="w-100 w-md-auto">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if($apprentice->status == 'ACTIVO')
                                                                <button type="button"
                                                                        class="btn btn-danger btn-circle table-btn w-100 w-md-auto"
                                                                        title="Inactivar"
                                                                        onclick="confirmStatusChange('{{ $apprentice->id }}', '{{ $apprentice->fullname }}', 'inactivar')">
                                                                    <i class="fas fa-user-slash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                        class="btn btn-success btn-circle table-btn w-100 w-md-auto"
                                                                        title="Activar"
                                                                        onclick="confirmStatusChange('{{ $apprentice->id }}', '{{ $apprentice->fullname }}', 'activar')">
                                                                    <i class="fas fa-user-check"></i>
                                                                </button>
                                                            @endif
                                                        </form>
                                                    @endif
                                                    @if(auth()->user()->role_id == 1)
                                                        <a href="{{ route('apprentice.profile', $apprentice->id) }}"
                                                        class="btn btn-primary btn-circle table-btn w-100 w-md-auto"
                                                        title="Editar">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No se encontraron aprendices</h5>
                                <p class="text-muted">No hay aprendices registrados en esta ficha o la ficha no tiene aprendices asignados.</p>
                                <a href="{{ route('apprentice.index') }}" class="btn btn-dark">
                                    <i class="fas fa-arrow-left me-2"></i> Seleccionar otra ficha
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-3x text-dark mb-3"></i>
                        <h4 class="text-muted mb-3">Buscar Aprendices</h4>
                        <p class="text-muted">Selecciona una ficha del menú desplegable para ver todos los aprendices registrados en esa ficha.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Modal de confirmación --}}
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="confirmModalLabel">
                    <i id="modalIcon" class="fas fa-question-circle text-warning me-2"></i>
                    Confirmar acción
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <p id="confirmMessage" class="mb-0"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Cancelar
                </button>
                <button type="button" class="btn" id="confirmButton" onclick="executeStatusChange()">
                    <i id="confirmIcon" class="fas fa-check me-2"></i>
                    <span id="confirmText">Confirmar</span>
                </button>
            </div>
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
    $(document).ready(function() {
        if ($('#table_data').length) {
            
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'd-none',
                        title: `Reporte de Aprendices`,
                        exportOptions:
                         { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'd-none',
                        title: `Reporte de Aprendices`,
                        orientation: 'landscape',
                        exportOptions: { columns: ':not(:last-child)' }
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
        }
    });
    let currentFormId = null;

    function confirmStatusChange(apprenticeId, apprenticeName, action) {
        currentFormId = 'statusForm' + apprenticeId;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        const confirmButton = document.getElementById('confirmButton');
        const confirmIcon = document.getElementById('confirmIcon');
        const confirmText = document.getElementById('confirmText');
        const modalIcon = document.getElementById('modalIcon');

        if (action === 'activar') {
            document.getElementById('confirmMessage').innerHTML = `¿Estás seguro de <strong class="text-success">activar</strong> al aprendiz <strong>${apprenticeName}</strong>?`;
            confirmButton.className = 'btn btn-success';
            confirmIcon.className = 'fas fa-user-check me-2';
            confirmText.textContent = 'Activar';
            modalIcon.className = 'fas fa-user-check text-success me-2';
        } else {
            document.getElementById('confirmMessage').innerHTML = `¿Estás seguro de <strong class="text-danger">inactivar</strong> al aprendiz <strong>${apprenticeName}</strong>?`;
            confirmButton.className = 'btn btn-danger';
            confirmIcon.className = 'fas fa-user-slash me-2';
            confirmText.textContent = 'Inactivar';
            modalIcon.className = 'fas fa-user-slash text-danger me-2';
        }
        modal.show();
    }

    function executeStatusChange() {
        if (currentFormId) {
            document.getElementById(currentFormId).submit();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    
</script>
@endsection
