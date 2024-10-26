<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> <!-- SweetAlert -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet"> <!-- Google Fonts -->
    <title>Iniciar Sesión</title>
    <style>
        body {
            background-image: url('{{ asset('images/background.jpg') }}'); 
            background-size: cover; 
            background-position: center; 
            font-family: 'Roboto', sans-serif;
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .form-card {
            background-color: rgba(255, 255, 255, 0.9); 
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
            width: 400px;
            transition: transform 0.2s;
        }
        .form-card:hover {
            transform: translateY(-5px);
        }
        .logo {
            font-size: 70px; 
            color: #ff0000; 
            margin-bottom: 20px;
            text-align: center; 
        }
        .btn-primary {
            background-color: #ff0000; 
            border: none;
        }
        .btn-primary:hover {
            background-color: #cc0000; 
        }
        .text-muted {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="logo">
            <i class="fas fa-book"></i> 
        </div>
        <h2 class="text-center">Iniciar Sesión</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo Institucional</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email" required placeholder="Ingrese su correo">
                </div>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" required placeholder="Ingrese su contraseña">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            <div class="text-muted">
                <p><a href="#">¿Olvidaste tu contraseña?</a></p>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> <!-- SweetAlert -->
</body>
</html>
