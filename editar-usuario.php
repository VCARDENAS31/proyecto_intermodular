<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: gestionarUsuarios.php");
    exit();
}

$user = obtenerUsuarioPorId($conexion, $_GET['id']);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- ================= NAVBAR ADMIN ================= -->
    <nav class="navbar-admin navbar-dark fixed-top d-flex justify-content-between p-3">

        <!-- Botón menú lateral -->
        <button class="btn btn-outline-light" id="botonMenu">
            <i class="bi bi-list"></i>
        </button>

        <!-- Logo -->
        <div class="logo">
            <img class="img-fluid" src="assets/imagenes/logo_tienda.png" alt="Viciogames">
        </div>

        <!-- Menú usuario -->
        <div class="dropdown">
            <a href="#" class="text-white" id="userMenu" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-4"></i>
            </a>

            <!-- Dropdown cerrar sesión -->
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item btn-cerrar-sesion" href="#">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ================= FIN NAVBAR ================= -->


    <div class="d-flex">

        <!-- ================= SIDEBAR ================= -->
        <div id="sidebarMovil" class="bg-dark">

            <!-- Botón cerrar sidebar -->
            <button id="cerrarSidebar" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                aria-label="Cerrar">
            </button>

            <!-- Información del usuario -->
            <div class="user-section">
                <i class="bi bi-person-circle"></i>
                <p class="mt-2 mb-0">BIENVENIDO</p>
                <strong>NOMBRE</strong>
            </div>

            <!-- Opciones del menú -->
            <div class="menu-item">GESTIONAR USUARIOS</div>
            <div class="menu-item">GESTIONAR PRODUCTOS</div>
            <div class="menu-item">GESTIONAR CUPONES</div>
            <div class="menu-item">ACTUALIZAR PEDIDOS</div>

            <!-- Botón cerrar sesión -->
            <button class="btn btn-danger logout-btn btn-cerrar-sesion">
                CERRAR SESIÓN
            </button>
        </div>
    </div>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 mt-5">
        <div class="row h-100 align-items-center justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Editar Usuario</h4>
                    </div>
                    <div class="card-body">
                        <form action="actualizar-usuario.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $user['id_usuario']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?php echo $user['nombre']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control"
                                    value="<?php echo $user['apellidos']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="<?php echo $user['email']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select name="rol" class="form-select">
                                    <option value="user" <?php echo $user['rol'] == 'user' ? 'selected' : ''; ?>>Usuario
                                        Estándar (user)</option>
                                    <option value="admin" <?php echo $user['rol'] == 'admin' ? 'selected' : ''; ?>>
                                        Administrador (admin)</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="gestionarUsuarios.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
    <script src="efectos.js"></script>
</body>

</html>