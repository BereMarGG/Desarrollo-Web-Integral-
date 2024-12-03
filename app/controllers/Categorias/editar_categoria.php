<?php
require_once '../../config/database.php'; // Asegúrate de tener la conexión correcta

// Verificar la conexión a la base de datos
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $idcategoria = $_POST['idcategoria'];  // Esta variable debe coincidir con la que estás utilizando más abajo
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Preparar la consulta SQL
    $sql = "UPDATE categoria SET nombre = ?, descripcion = ? WHERE idcategoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre, $descripcion, $idcategoria);  // Usamos $idusuario aquí

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si se ejecuta correctamente, redirige a la página de categorías
        header("Location: ../../public/crud_categorias.php");
        exit();
    } else {
        // Si falla la consulta, redirige a la página principal
        header("Location: ../../public/home.php");
        exit();
    }
}

?>