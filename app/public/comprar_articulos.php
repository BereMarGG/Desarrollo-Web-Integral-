<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: auth/login.php");
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
    <title>Articulos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="carrito.php">
                        <i class="bi bi-cart-fill text-light" style="font-size: 1rem;"></i>
                            <span class="position-absolute top-25 start-30 translate-middle badge rounded-pill bg-danger">
                                <?= isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>
                            </span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="navbar-text text-light">Hola, <?= htmlspecialchars($nombre); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger ms-2" href="auth/logout.php">Cerrar Sesión</a>
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
        <div class="container mt-5">
            <h2 class="text-center">Catálogo de Artículos</h2>
            <div class="row mb-4">
                <form method="GET" class="d-flex">
                    <select name="categoria" class="form-select me-2">
                        <option value="">Selecciona una categoría</option>
                        <?php
                        // Conexión a la base de datos
                        $conexion = new mysqli('localhost', 'quack', 'mysql', 'bd_quickyfast');
                        $categorias = $conexion->query("SELECT * FROM categoria WHERE estado = 1");
                        while ($categoria = $categorias->fetch_assoc()) {
                            echo "<option value='{$categoria['idcategoria']}'>{$categoria['nombre']}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-primary">Ver Artículos</button>
                </form>
            </div>

            <div class="row">
                <?php
                if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                    $idCategoria = intval($_GET['categoria']);
                    $articulos = $conexion->query("SELECT * FROM articulo WHERE idcategoria = $idCategoria AND estado = 1");
                    while ($articulo = $articulos->fetch_assoc()) {
                        echo "
                <div class='col-md-4 mb-3'>
                    <div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$articulo['nombre']}</h5>
                            <p class='card-text'>{$articulo['descripcion']}</p>
                            <p class='card-text'>Precio: \${$articulo['precio_venta']}</p>
                            <p class='card-text'>Stock: {$articulo['stock']}</p>
                            <form method='POST' action='../controllers/Articulos/agregar_carrito.php'>
                                <input type='hidden' name='idarticulo' value='{$articulo['idarticulo']}'>
                                <div class='mb-3'>
                                    <label for='cantidad-{$articulo['idarticulo']}' class='form-label'>Cantidad</label>
                                    <input type='number' name='cantidad' id='cantidad-{$articulo['idarticulo']}' class='form-control' min='1' max='{$articulo['stock']}' required>
                                </div>
                                <button type='submit' class='btn btn-success'>Añadir al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
                ";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>