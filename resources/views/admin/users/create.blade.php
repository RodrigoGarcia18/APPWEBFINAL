@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Crear Usuario</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información del Usuario</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">Nombre de Usuario</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="codigo">Código Institucional</label>
                    <input type="text" name="codigo" id="codigo" class="form-control">
                    <small class="form-text text-muted">
                        Este campo es editable, pero se generará automáticamente si lo dejas en blanco.
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Contraseña (Mínimo 8 caracteres)</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Nueva contraseña" required>
                </div>

                <div class="form-group mb-4">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group mb-4">
                    <label for="role">Rol</label>
                    <select name="role" id="role" class="form-control" required onchange="toggleRoleSections()">
                        <option value="">Seleccione un rol</option>
                        <option value="admin">Administrador</option>
                        <option value="teacher">Docente</option>
                        <option value="student">Estudiante</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información Básica</h5>
            </div>
            <div class="card-body" id="basicInfo">
                <div class="form-group mb-3">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="birth_date">Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" id="birth_date" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="phone">Teléfono</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>

                <div class="form-group mb-3">
                    <label for="first_name">Nombre</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="last_name">Apellido</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" required>
                </div>
            </div>
        </div>

        
        <div class="card mb-4" id="teacherInfo" style="display: none;">
            <div class="card-header">
                <h5 class="mb-0">Información del Docente</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="subject">Materia</label>
                    <input type="text" name="subject" id="subject" class="form-control">
                    <small class="form-text text-muted">
                        Este campo es opcional.
                    </small>
                </div>
            </div>
        </div>

        
        <div class="card mb-4" id="studentInfo" style="display: none;">
            <div class="card-header">
                <h5 class="mb-0">Información del Estudiante</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="enrollment_number">Número de Matrícula</label>
                    <input type="text" name="enrollment_number" id="enrollment_number" class="form-control">
                    <small class="form-text text-muted">
                        Este campo es opcional.
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="grade">Grado</label>
                    <input type="text" name="grade" id="grade" class="form-control">
                    <small class="form-text text-muted">
                        Este campo es opcional.
                    </small>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
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
    function toggleRoleSections() {
        const role = document.getElementById('role').value;
        const teacherInfo = document.getElementById('teacherInfo');
        const studentInfo = document.getElementById('studentInfo');

        // primero lo oculto
        teacherInfo.style.display = 'none';
        studentInfo.style.display = 'none';

        // segun el role del user muestro un display u otro
        if (role === 'teacher') {
            teacherInfo.style.display = 'block';
        } else if (role === 'student') {
            studentInfo.style.display = 'block';
        }
    }
</script>

@endsection
