<?php
include 'conexion-bd.php';
include 'consultas.php';

//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

//Comprobar si el usuario tiene permiso (debe ser admin)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo mandamos al login o mostramos error
    die("Acceso denegado: No tienes permisos para realizar esta acción.");
}
desactivarCuponesCaducados($conexion);

$resultado = obtenerCupones($conexion); // Llamamos a la función
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica -->
    <meta charset="UTF-8">
    <title>Panel de Administración - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<div class="modal fade" id="modalConfirm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow text-black">

            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p id="modalMensaje">¿Seguro?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmar">
                    Confirmar
                </button>
            </div>

        </div>
    </div>
</div>

<body>
    <?php include 'header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">

            <h1 class="text-center">Gestionar Cupones</h1><br>
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-cupon.php">
                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-gift me-2"></i>Añadir Cupón
                    </button>
                </a>
            </div>

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
                                        <a href="editar-cupon.php?id=<?php echo $cupon['id_cupon']; ?>">
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
    <script src="efectos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
</body>

</html>