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

// 🔍 BUSCADOR
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $idBuscar = $_GET['buscar'];
    $resultado = buscarUsuarioPorId($conexion, $idBuscar);
} else {
    $resultado = obtenerUsuarios($conexion);
}

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
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">

            <h1 class="text-center">Gestionar Usuarios</h1><br>

            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-usuario.php">
                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-person-plus-fill me-2"></i>Añadir Usuario
                    </button>
                </a>
            </div>

            <form method="GET" class="mb-4 d-flex justify-content-center gap-2">
                <input type="number" name="buscar" class="form-control w-25" placeholder="Buscar por ID"
                    value="<?php echo $_GET['buscar'] ?? ''; ?>">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>

                <a href="gestionarUsuarios.php" class="btn btn-secondary">
                    Reset
                </a>
            </form>


            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <?php if (mysqli_num_rows($resultado) == 0): ?>
                        <tr>
                            <td colspan="6">No se encontró ningún usuario</td>
                        </tr>
                    <?php endif; ?>
                    <?php
                    $n = 1;
                    while ($user = mysqli_fetch_assoc($resultado)): ?>
                        <tbody>
                            <tr>
                                <td class="fw-bold">
                                    <?php echo $n++; ?>
                                </td>
                                <td>
                                    <?php echo $user['id_usuario']; ?>
                                </td>
                                <td>
                                    <?php echo $user['nombre'] . " " . $user['apellidos']; ?>
                                </td>
                                <td>
                                    <?php echo $user['email']; ?>
                                </td>
                                <td>
                                    <span
                                        class="badge <?php echo ($user['rol'] == 'admin') ? 'bg-primary' : 'bg-secondary'; ?>">
                                        <?php echo ($user['rol']); ?>
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="editar-usuario.php?id=<?php echo $user['id_usuario']; ?>">
                                            <button class="btn btn-warning btn-sm text-white"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        </a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmarEliminarUsuario(<?php echo $user['id_usuario']; ?>)">
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
    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <!-- Scripts -->
    <script src="efectos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
</body>

</html>