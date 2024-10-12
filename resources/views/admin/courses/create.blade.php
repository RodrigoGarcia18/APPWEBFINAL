    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1 class="mb-4">Crear Curso</h1>

        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Información del Curso</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="course_id">Código del Curso</label>
                        <input type="text" name="course_id" id="course_id" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">Nombre del Curso</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="period">Período</label>
                        <input type="text" name="period" id="period" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Descripción</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="user_ids">Selecciona Docentes</label>
                        <select name="user_ids[]" id="user_ids" class="form-control" multiple required>
                            @foreach ($users as $user) 
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Crear Curso</button>
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
        