<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

session_start();
// Protección básica (opcional pero recomendable)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: error-404");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Añadir Usuario</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="shadow bg-white mt-5">
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Nuevo Usuario</h4>
                    </div>
                    <div class="p-3 card-body">
                        <form action="insertar-usuario" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña (mínimo 5 caracteres, con mayúscula y símbolo)</label>
                                <input type="password" name="password" class="form-control" placeholder="Contraseña"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select name="rol" class="form-select">
                                    <option value="user">Usuario Estándar (user)</option>
                                    <option value="admin">Administrador (admin)</option>
                                </select>
                            </div>

                            <?php if (isset($_GET['error'])): ?>

                                <?php if ($_GET['error'] == 'pass'): ?>
                                    <div class="alert alert-danger">
                                        La contraseña debe tener mayúscula, símbolo y mínimo 5 caracteres
                                    </div>
                                <?php endif; ?>

                                <?php if ($_GET['error'] == 'email'): ?>
                                    <div class="alert alert-danger">
                                        El email ya está registrado
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>

                            <div class="d-flex justify-content-between">
                                <a href="gestionar-usuarios" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Usuario</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->


    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>