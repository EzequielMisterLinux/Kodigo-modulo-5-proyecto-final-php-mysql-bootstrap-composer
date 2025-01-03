<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

use App\Models\User;
use App\Models\Alojamiento;

$user = new User();
$alojamientos = $user->getAlojamientos($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .profile-section {
            background: linear-gradient(to right, #2c3e50, #3498db);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        .btn-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class='bx bxs-building-house me-2'></i>
                Alojamientos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link active" href="account.php">
                            <i class='bx bxs-user me-1'></i>
                            Mi Cuenta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class='bx bxs-log-out me-1'></i>
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="profile-section">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start mb-3 mb-md-0">
                    <img src="https://via.placeholder.com/120" alt="Profile" class="profile-image">
                </div>
                <div class="col-md-10">
                    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
                    <p class="mb-0">Gestiona tus alojamientos y reservaciones desde aquí</p>
                </div>
            </div>
        </div>

        <?php if ($_SESSION['is_admin']): ?>
       
        <div class="card">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0">Agregar Nuevo Alojamiento</h4>
            </div>
            <div class="card-body">
                <form action="add_new_alojamiento.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="precio" class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="imagen_url" class="form-label">URL de la Imagen</label>
                        <input type="text" class="form-control" id="imagen_url" name="imagen_url" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-plus-circle me-1'></i>
                            Agregar Alojamiento
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php else: ?>

        <div class="row">
            <div class="col-12 mb-4">
                <h3>Mis Alojamientos Seleccionados</h3>
            </div>
            <?php if (empty($alojamientos)): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class='bx bxs-home' style="font-size: 4rem; color: #dee2e6;"></i>
                        <h4 class="mt-3">No has seleccionado ningún alojamiento aún</h4>
                        <p class="text-muted">Explora nuestros alojamientos disponibles y encuentra el perfecto para ti</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class='bx bx-search-alt me-1'></i>
                            Explorar Alojamientos
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <?php foreach($alojamientos as $aloj): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($aloj['imagen_url']); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($aloj['nombre']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($aloj['nombre']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($aloj['descripcion']); ?></p>
                            <div class="d-flex align-items-center mb-3">
                                <i class='bx bxs-map me-2 text-primary'></i>
                                <span class="text-muted"><?php echo htmlspecialchars($aloj['ubicacion']); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">$<?php echo number_format($aloj['precio'], 2); ?></span>
                                <form action="remove_alojamiento.php" method="POST">
                                    <input type="hidden" name="alojamiento_id" value="<?php echo $aloj['id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class='bx bx-trash me-1'></i>
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>


        <a href="index.php" class="btn btn-primary btn-floating">
            <i class='bx bx-plus'></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>