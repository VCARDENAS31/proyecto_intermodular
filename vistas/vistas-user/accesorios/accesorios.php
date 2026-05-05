<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Accesorios</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <main>
        <!-- CAROUSEL RESPONSIVO -->
        <div class="container-fluid p-0">
            <div id="carrusel-imagenes" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicadores -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="0"
                        class="active"></button>
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="2"></button>
                </div>

                <!-- Slides -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/imagenes/banner1-accesorios-ps5.webp" class="d-block w-100"
                            alt="Banner accesorios PS5">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/banner1-accesorios-xbox.webp" class="d-block w-100"
                            alt="Banner accesorios XBOX Series X/S">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/banner1-accesorios-nintendo.webp" class="d-block w-100"
                            alt="Banner accesorios Nintendo Switch">
                    </div>
                </div>

                <!-- Controles -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carrusel-imagenes"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carrusel-imagenes"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </div>

        <!-- ===== SECCIONES DE PRODUCTOS ===== -->

        <div class="navbar-secundario">
            <div class="container p-0">
                <ul class="nav flex-column flex-lg-row text-center justify-content-lg-between">
                    <li class="nav-item border-bottom border-secondary border-opacity-0 border-lg-0">
                        <a class="menu-item" href="accesorios/ps5">
                            <i class="bi bi-controller"></i> PS5
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-0 border-lg-0">
                        <a class="menu-item" href="accesorios/xbox">
                            <i class="bi bi-xbox"></i> XBOX SERIES X/S
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-0 border-lg-0">
                        <a class="menu-item " href="accesorios/switch">
                            <i class="bi bi-nintendo-switch"></i> NINTENDO SWITCH
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Accesorios PS5 -->
        <section id="accesorios-ps5">
            <div class="container p-4 mt-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">ACCESORIOS PS5</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">ACCESORIOS PS5</h2>
                    </div>

                    <a href="accesorios/ps5" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>

                </div>
                <hr>

                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // Llamamos a la función del archivo externo
                        $ultimos10AccesoriosPs5 = obtenerUltimos10AccesoriosPorPlataforma($conexion, 'PS5');

                        // Supongamos que $ultimos10AccesoriosPs5 es el resultado de tu consulta SQL
                        foreach ($ultimos10AccesoriosPs5 as $producto) {
                            // Convertimos la palabra de la plataforma a minúsculas para usarla como clase CSS
                            $clasePlataforma = strtolower($producto['plataforma']);
                            ?>

                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $producto['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $producto['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($producto['stock'] > 0): ?>

                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $producto['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>

                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>

                                    <?php endif; ?>
                                    <a href="producto/<?php echo $producto['slug']; ?>"
                                        class="btn btn-secondary btn-sm w-100">
                                        <i class="bi bi-eye"></i> VER
                                    </a>
                                </div>
                            </div>

                        <?php }
                        ?>
                    </div>
                    <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)"><i
                            class="bi bi-chevron-right"></i></button>
                </div>
            </div>
        </section>


        <!-- Videojuegos XBOX SERIES X/S -->
        <section id="accesorios-xbox">
            <div class="container p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">ACCESORIOS XBOX SERIES X/S</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">ACCESORIOS XBOX SERIES X/S</h2>
                    </div>

                    <a href="accesorios/xbox" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>

                </div>
                <hr>

                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // Llamamos a la función del archivo externo
                        $ultimos10AccesoriosXbox = obtenerUltimos10AccesoriosPorPlataforma($conexion, 'Xbox');

                        // Supongamos que $ultimos10AccesoriosXbox es el resultado de tu consulta SQL
                        foreach ($ultimos10AccesoriosXbox as $producto) {
                            // Convertimos la palabra de la plataforma a minúsculas para usarla como clase CSS
                            $clasePlataforma = strtolower($producto['plataforma']);
                            ?>

                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $producto['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $producto['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($producto['stock'] > 0): ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $producto['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>
                                    <a href="producto/<?php echo $producto['slug']; ?>"
                                        class="btn btn-secondary btn-sm w-100">
                                        <i class="bi bi-eye"></i> VER
                                    </a>
                                </div>
                            </div>

                        <?php }
                        ?>
                    </div>
                    <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)"><i
                            class="bi bi-chevron-right"></i></button>
                </div>
            </div>
        </section>

        <!-- VIDEOJUEGOS NINTENDO SWITCH -->
        <section id="accesorios-nintendo">
            <div class="container p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">ACCESORIOS NINTENDO SWITCH</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">ACCESORIOS NINTENDO SWITCH</h2>
                    </div>

                    <a href="accesorios/switch" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>

                </div>
                <hr>

                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // Llamamos a la función del archivo externo
                        $ultimos10AccesoriosSwitch = obtenerUltimos10AccesoriosPorPlataforma($conexion, 'Switch');

                        // Supongamos que $ultimos10AccesoriosSwitch es el resultado de tu consulta SQL
                        foreach ($ultimos10AccesoriosSwitch as $producto) {
                            // Convertimos la palabra de la plataforma a minúsculas para usarla como clase CSS
                            $clasePlataforma = strtolower($producto['plataforma']);
                            ?>

                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $producto['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $producto['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($producto['stock'] > 0): ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $producto['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>
                                    <a href="producto/<?php echo $producto['slug']; ?>"
                                        class="btn btn-secondary btn-sm w-100">
                                        <i class="bi bi-eye"></i> VER
                                    </a>
                                </div>
                            </div>

                        <?php }
                        ?>
                    </div>
                    <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)"><i
                            class="bi bi-chevron-right"></i></button>
                </div>
            </div>
        </section>
    </main>

    <!-- ================= FOOTER ================= -->
    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/ui/submenu.js"></script>
    <script src="js/ui/slider.js"></script>
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>