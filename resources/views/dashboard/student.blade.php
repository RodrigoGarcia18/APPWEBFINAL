@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Bienvenido,  <strong>{{ Auth::user()->name }}</strong></h1> <!-- Título centrado -->
    <hr class="border-dark"> 

    <div class="row mt-4">


        <div class="col-md-6">
            <div class="card mb-4 shadow"> 
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-book fa-lg"></i> Cursos Inscritos
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('student.courses.view') }}" class="text-dark">Ver Mis Cursos</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4 shadow"> 
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-tasks fa-lg"></i> Actividades
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><a href="{{ route('student.activities.view') }}" class="text-dark">Ver Actividades</a></li>
                        <li><a href="{{ route('student.activities.submit') }}" class="text-dark">Enviar Tarea</a></li>
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
