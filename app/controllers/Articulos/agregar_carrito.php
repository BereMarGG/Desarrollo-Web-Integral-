<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
    header("Location: home.php");
    exit();
}

// Verificar si se envió el formulario correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idarticulo'], $_POST['cantidad'])) {
    $idArticulo = intval($_POST['idarticulo']);
    $cantidad = intval($_POST['cantidad']);

    // Conexión a la base de datos
    require_once '../../config/database.php';

    // Obtener el stock del artículo
    $articulo = $conn->query("SELECT * FROM articulo WHERE idarticulo = $idArticulo")->fetch_assoc();

    if (!$articulo || $articulo['estado'] != 1 || $cantidad > $articulo['stock']) {
        die("Error: Artículo no válido o cantidad supera el stock disponible.");
    }

    // Añadir al carrito
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Verificar si el artículo ya está en el carrito
    if (isset($_SESSION['carrito'][$idArticulo])) {
        $_SESSION['carrito'][$idArticulo]['cantidad'] += $cantidad;
    } else {
        $_SESSION['carrito'][$idArticulo] = [
            'nombre' => $articulo['nombre'],
            'precio_venta' => $articulo['precio_venta'],
            'cantidad' => $cantidad,
        ];
    }

    // Redirigir de vuelta al catálogo
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>
