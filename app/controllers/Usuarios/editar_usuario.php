<?php
require_once '../../config/database.php'; // Asegúrate de tener la conexión correcta

// Verificar la conexión a la base de datos
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $idusuario = $_POST['idusuario'];
    $idrol = $_POST['idrol'];
    $nombre = $_POST['nombre'];
    $tipo_documento = $_POST['tipo_documento'];
    $num_documento = $_POST['num_documento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];



    

    // Preparar la consulta de actualización
    $sql = "UPDATE usuario SET nombre = ?, tipo_documento = ?, num_documento = ?, direccion = ?, telefono = ?, email = ? WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);

    // Verificar si la preparación fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Enlazar los parámetros
    $stmt->bind_param("ssssssi", $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $idusuario);


    // Ejecutar la consulta
    if ($stmt->execute()) {

        header("Location: ../../public/crud_usuario.php");
        exit();
        
    } else {

        header("Location: ../../public/home.php");
        exit();
        

    }
}

?>
