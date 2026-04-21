<header>
    <!-- NAVBAR PRINCIPAL -->
    <nav class="navbar-principal navbar-dark">

        <!-- IZQUIERDA -->
        <div class="nav-left">
            <button class="navbar-toggler d-lg-none" type="button" id="botonMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a href="index-user.php">
                <div class="logo">
                    <img src="assets/imagenes/logo_tienda.png" alt="Logo">
                </div>
            </a>
        </div>

        <!-- BUSCADOR (SOLO ESCRITORIO) -->
        <div class="nav-center">
            <form class="buscador position-relative" action="buscar.php" method="GET">
                <input type="search" name="q" class="form-control rounded-pill ps-4" placeholder="Buscar videojuegos..."
                    required>
            </form>
        </div>

        <!-- DERECHA -->
        <div class="nav-right">

            <div class="perfil-menu">
                <i class="bi bi-person-circle"></i>

                <div class="dropdown-perfil">
                    <?php if (isset($_SESSION['usuario_nombre']) && $_SESSION['usuario_nombre'] !== ''): ?>
                        <a href="mi-perfil.php">Mi perfil</a>
                        <a href="historial.php">Historial de pedidos</a>
                        <a class="btn-cerrar-sesion" href="logout.php">Cerrar sesión</a>
                    <?php else: ?>
                        <a href="login.php">Iniciar sesión</a>
                        <a href="registro.php">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>

            <i class="bi bi-cart"></i>
        </div>

    </nav>

    <!-- BUSCADOR SOLO MOVIL -->
    <div class="buscador-movil-wrapper">
        <form action="buscar.php" method="GET" class="buscador-box">
            <input type="text" name="q" placeholder="¿Qué buscas?">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>


    <!-- SIDEBAR MOVIL -->
    <div id="sidebarMenu">
        <button id="cerrarMenu" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
            aria-label="Cerrar"></button>
        <div class="user-section">
            <i class="bi bi-person-circle"></i>
            <p>Usuario</p>
        </div>
        <div class="menu-item toggle-submenu">
            <i class="bi bi-controller"></i>Videojuegos <i class="bi bi-chevron-down"></i>
        </div>
        <div class="submenu">
            <div><i class="bi bi-xbox"> </i> Videojuegos Xbox</div>
            <div><i class="bi bi-playstation"> </i> Videojuegos PS5</div>
            <div><i class="bi bi-nintendo-switch"> </i> Videojuegos Nintendo Switch</div>
        </div>

        <div class="menu-item toggle-submenu">
            <i class="bi bi-box-fill"></i> Consolas <i class="bi bi-chevron-down"></i>
        </div>
        <div class="submenu">
            <div><i class="bi bi-xbox"> </i> Consolas Xbox</div>
            <div><i class="bi bi-playstation"> </i> Consolas PS5</div>
            <div><i class="bi bi-nintendo-switch"> </i> Consolas Nintendo Switch</div>
        </div>

        <div class="menu-item toggle-submenu">
            <i class="bi bi-headset"></i> Accesorios <i class="bi bi-chevron-down"></i>
        </div>
        <div class="submenu">
            <div><i class="bi bi-xbox"> </i> Accesorios Xbox</div>
            <div><i class="bi bi-playstation"> </i> Accesorios PS5</div>
            <div><i class="bi bi-nintendo-switch"> </i> Accesorios Nintendo Switch</div>
        </div>
        <div class="menu-item">
            <i class="bi bi-clock"></i> Próximamente
        </div>
        <!-- Botón cerrar sesión -->
        <button class="btn btn-danger logout-btn btn-cerrar-sesion">
            CERRAR SESIÓN
        </button>
    </div>

    <!-- OVERLAY para cerrar sidebar -->
    <div id="overlaySidebarMenu"></div>


    <!-- SIDEBAR CARRITO -->
    <div id="sidebarCarrito">

        <!-- HEADER -->
        <div class="carrito-header">
            <h5>Tu carrito</h5>
            <button id="cerrarCarrito" class="btn-close btn-close-white"></button>
        </div>

        <!-- PRODUCTOS -->
        <div class="carrito-body">

            <?php
            $total = 0;

            if (!empty($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $id => $producto) {

                    $subtotal = round($producto['precio'] * $producto['cantidad'], 2);
                    $total += $subtotal;

                    ?>
                    <div class="carrito-item">
                        <img src="assets/imagenes/<?php echo $producto['img']; ?>">
                        <div class="info">
                            <p>
                                <?php echo $producto['nombre']; ?> - <?php echo $producto['plataforma']; ?>
                            </p>
                            <span>
                                <?php echo $producto['precio']; ?>€ x
                                <?php echo $producto['cantidad']; ?>
                            </span>
                        </div>

                        <!-- eliminar -->
                        <a href="#" class="btn-eliminar" data-id="<?php echo $id; ?>">
                            <i class="bi bi-trash eliminar"></i>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Carrito vacío</p>";
            }
            ?>

        </div>

        <!-- FOOTER -->
        <!-- FOOTER del sidebarCarrito -->
        <div class="carrito-footer">
            <div class="total">
                <strong><?php echo $total; ?>€</strong>
            </div>

            <?php $estaVacio = empty($_SESSION['carrito']); ?>

            <a href="pasarela.php" id="btnPagar"
                class="btn btn-primary w-100 <?php echo $estaVacio ? 'disabled' : ''; ?>" <?php echo $estaVacio ?>>
                Ir a pagar
            </a>
        </div>


    </div>

    <!-- OVERLAY -->
    <div id="overlayCarrito"></div>


    <!-- NAVBAR SECUNDARIO -->
    <div class="navbar-secundario d-none d-md-block">
        <div class="container">
            <ul class="nav w-100 justify-content-between text-center">

                <!-- VIDEOJUEGOS -->
                <li class="nav-item dropdown-mega">
                    <a class="nav-link text-white p-3 menu-item d-flex justify-content-center align-items-center gap-2"
                        href="#">
                        <i class="bi bi-controller"></i> VIDEOJUEGOS
                        <i class="bi bi-chevron-down flecha"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-content">
                            <div class="mega-column">
                                <a href="#"><i class="bi bi-xbox"></i> Videojuegos Xbox</a>
                                <a href="#"><i class="bi bi-playstation"></i> Videojuegos PS5</a>
                                <a href="#"><i class="bi bi-nintendo-switch"></i> Videojuegos Nintendo Switch</a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- CONSOLAS -->
                <li class="nav-item dropdown-mega">
                    <a class="nav-link text-white p-3 menu-item d-flex justify-content-center align-items-center gap-2"
                        href="#">
                        <i class="bi bi-box-fill"></i> CONSOLAS
                        <i class="bi bi-chevron-down flecha"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-content">
                            <div class="mega-column">
                                <a href="#"><i class="bi bi-xbox"></i> Consolas Xbox</a>
                                <a href="#"><i class="bi bi-playstation"></i> Consolas PS5</a>
                                <a href="#"><i class="bi bi-nintendo-switch"></i> Consolas Nintendo Switch</a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- ACCESORIOS -->
                <li class="nav-item dropdown-mega">
                    <a class="nav-link text-white p-3 menu-item d-flex justify-content-center align-items-center gap-2"
                        href="#">
                        <i class="bi bi-headset"></i> ACCESORIOS
                        <i class="bi bi-chevron-down flecha"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-content">
                            <div class="mega-column">
                                <a href="#"><i class="bi bi-xbox"></i> Accesorios Xbox</a>
                                <a href="#"><i class="bi bi-playstation"></i> Accesorios PS5</a>
                                <a href="#"><i class="bi bi-nintendo-switch"></i> Accesorios Nintendo Switch</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown-mega">
                    <a class="nav-link text-white p-3 menu-item d-flex justify-content-center align-items-center gap-2"
                        href="#">
                        <i class="bi bi-clock-history"></i> PRÓXIMAMENTE
                    </a>
                </li>
            </ul>
        </div>
    </div>

</header>

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