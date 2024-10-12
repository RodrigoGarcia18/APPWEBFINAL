@extends('layouts.app')

@section('content')
<style>
    .container {
        margin-top: 30px;
    }
    h1 {
        color: #343a40;
        margin-bottom: 20px; /* Increased bottom margin for better spacing */
        text-align: center; /* Center the heading */
    }
    .table {
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        overflow: hidden;
        width: 100%; /* Ensure the table is full-width */
        margin-bottom: 30px; /* Space below the table */
    }
    .table th, .table td {
        vertical-align: middle;
        padding: 15px; /* Increased padding for better cell spacing */
    }
    .table th {
        background-color: #007BFF;
        color: white;
    }
    .table a {
        color: #007BFF;
        text-decoration: none;
    }
    .table a:hover {
        text-decoration: underline;
    }
    .btn-primary {
        background-color: #28a745;
        border-color: #28a745;
        padding: 10px 20px; /* Consistent button padding */
        margin-top: 20px; /* Space above button */
    }
    .btn-primary:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    .alert {
        margin-top: 20px;
    }
    .btn-back {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        margin-top: 20px; /* Space above button */
        border-radius: 5px;
        text-decoration: none;
    }
    .btn-back:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<div class="container">
    <h1>Entregas para la actividad: {{ $activity->name }}</h1>

    @if($activity->submissions->isEmpty())
        <p class="text-center">No hay entregas para esta actividad.</p>
    @else
        <form method="POST" action="{{ route('teacher.notas.update') }}">
            @csrf
            @method('POST')
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Archivo</th>
                        <th>Nota</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activity->submissions as $submission)
                        <tr>
                            <td>{{ $submission->user->name }}</td>
                            <td>
                                @if($submission->filepath)
                                    <a href="{{ asset($submission->filepath) }}">{{ basename($submission->filepath) }}</a>
                                @else
                                    <span class="text-danger">No entregado</span> <!-- Display "No entregado" if no file -->
                                @endif
                            </td>
                            <td>
                                <input type="hidden" name="submissions[{{ $submission->id }}][activity_submission_id]" value="{{ $submission->id }}">
                                <input type="number" class="form-control" name="submissions[{{ $submission->id }}][nota]" required min="0" max="100" placeholder="Nota"
                                    value="{{ old('submissions.'.$submission->id.'.nota', $submission->nota->nota ?? '') }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Botón para actualizar todas las notas -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar Todas las Notas</button>
            </div>
        </form>
    @endif

    <!-- Botón para regresar a lo anterior -->
    <div class="text-center">
        <a href="{{ url()->previous() }}" class="btn-back">Regresar</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
