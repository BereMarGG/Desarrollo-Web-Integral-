<?php

session_start();

// Verificar si el usuario tiene el rol adecuado (suponiendo que el rol 1 es para administradores)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Incluir el archivo de configuración de la base de datos
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = $_POST['nombre_categoria'];
    $descripcion = $_POST['desc_categoria'];


    $estado = 1; 

    // Consultar la base de datos para insertar el nuevo usuario
    $sql = "INSERT INTO categoria (nombre, descripcion,  estado) 
            VALUES (?, ?, ?)"; // Ahora estamos pasando un valor para "estado"
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $estado);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al listado de usuarios después de agregar
        header("Location: ../../public/crud_categorias.php");
        exit();
    } else {
        // Mostrar mensaje de error si falla la inserción
        die("Error al agregar la categoria: " . $conn->error);
    }
}

?>
