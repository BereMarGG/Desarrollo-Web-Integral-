<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Conexión a la base de datos
require_once '../config/database.php';

// Consultar artículos
$sql = "SELECT * FROM articulo";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Artículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Gestión de Artículos</h2>
    <a href="agregar_articulo.php" class="btn btn-primary mb-3">Agregar Artículo</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Idcategoria</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows == 0): ?>
                <!-- Mensaje si no hay artículos -->
                <tr>
                    <td colspan="4" class="text-center">
                        <h5>No hay artículos disponibles</h5>
                    </td>
                </tr>
            <?php else: ?>
                <!-- Iterar artículos si hay filas -->
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['idarticulo']); ?></td>
                        <td><?= htmlspecialchars($row['idcategoria']); ?></td>
                        <td><?= htmlspecialchars($row['codigo']); ?></td>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['stock']); ?></td>
                        <td><?= htmlspecialchars($row['precio_venta']); ?></td>
                        <td>
                            <a href="editar_articulo.php?id=<?= htmlspecialchars($row['idarticulo']); ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_articulo.php?id=<?= htmlspecialchars($row['idarticulo']); ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
