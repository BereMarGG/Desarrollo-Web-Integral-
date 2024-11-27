<?php
session_start();

// Verificar si el índice fue enviado y si el carrito existe
if (isset($_POST['index']) && isset($_SESSION['carrito'])) {
    $index = (int)$_POST['index'];
    
    // Eliminar el artículo del carrito
    if (isset($_SESSION['carrito'][$index])) {
        unset($_SESSION['carrito'][$index]);
        // Reindexar el carrito para evitar índices vacíos
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    }
}

// Redirigir de vuelta al carrito
header("Location: .../../../../public/carrito.php");
exit();
