@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil de {{ auth()->user()->name }}</h1>
    <!-- Aquí puedes agregar más información del usuario -->
    <div class="row">
        <div class="col-md-12">
            <h3>Información del Usuario</h3>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> {{ auth()->user()->email }}</li>
                <li><strong>Rol:</strong> {{ auth()->user()->role }}</li>
                <!-- Agrega más información que desees mostrar -->
            </ul>
        </div>
    </div>
</div>
@endsection
