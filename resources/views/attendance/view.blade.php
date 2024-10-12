@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Asistencia</h1>
    <hr class="border-dark">

    <table class="table">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Acciones</th>
                <th>Ver Asistencias</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td>
                        <a href="{{ route('teacher.attendance.create', $course->id) }}" class="btn btn-danger">Marcar Asistencia</a>
                    </td>
                    <td>
                        <a href="{{ route('teacher.attendance.details', $course->id) }}" class="btn btn-info">Ver Asistencias</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
