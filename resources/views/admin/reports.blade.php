@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Reportes</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-center mb-4">
        <div class="btn-group" role="group">
            <a href="{{ route('admin.reports.exportCourses') }}" class="btn btn-primary mx-2">Exportar Cursos</a>
            <a href="{{ route('admin.reports.exportUsers') }}" class="btn btn-primary mx-2">Exportar Usuarios</a>
        </div>
    </div>
</div>
@endsection
