<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Conexión a la base de datos
require_once '../config/database.php';

// Consultar artículos
$sql = "SELECT idusuario, nombre, tipo_documento, num_documento, direccion, telefono, email, estado FROM usuario WHERE estado = 1";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD USUARIOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Gestión de Usuarios</h2>
    <a href="../controllers/Usuarios/agregar_usuario.php" class="btn btn-primary mb-3">Agregar Usuario</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo de Documento</th>
                <th>Numero de Documento</th>
                <th>Dirección</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows == 0): ?>
                <!-- Mensaje si no hay usuarios -->
                <tr>
                    <td colspan="9" class="text-center">
                        <h5>No hay usuarios disponibles</h5>
                    </td>
                </tr>
            <?php else: ?>
                <!-- Iterar usuarios si hay filas -->
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['idusuario']); ?></td>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['tipo_documento']); ?></td>
                        <td><?= htmlspecialchars($row['num_documento']); ?></td>
                        <td><?= htmlspecialchars($row['direccion']); ?></td>
                        <td><?= htmlspecialchars($row['telefono']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td>
                        <?php 
                            
                                if ($row['estado'] == 1) {
                                    echo '<span class="text-success">Activo</span>';
                                } else if ($row['estado'] == 2) {
                                    echo '<span class="text-danger">Inactivo</span>';
                                }
                            ?>


                        </td>
                        <td>
                            <a href="../controllers/Usuarios/editar_usuario.php?id=<?= htmlspecialchars($row['idusuario']); ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botón para activar el modal de eliminación -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="<?= htmlspecialchars($row['idusuario']); ?>" data-nombre="<?= htmlspecialchars($row['nombre']); ?>">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar a este usuario?
                <br><br>
                <strong id="userName"></strong>
            </div>
            <div class="modal-footer">
                <!-- Formulario para eliminar al usuario -->
                <form id="deleteForm" method="POST" action="../controllers/Usuarios/eliminar_usuario.php">
                    <input type="hidden" name="idusuario" id="userId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para pasar los datos del usuario al modal -->
<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Botón que activó el modal
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-nombre');

        // Actualizar el modal con los datos del usuario
        document.getElementById('userId').value = userId;
        document.getElementById('userName').textContent = userName;
    });
</script>

</body>
</html>
