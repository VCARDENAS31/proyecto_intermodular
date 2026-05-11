<?php
// Inicia la sesión para mantener datos del usuario
session_start();

// Envía el código HTTP 404 al navegador
http_response_code(404);

// Incluye la configuración general del proyecto
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Base principal de rutas -->
    <base href="http://viciogames.test">

    <!-- Configuración básica -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Título y favicon -->
    <title>Viciogames | ERROR 404</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- Fuentes e iconos -->

    <!-- Estilos generales -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header principal -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <!-- Contenido del error 404 -->
    <div class="container text-center py-5">

        <h1 class="display-1 fw-bold">404</h1>

        <h2 class="mb-3">Página no encontrada</h2>

        <p class="mb-4">
            La página que buscas no existe o ha sido movida.
        </p>

        <!-- Botón para volver al inicio -->
        <a href="/" class="btn btn-primary">
            Volver al inicio
        </a>

    </div>

    <!-- Footer -->
    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal de confirmación -->
    <script src="js/utils/modal.js"></script>

    <!-- Sidebar lateral -->
    <script src="js/ui/sidebar.js"></script>

    <!-- Submenús -->
    <script src="js/ui/submenu.js"></script>

    <!-- Funciones del carrito -->
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>

    <!-- Logout -->
    <script src="js/usuario/logout.js"></script>

</body>
</html>