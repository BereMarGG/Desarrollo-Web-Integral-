<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Registro</h2>
            <form action="register_process.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="rPassword" class="form-label">Repite la Contraseña</label>
                    <input type="password" id="password2" name="password2" class="form-control"required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Registrarme</button>
            </form>
            <div class="text-center mt-3">
                <span>¿Ya tienes una cuenta?</span>
                <a href="login.php" class="text-decoration-none">Inicia Sesión aquí</a>
            </div>
        </div>
    </div>
</body>
</html>