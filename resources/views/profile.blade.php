@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <div class="profile-image-container mb-3">
            @if(auth()->user()->isAdmin())
                <img src="{{ asset('path/to/admin-icon.png') }}" alt="Admin Icon" class="profile-image rounded-circle" style="max-width: 80px;">
            @elseif(auth()->user()->isTeacher())
                @php
                    $teacher = auth()->user()->teacher; 
                @endphp
                <img src="{{ $teacher->profile_image }}" alt="Imagen de Perfil" class="profile-image rounded-circle" style="max-width: 120px;">
            @elseif(auth()->user()->isStudent())
                @php
                    $student = auth()->user()->student; 
                @endphp
                <img src="{{ $student->profile_image }}" alt="Imagen de Perfil" class="profile-image rounded-circle" style="max-width: 120px;">
            @endif
        </div>
        <p class="text-muted">{{ auth()->user()->email }}</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h3 class="text-danger" style="font-weight: bold;">Información del Usuario</h3>
                    <table class="table">
                        <tbody>
                            @if(auth()->user()->isAdmin())
                                <tr>
                                    <td colspan="2">Acceso total a las configuraciones del sistema.</td>
                                </tr>
                            @elseif(auth()->user()->isTeacher())
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>DNI:</strong></td>
                                    <td>{{ $teacher->dni }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Nacimiento:</strong></td>
                                    <td>{{ $teacher->birth_date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Código de Docente:</strong></td>
                                    <td>{{  auth()->user()->codigo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección:</strong></td>
                                    <td>{{ $teacher->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono:</strong></td>
                                    <td>{{ $teacher->phone }}</td>
                                </tr>
                            @elseif(auth()->user()->isStudent())
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>DNI:</strong></td>
                                    <td>{{ $student->dni }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha de Nacimiento:</strong></td>
                                    <td>{{ $student->birth_date }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Código de Estudiante:</strong></td>
                                    <td>{{  auth()->user()->codigo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección:</strong></td>
                                    <td>{{ $student->address }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono:</strong></td>
                                    <td>{{ $student->phone }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
