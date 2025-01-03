<?php

require_once __DIR__ . '/vendor/autoload.php';
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header('Location: login.php');
    exit();
}

use App\Models\User;
use App\Models\Alojamiento;

$alojamiento = new Alojamiento();
$alojamientos = $alojamiento->getAll();
$reservaciones = $alojamiento->getAllReservations();


$successMessage = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            background-color: #2c3e50;
            color: white;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .nav-link {
            color: #ecf0f1;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        
        .nav-link:hover {
            background-color: #34495e;
            color: white;
        }
        
        .nav-link.active {
            background-color: #3498db;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 2px solid #f8f9fa;
        }
        
        .stats-card {
            transition: transform 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .table th {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .badge {
            padding: 8px 12px;
        }

        .alert-floating {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            animation: fadeOut 5s forwards;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>
    <?php if ($successMessage): ?>
    <div class="alert alert-success alert-floating" role="alert">
        <?php echo htmlspecialchars($successMessage); ?>
    </div>
    <?php endif; ?>


    <div class="sidebar" style="width: 250px;">
        <h3 class="mb-4 text-white">Panel Admin</h3>
        <div class="d-flex flex-column">
            <a href="admin_dashboard.php" class="nav-link active">
                <i class='bx bxs-dashboard me-2'></i> Dashboard
            </a>
            <a href="#" class="nav-link">
                <i class='bx bxs-building-house me-2'></i> Alojamientos
            </a>
            <a href="#" class="nav-link">
                <i class='bx bxs-calendar me-2'></i> Reservaciones
            </a>
            <a href="#" class="nav-link">
                <i class='bx bxs-user-account me-2'></i> Usuarios
            </a>
            <a href="logout.php" class="nav-link mt-auto">
                <i class='bx bxs-log-out me-2'></i> Cerrar Sesión
            </a>
        </div>
    </div>


    <div class="main-content">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stats-card bg-primary text-white">
                        <div class="card-body">
                            <h5>Total Alojamientos</h5>
                            <h2><?php echo count($alojamientos); ?></h2>
                            <i class='bx bxs-building-house position-absolute end-0 bottom-0 mb-3 me-3' style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stats-card bg-success text-white">
                        <div class="card-body">
                            <h5>Reservaciones Activas</h5>
                            <h2><?php echo count($reservaciones); ?></h2>
                            <i class='bx bxs-calendar position-absolute end-0 bottom-0 mb-3 me-3' style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">Gestionar Alojamientos</h5>
                    <button type="button" class="btn btn-primary" onclick="showAddModal()">
                        <i class='bx bx-plus me-1'></i> Agregar Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($alojamientos as $aloj): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($aloj['id']); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars($aloj['imagen_url']); ?>" 
                                                 class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <?php echo htmlspecialchars($aloj['nombre']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($aloj['ubicacion']); ?></td>
                                    <td>$<?php echo number_format($aloj['precio'], 2); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning me-1" 
                                                onclick='editAlojamiento(<?php echo json_encode($aloj); ?>)'>
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        <form action="delete_alojamiento.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id" value="<?php echo $aloj['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('¿Está seguro de eliminar este alojamiento?')">
                                                <i class='bx bxs-trash'></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header py-3">
                    <h5 class="mb-0">Reservaciones Activas</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Alojamiento</th>
                                    <th>Fecha de Reserva</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($reservaciones as $reserva): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-2">
                                                <i class='bx bxs-user'></i>
                                            </div>
                                            <?php echo htmlspecialchars($reserva['username']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($reserva['nombre_alojamiento']); ?></td>
                                    <td><?php echo htmlspecialchars($reserva['fecha_reserva']); ?></td>
                                    <td>
                                        <span class="badge bg-success rounded-pill">Activa</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="alojamientoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Agregar Nuevo Alojamiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="alojamientoForm" action="add_alojamiento.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="alojamientoId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="imagen_url" class="form-label">URL de la Imagen</label>
                                <input type="text" class="form-control" id="imagen_url" name="imagen_url" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bxs-save me-1'></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        function showAddModal() {
            document.getElementById('modalTitle').textContent = 'Agregar Nuevo Alojamiento';
            document.getElementById('alojamientoForm').action = 'add_alojamiento.php';
            document.getElementById('alojamientoId').value = '';
            document.getElementById('alojamientoForm').reset();
            new bootstrap.Modal(document.getElementById('alojamientoModal')).show();
        }

        function editAlojamiento(alojamiento) {
            document.getElementById('modalTitle').textContent = 'Editar Alojamiento';
            document.getElementById('alojamientoForm').action = 'update_alojamiento.php';
            document.getElementById('alojamientoId').value = alojamiento.id;
            document.getElementById('nombre').value = alojamiento.nombre;
            document.getElementById('descripcion').value = alojamiento.descripcion;
            document.getElementById('precio').value = alojamiento.precio;
            document.getElementById('ubicacion').value = alojamiento.ubicacion;
            document.getElementById('imagen_url').value = alojamiento.imagen_url;
            
            new bootstrap.Modal(document.getElementById('alojamientoModal')).show();
        }


        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-floating');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.remove();
                }, 5000);
            });
        });
    </script>
</body>
</html>