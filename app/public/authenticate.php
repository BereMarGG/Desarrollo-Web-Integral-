<?php
session_start();

// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'bd_quickyfast'; // Cambia esto por el nombre de tu base de datos
$user = 'root'; // Cambia esto si tu usuario no es root
$password = ''; // Agrega la contraseña si aplica

$conn = new mysqli($host, $user, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Preparar la consulta para buscar al usuario
$sql = "SELECT * FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (hash('sha256', $password) === $user['password']) {
        // Guardar datos del usuario en la sesión
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['idrol'];
        
        // Redirigir según el rol
        if ($user['idrol'] == 1) { // Admin
            header("Location: home.php");
        } elseif ($user['idrol'] == 2) { // Cliente
            header("Location: client_home.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
