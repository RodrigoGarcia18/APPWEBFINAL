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
                <span class="badge bg-primary p-2">{{ $course->course_id }}</span>
            </div>
            <hr>
            <p class="card-text"><strong>Docentes Asignados:</strong>
                {{ $course->users->filter(function($user) {
                    return $user->role === 'teacher';
                })->isNotEmpty() ? $course->users->filter(function($user) {
                    return $user->role === 'teacher';
                })->pluck('name')->join(', ') : 'No hay docentes asignados' }}
            </p>

            <form method="POST" action="{{ route('teacher.courses.updateSessionLink', $course->id) }}" class="mt-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="session_link" class="form-control" placeholder="Ingrese el enlace de la sesión" value="{{ $course->session_link }}">
                    <button type="submit" id="update-session-link" class="btn btn-primary">Actualizar</button>
                    <button type="button" id="generate-session-link" class="btn btn-primary">Generar</button>
                </div>
            </form>

            <form method="POST" action="{{ route('teacher.courses.updateMaterialLink', $course->id) }}" class="mt-3">
                @csrf
                <div class="input-group">
                    <input type="text" name="material_link" class="form-control" placeholder="Ingrese el enlace del material" value="{{ $course->material_link }}">
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
                            <th>DNI/Código</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->users->where('role', 'student') as $user)
                            @if ($student = $user->student)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $student->dni }}</td>
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

    .table {
        margin-top: 20px;
        border-radius: 15px;
        overflow: hidden;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }
</style>
@endsection
