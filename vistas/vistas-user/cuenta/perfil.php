<?php
/* ============================================================
   PERFIL.PHP
   Muestra y permite editar los datos del perfil del usuario.
   ============================================================ */
/* ------------------------------------------------------------
   INICIALIZACIÓN DE SESIÓN
   ------------------------------------------------------------ */
session_start();
/* ------------------------------------------------------------
   CARGA DE CONFIGURACIÓN Y DAOs
   ------------------------------------------------------------ */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';
/* ------------------------------------------------------------
   CONTROL DE ACCESO
   ------------------------------------------------------------ */
if (!usuarioLogueado()) {
    redirigir('login');
}
/* ------------------------------------------------------------
   OBTENCIÓN DE DATOS DEL USUARIO
   Se consulta la información actual para rellenar el formulario.
   ------------------------------------------------------------ */
$usuario_id = $_SESSION['usuario_id'] ?? null;
$usuario = obtenerUsuarioPorId($conexion, $usuario_id);
/* ------------------------------------------------------------
   MENSAJE DE CONFIRMACIÓN
   Si se redirigió con ?ok=1 tras actualizar, se muestra alerta.
   ------------------------------------------------------------ */
$mensaje = $_GET['ok'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ========== META Y BASE ========== -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Ver Perfil</title>
    <!-- ========== FAVICON ========== -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <!-- ========== FUENTES Y ESTILOS ========== -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light">
    <!-- ========== CABECERA DE USUARIO ========== -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- ========== TÍTULO ========== -->
                <h1 class="h3 mb-4 text-center">Mi Perfil</h1>
                <!-- ========== FORMULARIO DE EDICIÓN ========== -->
                <form action="actualizar-perfil" method="POST" class=" shadow-sm p-4">
                    <!-- Alerta de éxito -->
                    <?php if ($mensaje): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Perfil actualizado correctamente
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!-- Campo nombre -->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>
                    <!-- Campo apellidos -->
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
                    </div>
                    <!-- Campo email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    <!-- Botones -->
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
    <!-- ========== SCRIPTS ========== -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/utils/modal.js"></script>
    <script src="/js/ui/sidebar.js"></script>
    <script src="/js/ui/submenu.js"></script>
    <script src="/js/carrito/carrito-ui.js"></script>
    <script src="/js/carrito/carrito-api.js"></script>
    <script src="/js/usuario/logout.js"></script>
</body>

</html>