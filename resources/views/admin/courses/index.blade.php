@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center text-primary">Lista de Cursos</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Opciones de Filtrado -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="course_id" id="course_id" class="form-control" placeholder="Buscar por ID" value="{{ request('course_id') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código de Curso</th>
                    <th>Periodo</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr>
                        <td>{{ $course->id }}</td>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->course_id }}</td>
                        <td>{{ $course->period }}</td>
                        <td>{{ $course->description ?? 'No se proporcionó descripción' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este curso?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Fila para la lista desplegable de docentes -->
                    <tr>
                        <td colspan="6">
                            <div class="mt-2">
                                <button class="btn btn-info btn-block" type="button" data-toggle="collapse" data-target="#collapseTeachers{{ $course->id }}" aria-expanded="false" aria-controls="collapseTeachers{{ $course->id }}">
                                    Usuarios Asignados (Docentes)
                                </button>
                                <div class="collapse" id="collapseTeachers{{ $course->id }}">
                                    <div class="card card-body mt-2">
                                        @if($course->teacher->isEmpty())
                                            <p class="text-muted">Sin docentes asignados</p>
                                        @else
                                            <ul class="list-group">
                                                @foreach ($course->teacher as $teacher)
                                                    <li class="list-group-item">{{ $teacher->name }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">No se encontraron cursos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="text-center">
            <a href="{{ route('admin.courses.create') }}" class="btn btn-success mb-3">Crear Nuevo Curso</a>
        </div>
    </div>
</div>
@endsection
