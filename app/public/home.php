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
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center">Bienvenido, <?= htmlspecialchars($nombre); ?></h2>
            <p class="text-center">Rol: <?= htmlspecialchars($rol); ?></p>
            <a href="logout.php" class="btn btn-danger d-block mx-auto" style="max-width: 200px;">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
