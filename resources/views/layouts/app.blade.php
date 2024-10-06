<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>@yield('title', 'Dashboard')</title>
    <style>
        body {
            background-color: #eaeaea; /* Color de fondo claro */
            font-family: 'Roboto', sans-serif;
            transition: background-color 0.3s, color 0.3s; /* Transiciones suaves */
        }
        .sidebar {
            height: 100vh;
            background-color: red;
            color: #ffffff;
            padding: 20px;
            font-size: 0.9rem;
            text-transform: uppercase;
            transition: background-color 0.3s; /* Transición suave */
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
        .mt-auto {
            margin-top: auto;
        }
        .logout-container {
            border-top: 2px solid #ffffff;
            padding-top: 10px;
            margin-top: 20px;
        }
        /* Estilos del modo oscuro */
        body.dark-mode {
            background-color: #1e1e1e; /* Color de fondo oscuro */
            color: #ffffff; /* Color de texto claro */
        }
        .sidebar.dark-mode {
            background-color: #121212; /* Color de la barra lateral en modo oscuro */
        }
        .dark-mode .nav-link {
            color: #ffffff; /* Color de los enlaces en el modo oscuro */
        }
        .dark-mode .logout-btn {
            color: #ffffff; /* Color del botón de cerrar sesión en modo oscuro */
        }
        /* Estilos del deslizador */
        .toggle-wrapper {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        .toggle-wrapper input {
            display: none; /* Oculta el checkbox */
        }
        .toggle {
            width: 60px;
            height: 30px;
            background-color: #ccc;
            border-radius: 15px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .toggle:before {
            content: '';
            position: absolute;
            width: 26px;
            height: 26px;
            background-color: white;
            border-radius: 50%;
            left: 2px;
            bottom: 2px;
            transition: transform 0.3s;
        }
        div card-body {
    background-color: black; /* Mantener el fondo blanco para las tarjetas */
        }

        
        input:checked + .toggle {
            background-color: #dc3545; /* Color del fondo del toggle cuando está activado */
        }
        input:checked + .toggle:before {
            transform: translateX(30px); /* Mueve el botón del toggle a la derecha */
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
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.view') }}"><i class="fas fa-file-alt fa-lg"></i> Reportes</a></li>
                    @elseif(auth()->user()->isTeacher())
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.courses.view') }}"><i class="fas fa-chalkboard-teacher fa-lg"></i> Mis Cursos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('teacher.activities.view') }}"><i class="fas fa-tasks fa-lg"></i> Actividades</a></li>
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

                <!-- Botón deslizador para activar/desactivar el modo oscuro -->
                <div class="toggle-wrapper">
                    <input type="checkbox" id="toggle-dark-mode">
                    <label for="toggle-dark-mode" class="toggle"></label>
                    <span class="ml-2">Modo Oscuro</span>
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
    <script>
        // Función para activar/desactivar el modo oscuro y guardar la preferencia
        const toggleDarkMode = () => {
            const body = document.body;
            const sidebar = document.querySelector('.sidebar');
            const isDarkMode = body.classList.toggle('dark-mode');
            sidebar.classList.toggle('dark-mode');
            localStorage.setItem('dark-mode', isDarkMode);
        };

        // Comprobar si el modo oscuro está activado en localStorage
        const isDarkModeEnabled = localStorage.getItem('dark-mode') === 'true';
        if (isDarkModeEnabled) {
            document.body.classList.add('dark-mode');
            document.querySelector('.sidebar').classList.add('dark-mode');
            document.getElementById('toggle-dark-mode').checked = true; // Mantener el toggle en la posición correcta
        }

        // Evento del toggle
        document.getElementById('toggle-dark-mode').addEventListener('change', toggleDarkMode);
    </script>
</body>
</html>
