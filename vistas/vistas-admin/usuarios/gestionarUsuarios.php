<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';


//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

// Protección básica (opcional pero recomendable)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: error-404");
    exit();
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
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Gestionar Usuarios</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">

            <h1 class="text-center">Gestionar Usuarios</h1><br>

            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-usuario">
                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-person-plus-fill me-2"></i>Añadir Usuario
                    </button>
                </a>
            </div>

            <form method="GET" class="mb-4 d-flex justify-content-center gap-2">
                <input type="number" name="buscar" class="form-control w-25" placeholder="ID Usuario"
                    value="<?php echo $_GET['buscar'] ?? ''; ?>">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>

                <a href="gestionar-usuarios" class="btn btn-secondary">
                    Reset
                </a>
            </form>

            <?php if (isset($_GET['msj']) && $_GET['msj'] === 'eliminado'): ?>
                <div class="alert alert-success"> <i class="bi bi-check-circle"></i> Usuario eliminado correctamente</div>
            <?php endif; ?>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Usuario creado correctamente
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'edit_ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Usuario editado correctamente
                </div>
            <?php endif; ?>

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
                                        <a href="editar-usuario/<?php echo $user['id_usuario']; ?>">
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

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin/funciones-crud.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>