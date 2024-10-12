@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Usuarios</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Opciones de Filtrado -->
    <form method="GET" class="mb-4">
        <div class="form-row align-items-end">
            <div class="col-auto">
                <label for="role">Rol</label>
                <select name="role" id="role" class="form-control">
                    <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>Todos</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="teacher" {{ request('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="student" {{ request('role') == 'student' ? 'selected' : '' }}>Student</option>
                </select>
            </div>
            <div class="col-auto">
                <label for="codigo">Código</label>
                <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Código" value="{{ request('codigo') }}">
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Código</th>
                    <th>DNI</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ $user->codigo }}</td>
                        <td>
                            @if ($user->role === 'teacher')
                                {{ $user->teacher->dni ?? 'N/A' }} <!-- DNI del teacher -->
                            @elseif ($user->role === 'student')
                                {{ $user->student->dni ?? 'N/A' }} <!-- DNI del estudiante -->
                            @else
                                N/A <!-- Para otros roles -->
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No se encontraron usuarios.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success mb-3">Crear Nuevo Usuario</a>
    </div>
</div>
@endsection
