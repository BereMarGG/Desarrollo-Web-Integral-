<?php

session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}


require_once '../../config/database.php';

if (isset($_POST['idusuario'])) {
    $idusuario = $_POST['idusuario'];

    // Preparar y ejecutar la consulta para eliminar el usuario
    $sql = "UPDATE usuario SET estado = 3 WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idusuario);

    if ($stmt->execute()) {
        // Redirigir a la página de gestión de usuarios después de eliminar
        header("Location: ../../public/crud_usuario.php");
        exit();
    } else {
        // Mostrar error si la eliminación falla
        die("Error al eliminar el usuario: " . $conn->error);
    }
} else {
    // Si no se recibe el ID, redirigir al inicio
    header("Location: ../../public/home.php");
    exit();
}


?>