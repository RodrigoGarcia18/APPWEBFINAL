@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Bienvenido,  <strong>{{ Auth::user()->name }}</strong></h1> <!-- Título centrado -->
    <hr class="border-dark"> <!-- Línea negra debajo del título -->

    <div class="row mt-4">


        <div class="col-md-6">
            <div class="card mb-4 shadow"> <!-- Tarjeta para cursos inscritos -->
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
            <div class="card mb-4 shadow"> <!-- Tarjeta para actividades -->
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
        font-family: 'Roboto', sans-serif; /* Cambia la fuente a Roboto */
        background-color: #f8f9fa; /* Color de fondo de la página */
    }

    hr {
        margin-top: 10px; /* Ajusta el espacio superior de la línea */
        margin-bottom: 20px; /* Ajusta el espacio inferior de la línea */
        border-width: 2px; /* Ancho de la línea */
    }

    .card {
        background-color: white; /* Color de fondo blanco para las tarjetas */
    }
</style>

<!-- Agrega el enlace a Google Fonts para la fuente Roboto -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

@endsection
