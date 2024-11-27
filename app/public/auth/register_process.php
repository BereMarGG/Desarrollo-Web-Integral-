<?php
session_start();

//CREACIÓN DEL USER
// CREATE USER 'quack'@'localhost' IDENTIFIED BY 'mysql';
// GRANT ALL PRIVILEGES ON bd_quickyfast.* TO 'quack'@'localhost';

// Configuración de conexión a la base de datos

/*
$host = 'localhost';
$db = 'bd_quickyfast'; // Cambia esto por el nombre de tu base de datos
$user = 'quack'; // Cambia esto si tu usuario no es root
$password = 'mysql'; // Agrega la contraseña si aplica
*/

$host = 'autorack.proxy.rlwy.net';
$user = 'root';
$password = 'RzcVPFcTdLZRcwxZgtXMADBRBPsuXgZA';
$db = 'bd_quickyfast';
$port = '48525';

// Definir una clave secreta para mayor seguridad
$secret_key = '1015D48D6DS21A5F4F6E8S1X21C3VF8E4S8CV41F2.DSXC1V6F84D6C';

$conn = new mysqli($host, $user, $password, $db, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa";
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

// Validar que no falten datos
if (empty($nombre) || empty($email) || empty($password) || empty($password2)) {
    echo "<script>alert('Todos los campos son obligatorios'); window.history.back();</script>";
    exit();
}

// Verificar si el correo ya existe
$sql = "SELECT email FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>alert('El correo ya está registrado'); window.history.back();</script>";
} else {

    $password = hash('sha256', $password);
    $password2 = hash('sha256', $password2);

    if ($password != $password2) {
        echo "<script>alert('Las contraseñas no coinciden.'); window.history.back();</script>";
    } else {

        // Encriptar la contraseña con clave secreta
        $hashed_password = hash('sha256', $password . $secret_key);

        // Insertar el nuevo usuario
        $insert_sql = "INSERT INTO usuario (idrol, nombre, email, password) VALUES (2, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);

        if ($insert_stmt === false) {
            // Muestra un error si la preparación de la sentencia falla
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "'); window.history.back();</script>";
            exit();
        }

        $insert_stmt->bind_param("sss", $nombre, $email, $hashed_password);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Registro exitoso'); window.location='login.php';</script>";
        } else {
            // Mostrar detalles del error si la ejecución falla
            echo "<script>
                    alert('" . addslashes("Error al registrar el usuario: " . $insert_stmt->error) . "'); 
                    window.history.back();
                </script>";
        }

        $insert_stmt->close();
    }
}

// Cerrar la conexión
$stmt->close();
$conn->close();
