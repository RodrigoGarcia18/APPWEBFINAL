@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="display-4">Detalles del Curso</h1>
        <p class="lead text-muted">Explora los detalles del curso y los estudiantes asignados.</p>
    </div>

    <div class="card shadow-lg">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title">{{ $course->name }}</h3>
                    <p class="card-text text-muted">{{ $course->description }}</p>
                </div>
                <span class="badge bg-primary p-2">{{ $course->course_id }}</span> <!-- Muestra el ID del curso como una insignia -->
            </div>
            <hr>
            <p class="card-text"><strong>Docentes Asignados:</strong> 
                {{ $course->users->filter(function($user) {
                    return $user->role === 'teacher'; // Filtrar solo los docentes
                })->isNotEmpty() ? $course->users->filter(function($user) {
                    return $user->role === 'teacher'; // Filtrar solo los docentes
                })->pluck('name')->join(', ') : 'No hay docentes asignados' }}
            </p>
            
            <form method="POST" action="{{ route('teacher.courses.updateSessionLink', $course->id) }}" class="mt-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="session_link" class="form-control" placeholder="Ingrese el enlace de la sesión" value="{{ $course->session_link }}">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
            
        </div>
    </div>

    <div class="mt-5">
        <h3 class="mb-4 text-center">Estudiantes Asignados</h3>
        <div class="table-responsive">
            @if ($course->users->where('role', 'student')->isNotEmpty())
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>DNI/Código</th> <!-- Cambié el encabezado para incluir Código -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->users->where('role', 'student') as $user)
                            @if ($student = $user->student) <!-- Asumiendo que hay una relación entre User y Student -->
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $student->dni }}</td> <!-- Mostrar el código desde la tabla students -->
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning text-center">
                    No hay estudiantes asignados a este curso.
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('teacher.courses.view') }}" class="btn btn-secondary">Regresar a Mis Cursos</a>
    </div>
</div>

<style>
    /* Estilos personalizados para darle un diseño atractivo */
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    .card-body {
        padding: 2rem;
    }
    .card h5 {
        font-size: 1.5rem;
        font-weight: bold;
    }
    .badge {
        font-size: 1rem;
    }
    .alert {
        text-align: center;
        font-size: 1.1rem;
    }
    .btn-secondary {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }
    /* Diseño de la tabla de estudiantes */
    .table {
        margin-top: 20px;
        border-radius: 15px;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center; /* Centrar texto en las celdas */
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9; /* Color de fondo alternativo para filas */
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6; /* Borde para las celdas */
    }
</style>
@endsection
