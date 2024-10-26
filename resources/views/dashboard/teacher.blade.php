@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Bienvenido,  <strong>{{ Auth::user()->name }}</strong></h1> <!-- Título centrado -->
    <hr class="border-dark"> 

    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card mb-4 shadow"> 
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-book fa-lg"></i> Mis Cursos
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('teacher.courses.view') }}" class="text-dark">Ver Mis Cursos</a></li>
                        <li><a href="{{ route('teacher.activities.create') }}" class="text-dark">Añadir Actividades</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow"> 
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-graduation-cap fa-lg"></i> Notas
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('teacher.grades.view') }}" class="text-dark">Ver Notas</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow"> 
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-check-circle fa-lg"></i> Asistencia
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('teacher.attendance.view') }}" class="text-dark">Ver Panel de Asistencia</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    body {
        font-family: 'Roboto', sans-serif; 
        background-color: #f8f9fa; 
    }

    hr {
        margin-top: 10px; 
        margin-bottom: 20px; 
        border-width: 2px; 
    }

    .card {
        background-color: white;
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

@endsection
