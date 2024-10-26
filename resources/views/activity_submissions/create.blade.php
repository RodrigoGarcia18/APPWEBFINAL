@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <h1 class="text-center mb-4">Subir Actividad: {{ $activity->name }}</h1>
            <p class="text-muted text-center">Descripción: {{ $activity->description }}</p>
            <form action="{{ route('activity.store', $activity->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="text_content" class="form-label">Contenido de Texto (opcional)</label>
                    <textarea class="form-control" id="text_content" name="text_content" rows="4" placeholder="Escribe aquí tu contenido...">{{ old('text_content', $activity->text_content) }}</textarea>
                    @error('text_content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="filepath" class="form-label">Subir Archivo (opcional)</label>
                    <input class="form-control" type="file" id="filepath" name="filepath">
                    @error('filepath')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar Actividad</button>
            </form>
            <a href="{{ route('student.courses.details', $course->id) }}" class="btn btn-secondary w-100 mt-3">Regresar a Detalles del Curso</a>
        </div>
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
    .btn-primary {
        transition: background-color 0.3s;
    }
    .btn-primary:hover {
        background-color: #0056b3; 
    }
    .btn-secondary {
        transition: background-color 0.3s;
    }
    .btn-secondary:hover {
        background-color: #6c757d; 
    }
</style>
@endsection
