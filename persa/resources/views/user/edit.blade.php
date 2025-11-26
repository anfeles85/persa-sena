@extends('templates.base')
@section('title', 'Editar Usuario')
@section('header', 'Editar Usuario')
@section('content')

<br>
    <div>
        <label class="fs-3">Editar Usuario</label>
        <div class="col-lg-12 mb-4">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="fullname">Nombre completo</label>
                        <input type="text" name="fullname" id="fullname" class="form-control"
                            required value="{{ old('fullname', $user->fullname) }}">
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label for="email">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control"
                            required value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-6 mb-4">
                        <label for="document">Documento</label>
                        <input type="number" name="document" id="document" class="form-control"
                            required value="{{ old('document', $user->document) }}">
                    </div>

                    <div class="col-lg-6 mb-4">
                        <label for="status">Estado</label>
                        <select name="status" id="status" class="form-control" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status['value'] }}"
                                    @if(old('status', $user->status) == $status['value']) selected @endif>
                                    {{ $status['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-12 mb-4">
                        <label for="role_id">Rol</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    @if(old('role_id', $user->role_id) == $role->id) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                {{-- Campo Ficha SOLO para aprendices --}}
                @if(optional($user->role)->name === 'APRENDIZ')
                    @php
                        // Selección actual: la primera ficha del aprendiz (si existe) o el old('course_id')
                        $currentCourseId = old('course_id', optional($user->apprenticeCourses->first())->id);
                    @endphp
                        <div class="col-lg-12 mb-4">
                            <label for="course_id">Ficha</label>
                            <select name="course_id" id="course_id" class="form-control">
                                <option value="">Seleccione</option>
                                @forelse ($courses as $course)
                                    <option value="{{ $course->id }}" @selected($currentCourseId == $course->id)>
                                        {{ $course->number_group }} - {{ $course->career->name ?? 'Sin carrera' }}
                                    </option>
                                @empty
                                    <option value="">No hay fichas disponibles</option>
                                @endforelse
                            </select>
                            @if($user->apprenticeCourses->isEmpty())
                                <small class="text-muted">Este aprendiz aún no tiene ficha asignada.</small>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success w-50">Guardar</button>
                        <a href="{{ route('user.index') }}" class="btn btn-danger w-50">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection