@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-danger display-4 text-center font-weight-bold">Administrador</h1>
    <hr class="border-dark">

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-users fa-lg"></i> Usuarios
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a class="text-dark" href="{{ route('admin.users.view') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users fa-lg me-3"></i>
                                    <span class="h5">Ver Usuarios</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark" href="{{ route('admin.users.create') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-lg me-3"></i>
                                    <span class="h5">Añadir Usuario</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-book fa-lg"></i> Cursos
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <a class="text-dark" href="{{ route('admin.courses.view') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-book fa-lg me-3"></i>
                                    <span class="h5">Ver Cursos</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark" href="{{ route('admin.courses.create') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-plus-circle fa-lg me-3"></i>
                                    <span class="h5">Añadir Curso</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4 shadow">
                <div class="card-header bg-danger text-white text-center font-weight-bold">
                    <i class="fas fa-file-alt fa-lg"></i> Reportes
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li>
                            <a class="text-dark" href="{{ route('admin.reports.view') }}">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-alt fa-lg me-3"></i>
                                    <span class="h5">Ver Reportes</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
