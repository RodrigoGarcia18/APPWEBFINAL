@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Usuario</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT') 

        <div class="form-group mb-3">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="codigo">Código Institucional</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $user->codigo) }}" readonly>
        </div>

        <div class="form-group mb-3">
            <label for="password">Contraseña (Mínimo 8 caracteres, dejar vacío si no desea cambiar)</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Nueva contraseña">
        </div>

        @if ($user->role === 'teacher')
            <div class="teacher-info border rounded p-4 mb-4 bg-light">
                <h4 class="mb-3">Información del Docente</h4>
                <div class="form-group mb-3">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni', $user->teacher->dni ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="birth_date">Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $user->teacher->birth_date ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="subject">Materia</label>
                    <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject', $user->teacher->subject ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->teacher->address ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Teléfono</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->teacher->phone ?? '') }}" required>
                </div>
            </div>
        @elseif ($user->role === 'student')
            <div class="student-info border rounded p-4 mb-4 bg-light">
                <h4 class="mb-3">Información del Estudiante</h4>
                <div class="form-group mb-3">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" value="{{ old('dni', $user->student->dni ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="birth_date">Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" value="{{ old('birth_date', $user->student->birth_date ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="enrollment_number">Número de Matrícula</label>
                    <input type="text" name="enrollment_number" id="enrollment_number" class="form-control" value="{{ old('enrollment_number', $user->student->enrollment_number ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->student->address ?? '') }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Teléfono</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->student->phone ?? '') }}" required>
                </div>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>
@endsection
