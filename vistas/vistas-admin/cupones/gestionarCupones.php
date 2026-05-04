<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';

//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

if (!esAdmin()) {
    accesoDenegado();
}

desactivarCuponesCaducados($conexion);

$resultado = obtenerCupones($conexion); // Llamamos a la función
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Gestionar Cupones</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">
            <h1 class="text-center">Gestionar Cupones</h1><br>
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-cupon">
                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-gift me-2"></i>Añadir Cupón
                    </button>
                </a>
            </div>

            <!-- MENSAJES DE ERROR O ÉXITO -->

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

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">
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
                        while ($cupon = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $n++; ?></td>

                                <td><?php echo $cupon['id_cupon']; ?></td>

                                <td><?php echo $cupon['codigo']; ?></td>

                                <td><?php echo $cupon['descuento_porcentaje']; ?></td>

                                <td><?php echo $cupon['fecha_caducidad']; ?></td>

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

                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-3">

                                        <!-- EDITAR -->
                                        <a href="editar-cupon/<?php echo $cupon['id_cupon']; ?>">
                                            <button class="btn btn-warning btn-sm text-white">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>

                                        <!-- ELIMINAR -->
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
            <!-- ================= FIN CONTENIDO ================= -->

        </div>
    </div>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin/funciones-crud.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>