<?php

// Incluye archivos necesarios
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';

// Inicia la sesión
session_start();

// Comprueba si el usuario es administrador
if (!esAdmin()) {
    accesoDenegado();
}

// Desactiva automáticamente los cupones caducados
desactivarCuponesCaducados($conexion);

// Obtiene todos los cupones
$resultado = obtenerCupones($conexion);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Base de rutas -->
    <base href="http://viciogames.test">

    <!-- Configuración -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Título y favicon -->
    <title>Viciogames | Gestionar Cupones</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- Fuentes e iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header administrador -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- Contenido principal -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">

        <div class="container">

            <!-- Título -->
            <h1 class="text-center">Gestionar Cupones</h1><br>

            <!-- Botón añadir -->
            <div class="d-flex justify-content-end align-items-center mb-4">

                <a href="anadir-cupon">

                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-gift me-2"></i>Añadir Cupón
                    </button>

                </a>

            </div>

            <!-- Mensajes -->
            <?php if (isset($_GET['res']) && $_GET['res'] == 'ok'): ?>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Cupón creado correctamente
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'error'): ?>

                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Error al crear el cupón
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'cupon_caducado'): ?>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> No puedes activar un cupón con fecha caducada
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['msj'])): ?>

                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Cupón eliminado correctamente
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'edit_ok'): ?>

                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Cupón editado correctamente
                </div>

            <?php endif; ?>

            <!-- Tabla -->
            <div class="table-responsive">

                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">

                    <!-- Cabecera -->
                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descuento</th>
                            <th>Fecha caducidad</th>
                            <th>¿Está activo?</th>
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $n = 1;

                        while ($cupon = mysqli_fetch_assoc($resultado)):
                        ?>

                            <tr>

                                <td class="fw-bold"><?php echo $n++; ?></td>

                                <td><?php echo $cupon['id_cupon']; ?></td>

                                <td><?php echo $cupon['codigo']; ?></td>

                                <td><?php echo $cupon['descuento_porcentaje']; ?></td>

                                <td><?php echo $cupon['fecha_caducidad']; ?></td>

                                <!-- Estado del cupón -->
                                <td>

                                    <?php
                                    $hoy = date('Y-m-d');

                                    if ($cupon['fecha_caducidad'] < $hoy) {

                                        echo '<span class="badge bg-danger">Caducado</span>';

                                    } elseif ($cupon['activo']) {

                                        echo '<span class="badge bg-success">Activo</span>';

                                    } else {

                                        echo '<span class="badge bg-secondary">Inactivo</span>';
                                    }
                                    ?>

                                </td>

                                <!-- Acciones -->
                                <td class="text-nowrap">

                                    <div class="d-flex justify-content-center gap-3">

                                        <!-- Editar -->
                                        <a href="editar-cupon/<?php echo $cupon['id_cupon']; ?>">

                                            <button class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                        </a>

                                        <!-- Eliminar -->
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmarEliminarCupon(<?php echo $cupon['id_cupon']; ?>)">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Funciones CRUD -->
    <script src="js/admin/funciones-crud.js"></script>

    <!-- Modal -->
    <script src="js/utils/modal.js"></script>

    <!-- Sidebar -->
    <script src="js/ui/sidebar.js"></script>

    <!-- Logout -->
    <script src="js/usuario/logout.js"></script>

</body>

</html>