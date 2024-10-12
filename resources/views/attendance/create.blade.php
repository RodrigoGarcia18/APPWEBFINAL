@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Marcar Asistencia</h1>
    <hr class="border-dark">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('teacher.attendance.mark') }}" method="POST">
        @csrf
        <input type="hidden" name="course_id" value="{{ $course->id }}">
        
        <div class="form-group">
            <label for="attendance_date">Fecha de Asistencia</label>
            <input type="date" name="attendance_date" id="attendance_date" class="form-control" required>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre del Estudiante</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="student-table-body">
                    @if($students && count($students) > 0)
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->name }}</td>
                                <td>
                                    <select name="students[{{ $student->id }}][status]" class="form-control" required>
                                        <option value="present">Presente</option>
                                        <option value="absent">Ausente</option>
                                        <option value="late">Tarde</option>
                                    </select>
                                    <input type="hidden" name="students[{{ $student->id }}][id]" value="{{ $student->id }}">
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">No hay estudiantes asignados a este curso.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <button type="submit" class="btn btn-danger mt-3">Marcar Asistencia</button>
    </form>
</div>
@endsection
