<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: home.php");
    exit();
}

// Conexión a la base de datos
require_once '../config/database.php';

// Consultar artículos
$sql = "SELECT idarticulo, idcategoria, codigo, nombre, stock, precio_venta FROM articulo";
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Mi Tienda</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="crud_categoria.php">CRUD Categorías</a></li>
                <li class="nav-item"><a class="nav-link active" href="crud_articulos.php">CRUD Artículos</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link btn btn-danger ms-2" href="auth/logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h2>Gestión de Artículos</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">Agregar Artículo</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Categoría</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows == 0): ?>
                <tr><td colspan="7" class="text-center"><h5>No hay artículos disponibles</h5></td></tr>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['idarticulo']); ?></td>
                        <td><?= htmlspecialchars($row['idcategoria']); ?></td>
                        <td><?= htmlspecialchars($row['codigo']); ?></td>
                        <td><?= htmlspecialchars($row['nombre']); ?></td>
                        <td><?= htmlspecialchars($row['stock']); ?></td>
                        <td><?= htmlspecialchars($row['precio_venta']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="<?= htmlspecialchars($row['idarticulo']); ?>"
                                    data-idcategoria="<?= htmlspecialchars($row['idcategoria']); ?>"
                                    data-codigo="<?= htmlspecialchars($row['codigo']); ?>"
                                    data-nombre="<?= htmlspecialchars($row['nombre']); ?>"
                                    data-stock="<?= htmlspecialchars($row['stock']); ?>"
                                    data-precio="<?= htmlspecialchars($row['precio_venta']); ?>">
                                Editar
                            </button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                    data-id="<?= htmlspecialchars($row['idarticulo']); ?>"
                                    data-nombre="<?= htmlspecialchars($row['nombre']); ?>">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal para agregar artículo -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="../controllers/Articulos/agregar_articulo.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label">ID Categoría</label><input type="number" class="form-control" name="idcategoria" required></div>
                    <div class="mb-3"><label class="form-label">Código</label><input type="text" class="form-control" name="codigo" required></div>
                    <div class="mb-3"><label class="form-label">Nombre</label><input type="text" class="form-control" name="nombre" required></div>
                    <div class="mb-3"><label class="form-label">Stock</label><input type="number" class="form-control" name="stock" required></div>
                    <div class="mb-3"><label class="form-label">Precio</label><input type="number" step="0.01" class="form-control" name="precio_venta" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para editar artículo -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="../controllers/Articulos/editar_articulo.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="idarticulo" id="editId">
                    <div class="mb-3"><label class="form-label">ID Categoría</label><input type="number" class="form-control" id="editIdCategoria" name="idcategoria" required></div>
                    <div class="mb-3"><label class="form-label">Código</label><input type="text" class="form-control" id="editCodigo" name="codigo" required></div>
                    <div class="mb-3"><label class="form-label">Nombre</label><input type="text" class="form-control" id="editNombre" name="nombre" required></div>
                    <div class="mb-3"><label class="form-label">Stock</label><input type="number" class="form-control" id="editStock" name="stock" required></div>
                    <div class="mb-3"><label class="form-label">Precio</label><input type="number" step="0.01" class="form-control" id="editPrecio" name="precio_venta" required></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para eliminar artículo -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="../controllers/Articulos/eliminar_articulo.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Eliminar Artículo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar este artículo?
                    <br><strong id="deleteArticuloNombre"></strong>
                    <input type="hidden" name="idarticulo" id="deleteId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('editId').value = button.getAttribute('data-id');
    document.getElementById('editIdCategoria').value = button.getAttribute('data-idcategoria');
    document.getElementById('editCodigo').value = button.getAttribute('data-codigo');
    document.getElementById('editNombre').value = button.getAttribute('data-nombre');
    document.getElementById('editStock').value = button.getAttribute('data-stock');
    document.getElementById('editPrecio').value = button.getAttribute('data-precio');
});

const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    document.getElementById('deleteId').value = button.getAttribute('data-id');
    document.getElementById('deleteArticuloNombre').textContent = button.getAttribute('data-nombre');
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
