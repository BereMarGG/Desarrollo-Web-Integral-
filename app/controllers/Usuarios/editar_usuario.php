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

    $sql = "UPDATE usuario SET idrol = ?, nombre = ?, tipo_documento = ?, num_documento = ?, direccion = ?, telefono = ?, email = ? WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $idrol, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);




  
}

// Consultar los roles disponibles para el select

/*
$roles_sql = "SELECT idrol, nombre_rol FROM rol";
$roles_result = $conn->query($roles_sql);
if (!$roles_result) {
    die("Error al obtener los roles: " . $conn->error);
}


*/

?>