<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario desde la sesión
$nombre = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Mi Tienda</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Inicio</a>
                    </li>
                    <?php if ($rol == 1): // Admin ?>
                        <li class="nav-item">
                            <a class="nav-link" href="crud_articulos.php">CRUD Artículos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="crud_usuarios.php">CRUD Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="crud_compras.php">CRUD Compras</a>
                        </li>
                    <?php elseif ($rol == 2): // Cliente ?>
                        <li class="nav-item">
                            <a class="nav-link" href="comprar_articulos.php">Comprar Artículos</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light">Hola, <?= htmlspecialchars($nombre); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger ms-2" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Bienvenido, <?= htmlspecialchars($nombre); ?></h2>
            <p class="text-center">Rol: <?= ($rol == 1) ? 'Administrador' : 'Cliente'; ?></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
