<?php
session_start();

//CREACIÓN DEL USER
// CREATE USER 'quack'@'localhost' IDENTIFIED BY 'mysql';
// GRANT ALL PRIVILEGES ON bd_quickyfast.* TO 'quack'@'localhost';

// Configuración de conexión a la base de datos
$host = 'localhost';
$db = 'bd_quickyfast'; // Cambia esto por el nombre de tu base de datos
$user = 'root'; // Cambia esto si tu usuario no es root
$password = ''; // Agrega la contraseña si aplica

// Definir una clave secreta para mayor seguridad
$secret_key = '1015D48D6DS21A5F4F6E8S1X21C3VF8E4S8CV41F2.DSXC1V6F84D6C';

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

    $hashed_password = hash('sha256', $password . $secret_key, true);


    //$password_hash = hash('sha256', $password, true); // Genera el hash binario
   
   
    $password_hash_hex = bin2hex($hashed_password); // Convierte el hash binario a formato hexadecimal
    



    // Verificar la contraseña
    if ($hashed_password === $user['password']) {
        // Guardar datos del usuario en la sesión
        $_SESSION['usuario'] = $user['nombre'];
        $_SESSION['rol'] = $user['idrol'];
        
        // Redirigir según el rol
        if ($user['idrol'] == 1) { // Admin
            header("Location: ../home.php");
        } elseif ($user['idrol'] == 2) { // Cliente
            header("Location: ../client_home.php");
        } else {
            header("Location: home.php");
        }
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
        echo "<script>console.log('Entered Password: " . $password . "');</script>";
        echo "<script>console.log('Hashed Password: " . $hashed_password . "');</script>";
        echo "<script>console.log('Hashed PasswordBD: " . $user['password'] . "');</script>";
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
