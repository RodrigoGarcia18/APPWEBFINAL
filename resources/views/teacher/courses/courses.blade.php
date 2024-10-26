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
</style>

<div class="container-fluid">
    <h1 class="text-center mb-4">Mis Cursos</h1>

    <form method="GET" action="{{ route('teacher.courses.view') }}"> 
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="input-group">
                    
                    <input type="text" name="name" class="form-control border-start-0" placeholder="Busque sus cursos" value="{{ request('name') }}"> 
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
            <div class="col-md-3 mb-3 mb-md-0">
                <select class="form-select" name="course_period">
                    <option value="">Todos los periodos</option>
                    @foreach($periods as $period)
                        <option value="{{ $period }}" {{ request('course_period') == $period ? 'selected' : '' }}>{{ $period }}</option> 
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <h5 class="mb-3">Cursos Asignados</h5>

    <div id="courses-container" class="row">
        @forelse($courses as $index => $course)
            <div class="col-12 mb-3">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">
                                    <i class="bi bi-card-text"></i> {{ $course->course_id }}
                                </h6>
                                <h5 class="card-title">
                                    <i class="bi bi-book"></i> {{ $course->name }}
                                </h5>
                                <p class="card-text mb-0">
                                    <i class="bi bi-check-circle text-success"></i> 
                                    Abierto | 
                                    <i class="bi bi-person-fill"></i> Docentes:
                                    {{ $course->teachers->pluck('name')->join(', ') }} |
                                    <a href="{{ route('teacher.courses.details', $course->id) }}" class="text-decoration-none">
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
            <p>No hay cursos asignados para mostrar.</p>
        @endforelse
    </div>
</div>
@endsection
