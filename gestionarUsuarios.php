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

$resultado = obtenerUsuarios($conexion); // Llamamos a la función
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