<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
    exit();
}

// Obtener carrito desde la sesión
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Carrito</title>
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
        <h1 class="text-center mb-4">Mi Carrito</h1>

        <?php if (!empty($carrito)): ?>
            <table class="table table-bordered shadow">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Artículo</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGeneral = 0;
                    foreach ($carrito as $index => $item):
                        $totalArticulo = $item['precio_venta'] * $item['cantidad'];
                        $totalGeneral += $totalArticulo;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nombre']); ?></td>
                            <td class="text-center">$<?= number_format($item['precio_venta'], 2); ?></td>
                            <td class="text-center">
                                <form action="actualizar_carrito.php" method="post" class="d-inline">
                                    <input type="hidden" name="index" value="<?= $index; ?>">
                                    <input type="number" name="cantidad"
                                        value="<?= isset($item['cantidad']) ? htmlspecialchars($item['cantidad']) : 1; ?>"
                                        min="1" max="<?= htmlspecialchars($item['stock'] ?? 1); ?>"
                                        class="form-control form-control-sm w-50 mx-auto">
                                    <button type="submit" class="btn btn-primary btn-sm mt-1">Actualizar</button>
                                </form>
                            </td>
                            <td class="text-center">$<?= number_format($totalArticulo, 2); ?></td>
                            <td class="text-center">
                                <form action="eliminar_del_carrito.php" method="post">
                                    <input type="hidden" name="index" value="<?= $index; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total General:</td>
                        <td class="text-center fw-bold">$<?= number_format($totalGeneral, 2); ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="comprar_articulos.php" class="btn btn-secondary">Seguir Comprando</a>
                <a href="procesar_compra.php" class="btn btn-success">Proceder al Pago</a>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                Tu carrito está vacío. <a href="comprar_articulos.php" class="alert-link">Empieza a comprar ahora</a>.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>