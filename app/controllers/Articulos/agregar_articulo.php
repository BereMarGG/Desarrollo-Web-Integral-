<?php
session_start();

// Verificar si el usuario tiene el rol adecuado (rol 1 = administrador)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: ../../views/home.php");
    exit();
}

// Incluir la configuración de la base de datos
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCategoria = intval($_POST['idcategoria']);
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $stock = intval($_POST['stock']);
    $precioVenta = floatval($_POST['precio_venta']);

    // Consulta SQL para insertar un nuevo artículo
    $sql = "INSERT INTO articulo (idcategoria, codigo, nombre, stock, precio_venta) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issid", $idCategoria, $codigo, $nombre, $stock, $precioVenta);

    if ($stmt->execute()) {
        header("Location: ../../public/crud_articulos.php");
        exit();
    } else {
        die("Error al agregar el artículo: " . $stmt->error);
    }
}
?>
