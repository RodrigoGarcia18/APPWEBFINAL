@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Curso: {{ $course->name }}</h1>

    <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Método para indicar que se está realizando una actualización -->

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información del Curso</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="course_id">Código del Curso</label>
                    <input type="text" name="course_id" id="course_id" class="form-control" value="{{ $course->course_id }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="name">Nombre del Curso</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $course->name }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="period">Período</label>
                    <input type="text" name="period" id="period" class="form-control" value="{{ $course->period }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control">{{ $course->description }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0" placeholder="0.00" value="{{ $course->precio }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="user_ids">Selecciona Docentes</label>
                    <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                        @foreach ($users as $user) 
                            <option value="{{ $user->id }}" 
                                {{ in_array($user->id, $course->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Curso</button>
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

@endsection
