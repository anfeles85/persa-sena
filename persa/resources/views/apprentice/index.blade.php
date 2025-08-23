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
                                        <label class="form-label fw-bold">
                                            Seleccionar Ficha
                                        </label>
                                        <select class="form-control form-select" name="course_id" id="course_select" onchange="this.form.submit()">
                                            <option value="">Seleccione una ficha</option>
                                            @if(isset($courses) && $courses->count() > 0)
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" 
                                                        {{ request('course_id') == $course->id ? 'selected' : '' }}>
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
                                    <div class="form-group mb-2">
                                        <a href="{{ route('apprentice.index') }}" class="btn btn-dark text-white">
                                            Limpiar
                                        </a>
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
                        <div class="card-header  text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-4">
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
                                <div class="table-responsive">
                                    <table id="table_data" class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">Documento</th>
                                                <th scope="col">Nombre Completo</th>
                                                <th scope="col">Correo Electrónico</th>
                                                <th scope="col">Programa</th>
                                                <th scope="col">Jornada/Año</th>
                                                <th scope="col">Estado</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($apprentices as $apprentice)
                                                <tr>
                                                    <td class="fw-bold">{{ $apprentice->document }}</td>
                                                    <td>{{ $apprentice->fullname }}</td>
                                                    <td>
                                                        <a href="mailto:{{ $apprentice->email }}" class="text-decoration-none">
                                                            {{ $apprentice->email }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ $apprentice->career_name ?? 'N/A' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            {{ $apprentice->course_shift ?? 'N/A' }} - {{ $apprentice->course_year ?? 'N/A' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        {{ $apprentice->status }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            {{-- Botón para cambiar estado (Instructor y Administrador) --}}
                                                            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
                                                                <form action="{{ route('apprentice.toggleStatus', $apprentice->id) }}" method="POST" class="d-inline" id="statusForm{{ $apprentice->id }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    @if($apprentice->status == 'ACTIVO')
                                                                        <button type="button" class="btn btn-sm btn-danger text-white" 
                                                                                onclick="confirmStatusChange('{{ $apprentice->id }}', '{{ $apprentice->fullname }}', 'inactivar')">
                                                                            <i class="fas fa-user-slash"></i>
                                                                        </button>
                                                                    @else
                                                                        <button type="button" class="btn btn-sm btn-success"
                                                                                onclick="confirmStatusChange('{{ $apprentice->id }}', '{{ $apprentice->fullname }}', 'activar')">
                                                                            <i class="fas fa-user-check"></i>
                                                                        </button>
                                                                    @endif
                                                                </form>
                                                            @endif

                                                            @if(auth()->user()->role_id == 1)
                                                                <a href="{{ route('apprentice.profile', $apprentice->id) }}" 
                                                                   class="btn btn-primary btn-sm">
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
                                    <div class="mb-4">
                                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No se encontraron aprendices</h5>
                                        <p class="text-muted">
                                            No hay aprendices registrados en esta ficha o la ficha no tiene aprendices asignados.
                                        </p>
                                    </div>
                                    <a href="{{ route('apprentice.index') }}" class="btn btn-dark">
                                        <i class="fas fa-arrow-left me-2"></i>
                                        Seleccionar otra ficha
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
                            <div class="mb-4">
                                <i class="fas fa-users fa-3x text-dark mb-3"></i>
                                <h4 class="text-muted mb-3">Buscar Aprendices</h4>
                                <p class="text-muted mb-4">
                                    Selecciona una ficha del menú desplegable para ver todos los aprendices registrados en esa ficha.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </button>
                    <button type="button" class="btn" id="confirmButton" onclick="executeStatusChange()">
                        <i id="confirmIcon" class="fas fa-check me-2"></i>
                        <span id="confirmText">Confirmar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentFormId = null;

        function confirmStatusChange(apprenticeId, apprenticeName, action) {
            currentFormId = 'statusForm' + apprenticeId;
            
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            const confirmButton = document.getElementById('confirmButton');
            const confirmIcon = document.getElementById('confirmIcon');
            const confirmText = document.getElementById('confirmText');
            const modalIcon = document.getElementById('modalIcon');
            
            if (action === 'activar') {
                document.getElementById('confirmMessage').innerHTML = 
                    `¿Estás seguro de <strong class="text-success">activar</strong> al aprendiz <strong>${apprenticeName}</strong>?`;
                confirmButton.className = 'btn btn-success';
                confirmIcon.className = 'fas fa-user-check me-2';
                confirmText.textContent = 'Activar';
                modalIcon.className = 'fas fa-user-check text-success me-2';
            } else {
                document.getElementById('confirmMessage').innerHTML = 
                    `¿Estás seguro de <strong class="text-danger">inactivar</strong> al aprendiz <strong>${apprenticeName}</strong>?`;
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

        // Auto-hide alerts after 5 seconds
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
