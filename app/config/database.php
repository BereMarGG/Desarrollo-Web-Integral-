<?php
// Crear la conexión
//$conn = new mysqli("localhost", "quack", "mysql", "bd_quickyfast");

$host = 'autorack.proxy.rlwy.net';
$user = 'root';
$password = 'RzcVPFcTdLZRcwxZgtXMADBRBPsuXgZA';
$db = 'bd_quickyfast';
$port = '48525';

$conn = new mysqli($host, $user, $password, $db, $port);

// Verificar si hubo error en la conexión
if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conn->connect_error);
}

// Retornar la conexión
return $conn;
?>
