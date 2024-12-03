<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Conexión a la base de datos
require_once '../config/database.php';

// Consultar artículos
$sql = "SELECT idcategoria, nombre, descripcion, estado FROM categoria WHERE estado = 1";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD CATEGORIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Gestión de Usuarios</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Categoria</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre categoria</th>
                <th>Descripcion</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows == 0): ?>
                <!-- Mensaje si no hay usuarios -->
                <tr>
                    <td colspan="9" class="text-center">
                        <h5>No hay categorias disponibles</h5>
                    </td>
                </tr>
            <?php else: ?>
                <!-- Iterar usuarios si hay filas -->
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['idcategoria']); ?></td>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['descripcion']); ?></td>
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
                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="<?= htmlspecialchars($row['idcategoria']); ?>"
                            data-nombre="<?= htmlspecialchars($row['nombre']); ?>"
                            data-desc="<?= htmlspecialchars($row['descripcion']); ?>"
>
                            Editar
                        </a>

                           
                            <!-- Botón para activar el modal de eliminación -->
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                    data-id="<?= htmlspecialchars($row['idcategoria']); ?>" data-nombre="<?= htmlspecialchars($row['nombre']); ?>">
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
                ¿Estás seguro de que deseas eliminar este categoria?
                <br><br>
                <strong id="userName"></strong>
            </div>
            <div class="modal-footer">
                <!-- Formulario para eliminar al usuario -->
                <form id="deleteForm" method="POST" action="../controllers/Categorias/eliminar_categorias.php">
                    <input type="hidden" name="idcategoria" id="cateId">
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
        const cateId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-nombre');

        // Actualizar el modal con los datos del usuario
        document.getElementById('cateId').value = cateId;
        document.getElementById('userName').textContent = userName;
    });
</script>

<!-- Modal agregar usuario -->

<!-- Modal de agregar usuario -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Agregar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="POST" action="../controllers/Categorias/agregar_categoria.php">
                    <div class="mb-3">
                        <label for="nombre_categoria" class="form-label">Nombre categoria</label>
                        <input type="text" class="form-control" id="nombre_categoria" name="nombre_categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="desc_categoria" class="form-label">Descripcion categoria</label>
                        <input type="text" class="form-control" id="desc_categoria" name="desc_categoria" required>
                    </div>



                    <button type="submit" class="btn btn-primary">Agregar Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de editar usuario -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST" action="../controllers/Categorias/editar_categoria.php">
                    <input type="hidden" id="editId" name="idcategoria">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTipoDocumento" class="form-label">Tipo de Documento</label>
                        <input type="text" class="form-control" id="editDescripcion" name="descripcion" required>
                    </div>
                         <button type="submit" class="btn btn-primary">Actualizar Categoria</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const catId = button.getAttribute('data-id');
            const catName = button.getAttribute('data-nombre');
            const catdesc = button.getAttribute('data-desc');
          

            // Actualizar el modal con los datos del usuario
            document.getElementById('editId').value = catId;
            document.getElementById('editNombre').value = catName;
            document.getElementById('editDescripcion').value = catdesc;
           
        });

    </script>

</body>
</html>