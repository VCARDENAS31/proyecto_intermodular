<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

$precio = $_GET['precio'] ?? null;
$tieneLector = isset($_GET['tieneLector']) ? $_GET['tieneLector'] : null;
$almacenamiento = $_GET['almacenamiento'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Consolas Xbox</title>
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
                        <img src="assets/imagenes/the_last_of_us_II.png" class="d-block w-100 img-fluid rounded-0"
                            alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/re2_remake.png" class="d-block w-100 img-fluid rounded-0" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/gow_ragnarok.png" class="d-block w-100  rounded-0" alt="">
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
                        <a class="menu-item" href="consolas/ps5">
                            <i class="bi bi-controller"></i> PS5
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-0 border-lg-0">
                        <a class="menu-item" href="consolas/xbox">
                            <i class="bi bi-xbox"></i> XBOX SERIES X/S
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-0 border-lg-0">
                        <a class="menu-item " href="/consolas/switch">
                            <i class="bi bi-nintendo-switch"></i> NINTENDO SWITCH
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <section class="barra-filtro p-4 mb-5 shadow-lg">
            <form method="GET" class="row g-3 align-items-end justify-content-center">

                <!-- 🔽 PRECIO -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Filtrar por Precio
                    </label>

                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php
                            if ($precio == '0-400')
                                echo 'Menos de 400€';
                            elseif ($precio == '400-600')
                                echo '400€ - 600€';
                            elseif ($precio == '+600')
                                echo 'Más de 600€';
                            else
                                echo 'Precio';
                            ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100">
                            <li><input type="radio" name="precio" value="0-400" <?php if ($precio == '0-400')
                                echo 'checked'; ?>> Menos de 400€</li>
                            <li><input type="radio" name="precio" value="400-600" <?php if ($precio == '400-600')
                                echo 'checked'; ?>> 400€ - 600€</li>
                            <li><input type="radio" name="precio" value="+600" <?php if ($precio == '+600')
                                echo 'checked'; ?>> Más de 600€</li>
                        </ul>
                    </div>
                </div>

                <!-- 🔽 LECTOR -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Tipo de Consola
                    </label>

                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php
                            if ($tieneLector === '1')
                                echo 'Lector';
                            elseif ($tieneLector === '0')
                                echo 'Digital';
                            else
                                echo 'Tipo';
                            ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100">
                            <li><input type="radio" name="tieneLector" value="1" <?php if ($tieneLector === '1')
                                echo 'checked'; ?>> Con lector</li>
                            <li><input type="radio" name="tieneLector" value="0" <?php if ($tieneLector === '0')
                                echo 'checked'; ?>> Digital</li>
                        </ul>
                    </div>
                </div>

                <!-- 🔽 ALMACENAMIENTO -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Almacenamiento
                    </label>

                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php echo $almacenamiento ?: 'Almacenamiento'; ?>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100">
                            <li><input type="radio" name="almacenamiento" value="512GB" <?php if ($almacenamiento == '512GB')
                                echo 'checked'; ?>> 512GB</li>
                            <li><input type="radio" name="almacenamiento" value="1TB" <?php if ($almacenamiento == '1TB')
                                echo 'checked'; ?>> 1TB</li>
                        </ul>
                    </div>
                </div>

                <!-- 🔥 BOTONES -->
                <div class="col-md-3 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-info w-100">Aplicar</button>
                    <a href="mostrar-consolas-xbox.php" class="btn btn-secondary w-100">Reset</a>
                </div>

            </form>
        </section>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">


                <?php
                $productos = obtenerConsolasFiltradas(
                    $conexion,
                    'Xbox', // o Xbox
                    $precio,
                    $tieneLector,
                    $almacenamiento
                );
                while ($fila = mysqli_fetch_assoc($productos)) {
                    ?>
                    <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                        <div>
                            <img class="card-img-top" src="assets/imagenes/<?php echo $fila['img_url']; ?>">
                        </div>
                        <div class="text-center">
                            <p class="fw-bold mb-0 mt-3"><?php echo $fila['nombre']; ?></p>
                            <p class=" mb-3"><b>Precio:</b> <?php echo $fila['precio']; ?>€</p>
                        </div>
                        <div class="mt-auto">
                            <button class="btn btn-primary btn-sm w-100 mb-1">
                                <i class="bi bi-cart"></i> Añadir a la cesta
                            </button>
                            <button class="btn btn-outline-secondary btn-sm w-100">
                                <i class="bi bi-eye"></i> VER
                            </button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/ui/submenu.js"></script>
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>