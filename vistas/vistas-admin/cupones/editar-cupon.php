<?php

// Inicia la sesión
session_start();

// Incluye configuración y archivos necesarios
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';

// Verifica que el usuario sea administrador
if (!esAdmin()) {
    accesoDenegado();
}

// Obtiene el cupón por ID
$cupon = obtenerCuponPorId($conexion, $_GET['id']);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Base de rutas -->
    <base href="http://viciogames.test">

    <!-- Configuración básica -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Título y favicon -->
    <title>Viciogames | Editar Cupón</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- Fuentes e iconos -->

    <!-- Estilos -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header administrador -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- Contenido principal -->
    <div class="contenido-gestion p-4 flex-grow-1 mt-5">

        <div class="row justify-content-center mt-5">

            <div class="col-12 col-md-8 col-lg-6">

                <!-- Card -->
                <div class="bg-white shadow">

                    <!-- Cabecera -->
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Cupón</h4>
                    </div>

                    <!-- Formulario -->
                    <div class="p-3">

                        <form action="actualizar-cupon" method="POST">

                            <!-- ID oculto -->
                            <input type="hidden" name="id" value="<?php echo $cupon['id_cupon']; ?>">

                            <!-- Código -->
                            <div class="mb-3">
                                <label>Código</label>

                                <input type="text" name="codigo" class="form-control"
                                    value="<?php echo $cupon['codigo']; ?>" required>
                            </div>

                            <!-- Descuento -->
                            <div class="mb-3">
                                <label>Descuento (%)</label>

                                <input type="number" name="descuento" class="form-control"
                                    value="<?php echo $cupon['descuento_porcentaje']; ?>" required>
                            </div>

                            <!-- Fecha -->
                            <div class="mb-3">
                                <label>Fecha caducidad</label>

                                <input type="date" name="fecha" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>"
                                    value="<?php echo $cupon['fecha_caducidad']; ?>">
                            </div>

                            <!-- Estado -->
                            <div class="mb-3">
                                <label>Activo</label>

                                <select name="activo" class="form-select">

                                    <option value="1"
                                        <?php echo $cupon['activo'] ? 'selected' : ''; ?>>
                                        Sí
                                    </option>

                                    <option value="0"
                                        <?php echo !$cupon['activo'] ? 'selected' : ''; ?>>
                                        No
                                    </option>

                                </select>
                            </div>

                            <!-- Botones -->
                            <div class="d-flex justify-content-between">

                                <a href="gestionar-cupones" class="btn btn-secondary">
                                    Cancelar
                                </a>

                                <button class="btn btn-success">
                                    Guardar cambios
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