@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Crear Nueva Actividad</h1>
    <form action="{{ route('teacher.activities.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">Por favor ingrese un nombre válido.</div>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Descripción:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            <div class="invalid-feedback">Por favor ingrese una descripción.</div>
        </div>
        
        <div class="mb-3">
            <label for="course_id" class="form-label">Curso:</label>
            <input type="hidden" name="course_id" value="{{ $selectedCourseId }}">
            <input type="text" class="form-control" id="course_name" value="{{ $selectedCourseName }}" readonly>
            <small class="form-text text-muted">Este curso no se puede cambiar.</small>
        </div>
        
        <div class="mb-3">
            <label for="start_date" class="form-label">Fecha de Inicio:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
            <div class="invalid-feedback">Por favor seleccione una fecha de inicio.</div>
        </div>
        
        <div class="mb-3">
            <label for="end_date" class="form-label">Fecha de Fin:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
            <div class="invalid-feedback">Por favor seleccione una fecha de fin.</div>
        </div>
        
        <button type="submit" class="btn btn-primary">Crear</button>

    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

<script>
    
    (function () {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
