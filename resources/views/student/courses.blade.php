@extends('layouts.app')

@section('content')
<style>
    /* Estilos personalizados para los colores del pie de página de los cursos */
    .footer-color-1 {
        background-color: #FF6B6B; /* Rojo */
    }
    .footer-color-2 {
        background-color: #6BCB77; /* Verde */
    }
    .footer-color-3 {
        background-color: #FFD93D; /* Amarillo */
    }
    .footer-color-4 {
        background-color: #FF4D4D; /* Rojo Oscuro */
    }
    .footer-color-5 {
        background-color: #6F42C1; /* Púrpura */
    }
    .card-footer-custom {
        height: 10px; /* Altura opcional para el pie de página */
    }
    /* Estilo para el contenedor del filtro */
    .filter-container {
        background-color: #f8f9fa; /* Color de fondo claro */
        padding: 20px; /* Espaciado mayor */
        border-radius: 8px; /* Bordes redondeados */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        margin-bottom: 20px; /* Espacio inferior */
    }
    /* Mejora del diseño del select */
    .form-select {
        font-size: 1.1rem; /* Aumentar el tamaño de la letra */
        padding: 10px; /* Espaciado interno */
        border-radius: 5px; /* Bordes redondeados */
        border: 1px solid #ced4da; /* Bordes más definidos */
        transition: border-color 0.3s ease; /* Transición suave al enfocar */
    }
    .form-select:focus {
        border-color: #007bff; /* Color del borde al enfocar */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Sombra al enfocar */
    }
</style>

<div class="container-fluid">
    <h1 class="text-center mb-4">Mis Cursos </h1>

    <!-- Contenedor de filtro -->
    <div class="filter-container">
        <!-- Formulario de filtros -->
        <form method="GET" action="{{ route('student.courses.view') }}">
            <div class="row">
                <!-- Selección por periodo del curso -->
                <div class="col-md-4 mb-3 mb-md-0">
                    <label for="course_period" class="form-label">Selecciona un periodo:</label>
                    <select class="form-select" name="course_period" id="course_period">
                        <option value="">Todos los periodos</option>
                        @foreach($periods as $period)
                            <option value="{{ $period }}" {{ request('course_period') == $period ? 'selected' : '' }}>{{ $period }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Botón de filtro -->
                <div class="col-md-2 mb-3 mb-md-0">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
    
    <h5 class="mb-3">Cursos Asignados</h5>

    <div id="courses-container" class="row">
        @forelse($courses as $index => $course)
            <div class="col-12 mb-3">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="bi bi-card-text"></i> ID del Curso: {{ $course->course_id }}
                                </h6>
                                <h5 class="card-title">
                                    <i class="bi bi-book"></i> {{ $course->name }}
                                </h5>
                                <p class="card-text mb-0">
                                    <i class="bi bi-check-circle text-success"></i> 
                                    Abierto |
                                    <a href="{{ route('student.courses.details', $course->id) }}" class="text-decoration-none">
                                        Más información 
                                        <i class="bi bi-chevron-down"></i>
                                    </a>
                                </p>
                            </div>
                            <i class="bi bi-star text-muted"></i>
                        </div>
                    </div>
                    <div class="card-footer card-footer-custom footer-color-{{ ($index % 5) + 1 }}"></div>
                </div>
            </div>
        @empty
            <p>No hay cursos inscritos para mostrar.</p>
        @endforelse
    </div>
</div>
@endsection
