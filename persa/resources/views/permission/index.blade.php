@extends('templates.base')
@section('title', 'Permisos')
@section('header', 'Permisos')
@section('content')


<label class="fs-2">Permisos</label>
{{-- Boton de crear solo visible si es rol aprendiz --}}
@if(Auth::user()->role_id == 3)
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('permission.create') }}" class="btn btn-success">Crear</a>
    </div>
</div>
@endif

<form method="GET" action="{{ route('permission.index') }}" class="d-flex gap-2 mb-3">

    {{-- Buscar aprendiz --}}
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
    <input type="text" name="search" value="{{ request('search') }}"
           class="form-control w-auto" placeholder="Documento o nombre...">
    @endif

    {{-- Filtro por estado --}}
    <select name="status" class="form-control w-auto">
        <option value="">-- Estado --</option>
        <option value="PENDIENTE" {{ request('status')=='PENDIENTE' ? 'selected' : '' }}>Pendiente</option>
        <option value="APROBADO"  {{ request('status')=='APROBADO' ? 'selected' : '' }} >Aprobado</option>
        <option value="RECHAZADO" {{ request('status')=='RECHAZADO' ? 'selected' : '' }}>Rechazado</option>
        <option value="CANCELADO" {{ request('status')=='CANCELADO' ? 'selected' : '' }}>Cancelado</option>
    </select>

    {{-- Filtro por ficha --}}
    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
    <select name="course_id" class="form-control w-auto">
        <option value="">-- Ficha --</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}" {{ request('course_id')==$course->id ? 'selected' : '' }}>
                {{ $course->number_group }} - {{ $course->career->name }}
            </option>
        @endforeach
    </select>
    @endif

    <button type="submit" class="btn btn-primary">Filtrar</button>
    <a href="{{ route('permission.index') }}" class="btn btn-secondary">Limpiar</a>
</form>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead class="align-middle text-center" >
                <tr class="text-center">
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Hora de inicio</th>
                    <th>Hora de fin</th>
                    <th>Hora de salida</th>
                    <th>Motivo</thh>
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
                        
                        {{-- Botón de detalles visible para Coordinador/Instructor/Guarda--}}
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 4) 
                        <button class="btn btn-info btn-circle table-btn w-100" 
                        data-bs-toggle="modal" data-bs-target="#detailsModal{{ $permission->id }}" 
                         title="Ver detalles">
                        <i class="fas fa-eye"></i>
                        </button>
                        @endif

                         {{-- SOLO admin/aprendiz pueden editar--}}
                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                        <div class="col-lg-6 mb-4">
                            <a href="{{ route('permission.edit', $permission["id"]) }}" class="btn btn-primary btn-circle table-btn w-100" title="Editar">
                                <i class="far fa-edit"></i>
                            </a>
                        </div>
                        @endif
                        
                        {{-- Botón de aprobar --}}
                        @if(Auth::user()->role_id == 2 || Auth::user()->role_id == 4) {{-- guarda y instrcutor pueden aprobar --}}
                        <div class="col-lg-6 mb-4">
                            <form id="form-approve-{{ $permission['id'] }}" action="{{ route('permission.approve', $permission["id"]) }}" method="post">
                             @csrf
                            @method('PATCH')
                                <button type="submit" class="btn btn-success btn-circle table-btn w-100" title="Aprobar">
                                <i class="fas fa-check"></i>
                                </button>
                            </form>
                        </div>
                        @endif

                        {{-- Boton de cancelado--}}
                        @if(Auth::user()->role_id == 4 || Auth::user()->role_id == 2) {{-- guarda y instrcutor pueden cancelar --}}
                         <div class="col-lg-6 mb-4">
                            <form id="form-cancel-{{ $permission['id'] }}" action="{{ route('permission.cancel', $permission["id"]) }}" method="post">
                                 @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning btn-circle table-btn w-100" title="Cancelar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                         </div>
                        @endif

                        {{-- SOLO aprendiz puede eliminar--}}
                        @if(Auth::user()->role_id == 3)
                        <div class="col-lg-6 mb-4">
                            <form id="form-delete-{{ $permission['id'] }}" action="{{ route('permission.destroy', $permission["id"]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-circle table-btn w-100" title="Eliminar" 
                                    onclick="remove(event, {{ $permission['id'] }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </td>
                </tr>

                {{-- Modal con detalles del permiso --}}
<div class="modal fade" id="detailsModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del permiso #{{ $permission->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Aprendiz:</strong> {{ $permission->apprentice_user->fullname }} ({{ $permission->apprentice_user->document }})</p>
                <p><strong>Correo:</strong> {{ $permission->apprentice_user->email }}</p>
                <p><strong>Tipo permiso:</strong> {{ $permission->permissionType->name }}</p>
                <p><strong>Carrera:</strong> {{ $permission->apprentice_user->courses->first()->career->name ?? 'No asignado' }}</p>
                <p><strong>Tipo Carrera:</strong> {{ $permission->apprentice_user->courses->first()->career->type ?? 'No asignado' }}</p>
                <p><strong>Ficha:</strong>{{ $permission->apprentice_user->courses->first()->number_group ?? 'No asignado' }}</p>

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
@endsection