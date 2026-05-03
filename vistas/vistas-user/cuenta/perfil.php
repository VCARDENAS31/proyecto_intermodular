<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';



$usuario_id = $_SESSION['usuario_id'] ?? null;
$usuario = obtenerUsuarioPorId($conexion, $usuario_id);

$mensaje = $_GET['ok'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Ver Perfil</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">

    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <h1 class="h3 mb-4 text-center">Mi Perfil</h1>

                <form action="actualizar-perfil" method="POST" class=" shadow-sm p-4">

                    <?php if ($mensaje): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Perfil actualizado correctamente
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>


                    <div class="d-grid">
                        <a href="/" class="btn btn-primary mt-2">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-secondary mt-2">
                            Guardar cambios
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/utils/modal.js"></script>
    <script src="/js/ui/sidebar.js"></script>
    <script src="/js/ui/submenu.js"></script>
    <script src="/js/carrito/carrito-ui.js"></script>
    <script src="/js/carrito/carrito-api.js"></script>
    <script src="/js/usuario/logout.js"></script>
</body>

</html>