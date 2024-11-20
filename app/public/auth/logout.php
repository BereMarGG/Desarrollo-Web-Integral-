<?php
session_start(); // Iniciar la sesión si no está iniciada

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página principal o de inicio de sesión
header("Location: login.php"); // Cambia "index.php" por la página a la que quieres redirigir
exit();
