@extends('templates.base')
@section('title', 'Grupos')
@section('header', 'Grupos')
@section('content')


<label class="fs-2">Grupos</label>
<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <div class="d-flex gap-2">
        <form action="{{ route('course.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
            @csrf
            <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required class="form-control form-control-sm" />
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-file-import me-1"></i> Importar
            </button>
        </form>
        <a href="{{ route('course.create') }}" class="btn btn-success">Crear</a>
        {{-- Botones para descargar la plantilla en excel --}}
        <a href="{{ asset('template_excel/cursos.xlsx') }}" class="btn btn-primary d-flex align-items-center justify-content-center" download="cursos.xlsx">
            <i class="fas fa-file-download me-1"></i> Plantilla
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped align-items-center text-center">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Ficha</th>
                    <th>Programa</th>
                    <th>Jornada</th>
                    <th>Trimestre</th>
                    <th>Año</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                <tr>
                    <td data-label="Id">{{ $course['id'] }}</td>
                    <td data-label="Ficha">{{ $course['number_group'] }}</td>
                    <td data-label="Nombre">{{ $course->career->name ?? 'Sin programa' }}</td>
                    <td data-label="Jornada">{{ $course['shift'] }}</td>
                    <td data-label="Trimestre">{{ $course['trimester'] }}</td>
                    <td data-label="Año">{{ $course['year'] }}</td>
                    <td data-label="Estado">{{ $course['status'] }}</td>
                    <td id="buttons_DE" style="border-top: none;">
                        <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2 w-100">
                            {{-- Botón Editar --}}
                            <a href="{{ route('course.edit', $course->id) }}" 
                                class="btn btn-primary btn-circle table-btn w-100 w-md-auto" 
                                title="Editar">
                                <i class="far fa-edit"></i>
                            </a>

                            {{-- Botón Eliminar --}}
                            <form id="form-delete-{{ $course->id }}" 
                                    action="{{ route('course.destroy', $course->id) }}" 
                                    method="POST" class="w-100 w-md-auto">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-danger btn-circle table-btn w-100 w-md-auto" 
                                        title="Eliminar"
                                        onclick="remove(event, {{ $course->id }})">
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
@endsection

