<?php

session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}


require_once '../../config/database.php';

if (isset($_POST['idcategoria'])) {
    $idcategoria = $_POST['idcategoria'];

    $checkSql = "SELECT * FROM categoria WHERE idcategoria = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $idcategoria);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows === 0) {
        die("No se encontró una categoría con ese ID.");
    } else {

         // Preparar y ejecutar la consulta para eliminar el usuario
         $sql = "UPDATE `categoria` SET `estado` = 0 WHERE `idcategoria` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idcategoria);
        
        if($stmt->execute()){

            header("Location: ../../public/crud_categorias.php");
              die();


        } else{

            die("Error al eliminar la categoria: " . $conn->error);


        }


    }



} else {
    // Si no se recibe el ID, redirigir al inicio
    header("Location: ../../public/home.php");
    exit();
}


?>