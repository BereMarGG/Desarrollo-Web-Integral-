<?php

session_start();

// Verificar si el usuario tiene el rol adecuado (suponiendo que el rol 1 es para administradores)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Incluir el archivo de configuración de la base de datos
require_once '../../config/database.php';

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $idrol = $_POST['idrol'];
    $nombre = $_POST['nombre'];
    $tipo_documento = $_POST['tipo_documento'];
    $num_documento = $_POST['num_documento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Cifrar la contraseña (SHA-256) y convertir el hash binario a formato hexadecimal
    $password_hash = hash('sha256', $password, true); // Genera el hash binario
    $password_hash_hex = bin2hex($password_hash); // Convierte el hash binario a formato hexadecimal
    
    // Establecer el valor de estado
    $estado = 1; // El estado 1 significa "activo"

    // Consultar la base de datos para insertar el nuevo usuario
    $sql = "INSERT INTO usuario (idrol, nombre, tipo_documento, num_documento, direccion, telefono, email, password, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Ahora estamos pasando un valor para "estado"
    
    $stmt = $conn->prepare($sql);

    // Vincular los parámetros al prepared statement
    // Usamos 's' para todos los campos de texto, 'b' para el parámetro binario y 'i' para el parámetro entero estado
    $stmt->bind_param("ssssssssi", $idrol, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $password_hash_hex, $estado);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir al listado de usuarios después de agregar
        header("Location: ../../public/crud_usuario.php");
        exit();
    } else {
        // Mostrar mensaje de error si falla la inserción
        die("Error al agregar el usuario: " . $conn->error);
    }
}

?>
