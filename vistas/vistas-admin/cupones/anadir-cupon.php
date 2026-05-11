<?php

// Incluye la configuración principal del proyecto
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Inicia la sesión para comprobar el usuario logueado
session_start();

// Verifica que el usuario sea administrador
if (!esAdmin()) {
    accesoDenegado();
}

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
    <title>Viciogames | Añadir Cupón</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- Fuente e iconos -->

    <!-- Estilos -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header administrador -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- Contenedor principal -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <!-- Card formulario -->
                <div class="bg-white shadow mt-5">

                    <!-- Cabecera -->
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Añadir Cupón</h4>
                    </div>

                    <!-- Formulario -->
                    <div class="p-3">

                        <form action="insertar-cupon" method="POST">

                            <!-- Código del cupón -->
                            <div class="mb-3">
                                <label>Código</label>
                                <input type="text" name="codigo" class="form-control" required>
                            </div>

                            <!-- Descuento -->
                            <div class="mb-3">
                                <label>Descuento (%)</label>
                                <input type="number" name="descuento" class="form-control" required>
                            </div>

                            <!-- Fecha de caducidad -->
                            <div class="mb-3">
                                <label>Fecha caducidad</label>

                                <input type="date" name="fecha" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <!-- Estado activo -->
                            <div class="mb-3">
                                <label>Activo</label>

                                <select name="activo" class="form-select">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <!-- Mensaje de error si el código ya existe -->
                            <?php if (isset($_GET['error']) && $_GET['error'] == 'codigo_duplicado'): ?>

                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i> El código de cupón ya existe
                                </div>

                            <?php endif; ?>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between">

                                <a href="gestionar-cupones" class="btn btn-secondary">
                                    Volver
                                </a>

                                <button class="btn btn-success">
                                    Guardar
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Modal -->
    <script src="js/utils/modal.js"></script>

    <!-- Sidebar -->
    <script src="js/ui/sidebar.js"></script>

    <!-- Logout -->
    <script src="js/usuario/logout.js"></script>

</body>

</html>