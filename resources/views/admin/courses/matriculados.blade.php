@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center text-primary">Lista de Estudiantes Matriculados</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Opciones de Filtrado -->
    <form method="GET" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Buscar por Nombre del Curso" value="{{ request('course_name') }}">
            </div>
            <div class="col-md-4">
                <select name="period" id="period" class="form-control">
                    <option value="">Seleccionar Período</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period }}" {{ request('period') == $period ? 'selected' : '' }}>{{ $period }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
            </div>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre del Estudiante</th>
                    <th>DNI</th>
                    <th>Cursos</th>
                    <th>Código de Curso</th>
                    <th>Periodo</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    @foreach ($student->courses as $course)
                        <tr>
                            @if ($loop->first) <!-- Solo mostrar el nombre del estudiante una vez -->
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->student->dni }}</td>
                            @else
                                <td></td> <!-- Espacio vacío si no es la primera iteración -->
                                <td></td>
                            @endif
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->course_id }}</td>
                            <td>{{ $course->period }}</td>
                            <td>{{ $course->description ?? 'No se proporcionó descripción' }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">No se encontraron estudiantes matriculados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Enlaces de paginación -->
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $students->previousPageUrl() }}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    @for ($i = 1; $i <= $students->lastPage(); $i++)
                        <li class="page-item {{ $i == $students->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $students->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ $students->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $students->nextPageUrl() }}" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>
</div>
@endsection
