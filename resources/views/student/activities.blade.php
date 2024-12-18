@extends('layouts.app')

@section('content')
<style>
    .footer-color-1 {
        background-color: #FF6B6B; /* Red */
    }
    .footer-color-2 {
        background-color: #6BCB77; /* Green */
    }
    .footer-color-3 {
        background-color: #FFD93D; /* Yellow */
    }
    .footer-color-4 {
        background-color: #FF4D4D; /* Dark Red */
    }
    .footer-color-5 {
        background-color: #6F42C1; /* Purple */
    }
    .card-footer-custom {
        height: 10px; /* Optional height for footer */
    }

    .course-card {
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        border-radius: 8px;
    }

    .course-card:hover {
        background-color: #e9ecef;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .activities-list {
        overflow: hidden;
        transition: max-height 0.5s ease;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 15px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .activity-card {
        background-color: transparent;
        border: 1px solid #007BFF; 
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        display: flex;
        flex-direction: column;
    }

    .activity-icon {
        font-size: 1.5rem;
        color: #6c757d;
    }

    .collapse-icon {
        transition: transform 0.3s ease;
    }

    .collapsed .collapse-icon {
        transform: rotate(180deg);
    }

    .activity-title {
        font-weight: bold;
        color: blue;
        margin-bottom: 5px;
    }

    .activity-text {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .note-box {
        border: 1px solid transparent; 
        border-radius: 4px; 
        padding: 10px 0; 
        font-weight: bold; 
        color: black; 
        margin-top: 10px; 
        font-size: 1.25rem; 
        display: flex; 
        align-items: center; 
        justify-content: flex-end; 
    }

    .note-square {
        width: 20px; 
        height: 20px; 
        background-color: black; 
        border-radius: 2px; 
        margin-left: 10px; 
    }

    .edit-button {
        margin-left: 10px; 
    }
</style>

<div class="container-fluid mt-5">
    <h1 class="text-center mb-4">Panel de Actividades</h1>

    <form method="GET" action="{{ route('student.activities.view') }}">
        <div class="row">

            <div class="col-md-4 mb-3 mb-md-0">
                <label for="course_period" class="form-label">Selecciona un periodo:</label>
                <select class="form-select" name="course_period" id="course_period">
                    <option value="">Todos los periodos</option>
                    @foreach($periods as $period)
                        <option value="{{ $period }}" {{ request('course_period') == $period ? 'selected' : '' }}>
                            {{ $period }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 mb-3 mb-md-0">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <h5 class="mb-3">Actividades Asignadas</h5>

    <div id="activities-container" class="row">
        @forelse($courses as $index => $course)
            <div class="col-12 mb-3">
                <div class="card course-card" onclick="toggleActivities('{{ $course->id }}')" id="course-card-{{ $course->id }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-success">{{ $course->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Curso ID: {{ $course->course_id }}</h6>
                        </div>
                        <div class="collapse-icon">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    <div class="card-footer card-footer-custom footer-color-{{ ($index % 5) + 1 }}"></div>
                </div>

    
                <div class="activities-list" id="activities-{{ $course->id }}" style="max-height: 0;">
                    @foreach($course->activities as $activity)
                    <div class="activity-card">
                        <div>
                            <h5 class="activity-title">{{ $activity->name }}</h5>
                            <p class="activity-text mb-0">
                                <i class="bi bi-check-circle text-success"></i> 
                                Fecha de vencimiento: {{ date('d M Y', strtotime($activity->end_date)) }}
                            </p>
                            <p class="activity-text mb-0">
                                <strong>Actividad ID:</strong> {{ $activity->id }}
                            </p>
                            <p class="activity-text mb-0">
                                <strong>Descripción:</strong> {{ $activity->description }}
                            </p>
                        </div>

                        <div class="note-box">
                            <span class="ms-2">Nota: {{ $activity->submissions->first()->nota->nota ?? 'Sin nota' }}</span>
                        </div>
                    </div>
                    
                    @endforeach
                </div>
            </div>
        @empty
            <p>No hay cursos disponibles.</p>
        @endforelse
    </div>
</div>

<script>
    function toggleActivities(courseId) {
        const activitiesList = document.getElementById(`activities-${courseId}`);
        const courseCard = document.getElementById(`course-card-${courseId}`);
        const isCollapsed = activitiesList.style.maxHeight === '0px' || activitiesList.style.maxHeight === '';

        activitiesList.style.maxHeight = isCollapsed ? `${activitiesList.scrollHeight}px` : '0px';
        courseCard.classList.toggle('collapsed', isCollapsed);
    }
</script>
@endsection 
