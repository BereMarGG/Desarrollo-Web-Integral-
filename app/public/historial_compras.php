<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

require_once '../controllers/Historial/VentaController.php';

// Obtener carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$idCliente = $_SESSION['idusuario'];
$ventaController = new VentaController();
$historialVentas = $ventaController->obtenerHistorial($idCliente);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                    <li class="nav-item">
                        <a class="nav-link" href="comprar_articulos.php">Comprar Artículos</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light">Hola, <?= htmlspecialchars($_SESSION['usuario']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger ms-2" href="auth/logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">
            <a href="carrito.php" class="ms-3 text-decoration-none text-secondary">
                Mi Carrito
            </a>
            <i class="bi bi-clock-history"></i> Historial de compras
        </h1>
        <div class="row">
            <?php if (!empty($historialVentas)): ?>
                <?php foreach ($historialVentas as $venta): ?>
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Venta #<?= $venta['idventa']; ?></h5>
                                <p>Comprobante: <?= $venta['tipo_comprobante'] . " - " . $venta['serie_comprobante'] . $venta['num_comprobante']; ?></p>
                                <p>Fecha: <?= $venta['fecha_hora']; ?></p>
                                <p>Estado: <?= $venta['estado']; ?></p>
                                <p>Total: $<?= $venta['total']; ?> (Impuesto: $<?= $venta['impuesto']; ?>)</p>
                            </div>
                            <div class="card-body">
                                <h6>Artículos</h6>
                                <ul class="list-group">
                                    <?php foreach ($venta['articulos'] as $articulo): ?>
                                        <li class="list-group-item">
                                            <strong>Artículo:</strong> <?= $articulo['nombre']; ?> <br>
                                            <strong>Cantidad:</strong> <?= $articulo['cantidad']; ?> <br>
                                            <strong>Precio Unitario:</strong> $<?= $articulo['precio']; ?> <br>
                                            <strong>Descuento:</strong> $<?= $articulo['descuento']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-footer text-end">
                                <a href="../controllers/PdfController.php?idventa=<?= $venta['idventa']; ?>" class="btn btn-primary">
                                    Descargar Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No tienes compras en tu historial.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>