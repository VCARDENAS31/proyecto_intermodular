<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: gestionarUsuarios.php");
    exit();
}

$user = obtenerUsuarioPorId($conexion, $_GET['id']);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 mt-5">
        <div class="row h-100 align-items-center justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="bg-white shadow">
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Usuario</h4>
                    </div>
                    <div class="card-body p-3">
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'pass_corta'): ?>
                            <div class="alert alert-danger">
                                La contraseña debe tener al menos 6 caracteres
                            </div>
                        <?php endif; ?>
                        <form action="actualizar-usuario.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user['id_usuario']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?php echo $user['nombre']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control"
                                    value="<?php echo $user['apellidos']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select name="rol" class="form-select">
                                    <option value="user" <?php echo $user['rol'] == 'user' ? 'selected' : ''; ?>>Usuario
                                        Estándar (user)</option>
                                    <option value="admin" <?php echo $user['rol'] == 'admin' ? 'selected' : ''; ?>>
                                        Administrador (admin)</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="gestionarUsuarios.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
    <script src="efectos.js"></script>
</body>

</html>