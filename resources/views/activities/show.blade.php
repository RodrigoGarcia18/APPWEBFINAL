<!-- resources/views/activities/show.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>{{ $activity->name }}</h1>
    <p>{{ $activity->description }}</p>
    <a href="{{ route('teacher.activities.edit', $activity->id) }}">Editar</a>
    <form action="{{ route('teacher.activities.destroy', $activity->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
    </form>
@endsection
