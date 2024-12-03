<?php
session_start();

// Verificar rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../views/home.php");
    exit();
}

// Incluir configuración de la base de datos
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idArticulo = intval($_POST['idarticulo']);
    $idCategoria = intval($_POST['idcategoria']);
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $stock = intval($_POST['stock']);
    $precioVenta = floatval($_POST['precio_venta']);

    // Consulta para actualizar artículo
    $sql = "UPDATE articulo 
            SET idcategoria = ?, codigo = ?, nombre = ?, stock = ?, precio_venta = ? 
            WHERE idarticulo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issidi", $idCategoria, $codigo, $nombre, $stock, $precioVenta, $idArticulo);

    if ($stmt->execute()) {
        header("Location: ../../public/crud_articulos.php");
        exit();
    } else {
        die("Error al editar el artículo: " . $stmt->error);
    }
}
?>
