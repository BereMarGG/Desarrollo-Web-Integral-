<?php
// Crear la conexión
$conn = new mysqli("localhost", "quack", "mysql", "bd_quickyfast");

// Verificar si hubo error en la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Retornar la conexión
return $conn;
?>
