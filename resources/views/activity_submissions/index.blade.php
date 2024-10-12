@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sumisiones de Actividades</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Actividad</th>
                <th>Archivo</th>
                <th>Descripción</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($submissions as $submission)
                <tr>
                    <td>{{ $submission->user->name }}</td>
                    <td>{{ $submission->activity->name }}</td>
                    <td>
                        @if ($submission->filepath)
                            <a href="{{ asset($submission->filepath) }}" target="_blank">Ver Archivo</a>
                        @else
                            No subido
                        @endif
                    </td>
                    <td>{{ $submission->text_content }}</td>
                    <td>{{ $submission->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
