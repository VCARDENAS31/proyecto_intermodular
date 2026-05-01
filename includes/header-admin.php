<!-- ================= NAVBAR ADMIN ================= -->
<nav class="navbar-admin navbar-dark fixed-top d-flex justify-content-between align-items-center p-3">

  <!-- IZQUIERDA -->
  <div class="nav-left d-flex align-items-center gap-2">
    <button class="btn border-0" id="botonMenu" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a href="/">
      <div class="logo">
        <img src="assets/imagenes/logo_tienda.png" alt="Logo">
      </div>
    </a>
  </div>

  <!-- DERECHA -->
  <div class="nav-right">
    <div class="perfil-menu">
      <i class="bi bi-person-circle text-white fs-4"></i>

      <div class="dropdown-perfil">
        <a class="btn-cerrar-sesion" href="/logout">Cerrar sesión</a>
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
  <a href="/">
    <div class="menu-item">INICIO
  </a>
</div>
<a href="/gestionar-usuarios">
  <div class="menu-item">GESTIONAR USUARIOS</div>
</a>
<a href="/gestionar-productos">
  <div class="menu-item">GESTIONAR PRODUCTOS</div>
</a>
<a href="/gestionar-cupones">
  <div class="menu-item">GESTIONAR CUPONES</div>
</a>
<a href="/gestionar-pedidos">
  <div class="menu-item">ACTUALIZAR PEDIDOS</div>
</a>

<!-- Logout -->
<a href="/logout" class="btn btn-danger logout-btn btn-cerrar-sesion w-75">
  CERRAR SESIÓN
</a>

</div>

<!-- Overlay -->
<div id="overlaySidebarMenu"></div>
<!-- ================= FIN SIDEBAR ================= -->


<div class="modal fade" id="modalConfirm" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-3 shadow">

      <div class="modal-header">
        <h5 class="modal-title text-black">Confirmación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p id="modalMensaje" class="text-black">¿Seguro?</p>
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

