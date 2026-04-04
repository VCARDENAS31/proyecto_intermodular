<?php
session_start();

// Protección básica (opcional pero recomendable)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<!-- ================= NAVBAR ADMIN ================= -->
<nav class="navbar-admin navbar-dark fixed-top d-flex justify-content-between align-items-center p-3">

    <!-- IZQUIERDA -->
    <div class="nav-left d-flex align-items-center gap-2">
        <button class="navbar-toggler" id="botonMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="logo">
            <img src="assets/imagenes/logo_tienda.png" alt="Logo">
        </div>
    </div>

    <!-- DERECHA -->
    <div class="nav-right">
        <div class="perfil-menu">
            <i class="bi bi-person-circle text-white fs-4"></i>

            <div class="dropdown-perfil">
                <a href="#">
                    <?php echo htmlspecialchars($_SESSION['admin_nombre']); ?>
                </a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>

</nav>
<!-- ================= FIN NAVBAR ================= -->


<!-- ================= SIDEBAR ================= -->
<div id="sidebarMenu">

    <!-- Botón cerrar -->
    <button id="cerrarMenu"
        class="btn-close btn-close-white position-absolute top-0 end-0 m-3">
    </button>

    <!-- Usuario -->
    <div class="user-section">
        <i class="bi bi-person-circle"></i>
        <p class="mt-2 mb-0">BIENVENIDO</p>
        <strong><?php echo htmlspecialchars($_SESSION['admin_nombre']); ?></strong>
    </div>

    <!-- Menú -->
    <div class="menu-item">GESTIONAR USUARIOS</div>
    <div class="menu-item">GESTIONAR PRODUCTOS</div>
    <div class="menu-item">GESTIONAR CUPONES</div>
    <div class="menu-item">ACTUALIZAR PEDIDOS</div>

    <!-- Logout -->
    <a href="logout.php" class="btn btn-danger logout-btn">
        CERRAR SESIÓN
    </a>

</div>

<!-- Overlay -->
<div id="overlaySidebarMenu"></div>
<!-- ================= FIN SIDEBAR ================= -->


<!-- ================= CONTENIDO ================= -->
<div id="content" class="p-4 p-md-5">

    <h3 class="text-center mb-5 fw-bold">SELECCIONA UNA ACCIÓN</h3>

    <div class="container">
        <div class="row g-4 justify-content-center">

            <div class="col-6 col-md-4">
                <a href="gestionarUsuarios.php">
                    <div class="card-action">
                        <i class="bi bi-people"></i>
                        <h6>GESTIONAR USUARIOS</h6>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4">
                <a href="gestionarProductos.php">
                    <div class="card-action">
                        <i class="bi bi-box-seam"></i>
                        <h6>GESTIONAR PRODUCTOS</h6>
                    </div>
                </a>
            </div>

            <div class="col-6 col-md-4">
                <div class="card-action">
                    <i class="bi bi-percent"></i>
                    <h6>GESTIONAR CUPONES</h6>
                </div>
            </div>

            <div class="col-6 col-md-4">
                <div class="card-action">
                    <i class="bi bi-truck"></i>
                    <h6>ACTUALIZAR PEDIDOS</h6>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- ================= FIN CONTENIDO ================= -->


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="efectos.js"></script>

</body>
</html>