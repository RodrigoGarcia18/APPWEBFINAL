@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Asistencias Registradas para {{ $course->name }}</h1>
    <hr class="border-dark">

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('teacher.attendance.details', $course->id) }}">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="start_date">Fecha de Inicio</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="end_date">Fecha de Fin</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', now()->endOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Estudiante</th>
                    </tr>
                </thead>
                <tbody>
                    @if($attendances->count() > 0)
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->status }}</td>
                                <td>{{ $attendance->user->name }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">No hay asistencias registradas para este curso en la fecha seleccionada.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="{{ route('teacher.attendance.view') }}" class="btn btn-primary">Volver a Cursos</a>
    </div>
</div>
@endsection
