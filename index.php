<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alojamientos | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('https://images.unsplash.com/photo-1564501049412-61c2a3083791?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 3rem;
        }

        .card {
            transition: transform 0.3s ease;
            margin-bottom: 2rem;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .price-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
        }

        .location-icon {
            color: #dc3545;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #003d82;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 3rem 0;
            margin-top: 4rem;
        }
    </style>
</head>
<body>
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    use App\Models\Alojamiento;
    session_start();
    
    $alojamiento = new Alojamiento();
    $alojamientos = $alojamiento->getAll();
    ?>


    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-home me-2"></i>Alojamientos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="account.php">
                                <i class="fas fa-user me-1"></i>Mi Cuenta
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">
                                <i class="fas fa-user-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4">Encuentra tu alojamiento perfecto</h1>
            <p class="lead">Descubre lugares únicos para hospedarte en cualquier parte del mundo</p>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-center mb-4">Alojamientos Disponibles</h2>
                <p class="text-center text-muted mb-5">Explora nuestra selección de alojamientos cuidadosamente elegidos</p>
            </div>
        </div>

        <div class="row">
            <?php foreach($alojamientos as $aloj): ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="position-relative">
                        <img src="<?php echo htmlspecialchars($aloj['imagen_url']); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($aloj['nombre']); ?>">
                        <div class="price-badge">
                            $<?php echo number_format($aloj['precio'], 2); ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($aloj['nombre']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($aloj['descripcion']); ?></p>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt location-icon me-2"></i>
                            <small class="text-muted"><?php echo htmlspecialchars($aloj['ubicacion']); ?></small>
                        </p>
                        <?php if(isset($_SESSION['user_id']) && !$_SESSION['is_admin']): ?>
                        <form action="add_alojamiento.php" method="POST">
                            <input type="hidden" name="alojamiento_id" value="<?php echo $aloj['id']; ?>">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-check me-2"></i>Seleccionar
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Sobre Nosotros</h5>
                    <p>Ofrecemos los mejores alojamientos para hacer de tu estadía una experiencia inolvidable.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces Rápidos</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white">Inicio</a></li>
                        <li><a href="about.php" class="text-white">Sobre Nosotros</a></li>
                        <li><a href="contact.php" class="text-white">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i> ezequiel@alojamientos.com</li>
                        <li><i class="fas fa-phone me-2"></i> +503 7777 4551</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i> Calle Principal Usulutan</li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> team linux. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>