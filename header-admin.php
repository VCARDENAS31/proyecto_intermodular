<!-- ================= NAVBAR ADMIN ================= -->
<nav class="navbar-admin navbar-dark fixed-top d-flex justify-content-between align-items-center p-3">

    <!-- IZQUIERDA -->
    <div class="nav-left d-flex align-items-center gap-2">
        <button class="btn border-0" id="botonMenu" type="button">
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
                <a class="btn-cerrar-sesion" href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </div>

</nav>
<!-- ================= FIN NAVBAR ================= -->


<!-- ================= SIDEBAR ================= -->
<div id="sidebarMenu">

    <!-- Botón cerrar -->
    <button id="cerrarMenu" class="btn-close btn-close-white position-absolute top-0 end-0 m-3">
    </button>

    <!-- Usuario -->
    <div class="user-section">
        <i class="bi bi-person-circle"></i>
        <p class="mt-2 mb-0">BIENVENIDO</p>
        <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>
    </div>

    <!-- Menú -->
    <div class="menu-item">INICIO</div>
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