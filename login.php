<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Alojamientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .login-container {
            margin-top: 100px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: none;
            padding: 25px;
            border-radius: 15px 15px 0 0 !important;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #e1e1e1;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0056b3;
        }

        .btn-primary {
            padding: 12px;
            border-radius: 10px;
            background-color: #0056b3;
            border: none;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #003d82;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-title {
            color: #0056b3;
            font-weight: bold;
        }

        .form-label {
            font-weight: 500;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-home me-2"></i>Alojamientos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title mb-0">Iniciar Sesión</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Email o contraseña incorrectos
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($_GET['registered'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                Registro exitoso. Por favor, inicie sesión
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if(isset($_GET['logout'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                Has cerrado sesión exitosamente
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="login_process.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control" 
                                           id="email" 
                                           name="email" 
                                           required
                                           autocomplete="email"
                                           placeholder="tucorreo@ejemplo.com">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password" 
                                           required
                                           autocomplete="current-password"
                                           placeholder="••••••••">
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">¿No tienes una cuenta? 
                                <a href="register.php" class="text-primary fw-bold">
                                    Regístrate aquí
                                </a>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="text-center mt-4">
                    <a href="forgot-password.php" class="text-muted me-3">
                        <i class="fas fa-key me-1"></i>¿Olvidaste tu contraseña?
                    </a>
                    <a href="contact.php" class="text-muted">
                        <i class="fas fa-question-circle me-1"></i>Ayuda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }


        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.createElement('span');
            togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
            togglePassword.className = 'input-group-text';
            togglePassword.style.cursor = 'pointer';
            
            const passwordInput = document.getElementById('password');
            passwordInput.parentElement.appendChild(togglePassword);

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        });
    </script>
</body>
</html>