<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Alojamientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .register-container {
            margin-top: 80px;
            margin-bottom: 40px;
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

        .card-title {
            color: #0056b3;
            font-weight: bold;
        }

        .form-label {
            font-weight: 500;
        }

        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background-color: #dc3545;
            width: 33%;
        }

        .strength-medium {
            background-color: #ffc107;
            width: 66%;
        }

        .strength-strong {
            background-color: #28a745;
            width: 100%;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
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
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="register.php">
                            <i class="fas fa-user-plus me-1"></i>Registrarse
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="card-title mb-0">Crear Cuenta</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                Error en el registro. Por favor, intente nuevamente.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form action="register_process.php" method="POST" id="registerForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="username" 
                                           name="username" 
                                           required
                                           placeholder="Tu nombre de usuario">
                                </div>
                            </div>
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
                                           placeholder="tucorreo@ejemplo.com">
                                </div>
                            </div>
                            <div class="mb-3">
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
                                           placeholder="••••••••">
                                </div>
                                <div class="password-strength" id="passwordStrength"></div>
                                <small class="text-muted">La contraseña debe tener al menos 8 caracteres</small>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="confirm_password"
                                           name="confirm_password" 
                                           required
                                           placeholder="••••••••">
                                </div>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="mb-0">¿Ya tienes una cuenta? 
                                <a href="login.php" class="text-primary fw-bold">
                                    Inicia sesión aquí
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordStrength = document.getElementById('passwordStrength');
            const form = document.getElementById('registerForm');


            password.addEventListener('input', function() {
                const value = this.value;
                let strength = 0;
                
                if (value.length >= 8) strength++;
                if (value.match(/[a-z]/) && value.match(/[A-Z]/)) strength++;
                if (value.match(/\d/)) strength++;
                
                passwordStrength.className = 'password-strength';
                if (strength === 1) passwordStrength.classList.add('strength-weak');
                else if (strength === 2) passwordStrength.classList.add('strength-medium');
                else if (strength === 3) passwordStrength.classList.add('strength-strong');
            });


            form.addEventListener('submit', function(e) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Las contraseñas no coinciden');
                }
            });


            const togglePassword = function(inputId) {
                const toggleBtn = document.createElement('span');
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                toggleBtn.className = 'input-group-text';
                toggleBtn.style.cursor = 'pointer';
                
                const input = document.getElementById(inputId);
                input.parentElement.appendChild(toggleBtn);

                toggleBtn.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });
            };

            togglePassword('password');
            togglePassword('confirm_password');
        });
    </script>
</body>
</html>