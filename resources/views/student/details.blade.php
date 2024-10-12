@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-center">
            <h1 class="display-4">Detalles del Curso</h1>
            <p class="lead text-muted">Explora los detalles del curso y los estudiantes asignados.</p>
        </div>
        <a href="{{ route('student.courses.view') }}" class="btn btn-secondary">Regresar a Mis Cursos</a>
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
                {{ $teachers->isNotEmpty() ? $teachers->pluck('name')->join(', ') : 'No hay docentes asignados' }}
            </p>
            <p class="card-text">
                <strong>Enlace de Sesión:</strong> 
                <a href="{{ $course->session_link }}" class="text-primary" target="_blank">{{ $course->session_link }}</a>
            </p>
        </div>
    </div>

    <div class="container mt-5">
        <h1 class="text-center mb-5 text-danger">Actividades Asignadas</h1>
        <div class="timeline">
            @foreach($activities as $activity)
                <div class="timeline-item">
                    <div class="timeline-date text-muted">{{ date('d M Y', strtotime($activity->start_date)) }}</div>
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <h5 class="card-title text-success">{{ $activity->name }}</h5>
                                <p class="card-subtitle mb-2 text-muted">Actividad ID: {{ $activity->id }}</p>
                                <p class="card-text mb-0">
                                    <i class="bi bi-check-circle text-success"></i> 
                                    Fecha de vencimiento: {{ date('d M Y', strtotime($activity->end_date)) }} <!-- Convertimos a timestamp -->
                                </p>
                                <p class="card-text mb-0"><strong>Descripción:</strong> {{ $activity->description }}</p>
                            </div>

                            @php
                                $submission = App\Models\ActivitySubmission::where('user_id', auth()->id())
                                    ->where('activity_id', $activity->id)
                                    ->first();
                                $isPastDeadline = now()->timestamp > strtotime($activity->end_date); // Verifica si la fecha de vencimiento ha pasado
                            @endphp

                            @if($submission) <!-- Si la actividad ha sido enviada -->
                                <p class="text-success mb-0"><strong>Tarea enviada</strong></p>
                            @elseif(!$isPastDeadline) <!-- Si no ha pasado la fecha de vencimiento -->
                                <!-- Botón de envío que redirige al formulario de envío de actividad -->
                                <a href="{{ route('activity.submit', $activity->id) }}" class="btn btn-success btn-sm ms-3">Enviar</a>
                            @else
                                <p class="text-danger mb-0"><strong>No se puede enviar, la fecha de vencimiento ha pasado</strong></p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
    .btn-secondary {
        padding: 0.75rem 1.5rem;
        font-size: 1.1rem;
    }
    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 50px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: -50px;
        width: 2px;
        background-color: #dee2e6;
    }
    .timeline-item::after {
        content: '';
        position: absolute;
        left: -9px;
        top: 0;
        width: 20px;
        height: 20px;
        border: 2px solid #dee2e6;
        background-color: #fff;
    }
    .timeline-date {
        position: absolute;
        left: -130px; 
        top: 0;
        width: 120px;
        text-align: right;
    }
</style>
@endsection
