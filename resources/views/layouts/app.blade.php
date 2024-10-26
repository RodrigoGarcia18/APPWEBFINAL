<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <title>@yield('title', 'Dashboard')</title>
    <style>
        body {
            background-color: #eaeaea; 
            font-family: 'Roboto', sans-serif;
            transition: background-color 0.3s, color 0.3s;
            height: 100vh; 
        }
        .sidebar {
            height: 100vh;
            background-color: red;
            color: #ffffff;
            padding: 20px;
            font-size: 0.9rem;
            text-transform: uppercase;
            transition: background-color 0.3s; 
            position: fixed; 
        }
        .sidebar a {
            color: white;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #343a40;
            color: #ffffff;
        }
        .nav-item.active a {
            background-color: #dc3545;
            color: #ffffff;
        }
        .user-logo {
            font-size: 5rem; 
            margin-bottom: 10px;
            color: white;
            background-color: transparent;
            text-align: center; 
            outline: none; 
        }
        .user-name {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .nav-item {
            margin-bottom: 10px;
        }
        .logout-btn {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }

        .logout-container {
            border-top: 2px solid #ffffff;
            padding-top: 10px;
            margin-top: 20px;
        }
        .content-area {
            margin-left: 200px; 
            padding: 20px; 
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar">
                <h4 class="text-center">Menú</h4>
                <a href="{{ route('profile.view') }}" class="text-center"> 
                    <div class="user-logo">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </a>
                <span class="nav-link user-name">{{ auth()->user()->name }}</span>
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="fas fa-home fa-lg"></i> Inicio
                        </a>
                    </li>

                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.view') }}"><i class="fas fa-users fa-lg"></i> Usuarios</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.view') }}"><i class="fas fa-book fa-lg"></i> Cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.courses.matriculados') }}"><i class="fa-solid fa-graduation-cap"></i> Matriculados</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.view') }}"><i class="fas fa-file-alt fa-lg"></i> Reportes</a></li>
                    @elseif(auth()->user()->isTeacher())
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.courses.view') }}"><i class="fas fa-chalkboard-teacher fa-lg"></i> Mis Cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.activities.view') }}"><i class="fas fa-tasks fa-lg"></i> Actividades</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.grades.view') }}"><i class="fas fa-pencil-alt fa-lg"></i> Notas</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.attendance.view') }}"><i class="fas fa-user-check fa-lg"></i> Asistencia</a></li>
                    @elseif(auth()->user()->isStudent())
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.courses.view') }}"><i class="fas fa-book-open fa-lg"></i> Mis Cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('student.activities.view') }}"><i class="fas fa-clipboard-list fa-lg"></i> Actividades</a></li>
                    @endif
                </ul>

                <div class="logout-container mt-auto">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link logout-btn">
                            <i class="fas fa-sign-out-alt fa-lg"></i> CERRAR SESIÓN
                        </button>
                    </form>
                </div>


                
            </div>
            <div class="col-md-10 content-area">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>




</html>
