@extends('layouts.app')

@section('content')
<style>
    /* Custom styles for footer colors */
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
        background-color: #e9ecef; /* Light gray on hover */
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
        border: 1px solid #007BFF; /* Blue border */
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px; /* Round corners */
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    /* Better layout of the activity content */
    .activity-title {
        font-weight: bold;
        color: blue;
        margin-bottom: 5px;
    }

    .activity-text {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .edit-button {
        margin-left: 10px; /* Space between the title and the button */
    }
</style>

<div class="container-fluid mt-5">
    <h1 class="text-center mb-4">Panel de Asignar Notas</h1>

    <h5 class="mb-3">Cursos Disponibles</h5>

    <div id="activities-container" class="row">
        @forelse($courses as $index => $course)
            <div class="col-12 mb-3">
                <div class="card course-card" onclick="toggleActivities('{{ $course->id }}')" id="course-card-{{ $course->id }}">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-success">{{ $course->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Curso ID: {{ $course->course_id }} | 
                            </h6>
                        </div>
                        <div class="collapse-icon">
                            <i class="bi bi-chevron-down"></i>
                        </div>
                    </div>
                    <div class="card-footer card-footer-custom footer-color-{{ ($index % 5) + 1 }}"></div>
                </div>

                <!-- Activities List -->
                <div class="activities-list" id="activities-{{ $course->id }}" style="max-height: 0;">
                    @foreach($course->activities as $activity)
                        <div class="activity-card">
                            <div>
                                <h5 class="activity-title">{{ $activity->name}}</h5>
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
                            <div class="d-flex align-items-center">
                                <div class="activity-icon">
                                    <i class="bi bi-card-checklist"></i>
                                </div>
                                <a href="{{ route('teacher.grades.submissions', $activity->id) }}" class="btn btn-sm btn-secondary edit-button">Asignar  Notas</a>
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
        const maxHeight = activitiesList.style.maxHeight;

        if (maxHeight === '0px' || maxHeight === '') {
            activitiesList.style.maxHeight = activitiesList.scrollHeight + 'px';
            courseCard.classList.add('collapsed');
        } else {
            activitiesList.style.maxHeight = '0px';
            courseCard.classList.remove('collapsed');
        }
    }
</script>
@endsection
