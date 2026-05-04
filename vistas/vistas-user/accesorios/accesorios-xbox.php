<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

$categoria = $_GET['categoria'] ?? null;
$precio = $_GET['precio'] ?? null;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Accesorios de Xbox</title>
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

        <section class="barra-filtro p-4 mb-5 shadow-lg">
            <form method="GET" class="row g-3 align-items-end justify-content-center">

                <!-- CATEGORÍA -->
                <div class="col-12 col-md-4">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">Filtrar por Categoría</label>

                    <div class="dropdown">
                        <button
                            class="btn btn-dark w-100 dropdown-toggle text-start d-flex justify-content-between align-items-center border-secondary"
                            type="button" data-bs-toggle="dropdown">

                            <?php echo $categoria ? $categoria : 'Categorías'; ?>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100 shadow-lg">

                            <li>
                                <input type="radio" name="categoria" value="Mandos" <?php if ($categoria == 'Mandos')
                                    echo 'checked'; ?>>
                                Mandos
                            </li>

                            <li>
                                <input type="radio" name="categoria" value="Memorias" <?php if ($categoria == 'Memorias')
                                    echo 'checked'; ?>>
                                Memorias
                            </li>

                            <li>
                                <input type="radio" name="categoria" value="Auriculares" <?php if ($categoria == 'Auriculares')
                                    echo 'checked'; ?>>
                                Auriculares
                            </li>

                            <li>
                                <input type="radio" name="categoria" value="Cables" <?php if ($categoria == 'Cables')
                                    echo 'checked'; ?>>
                                Cables
                            </li>

                            <li>
                                <input type="radio" name="categoria" value="Fundas y estuches" <?php if ($categoria == 'Fundas y estuches')
                                    echo 'checked'; ?>>
                                Fundas y estuches
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- PRECIO -->
                <div class="col-12 col-md-4">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">Presupuesto</label>

                    <div class="dropdown">
                        <button
                            class="btn btn-dark w-100 dropdown-toggle text-start d-flex justify-content-between align-items-center border-secondary"
                            type="button" data-bs-toggle="dropdown">

                            <?php
                            if ($precio == '0-20')
                                echo 'Menos de 20€';
                            elseif ($precio == '20-50')
                                echo '20€ - 50€';
                            elseif ($precio == '50+')
                                echo 'Más de 50€';
                            else
                                echo 'Rango de Precio';
                            ?>

                        </button>

                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100 shadow-lg">

                            <li>
                                <input type="radio" name="precio" value="0-20" <?php if ($precio == '0-20')
                                    echo 'checked'; ?>>
                                Menos de 20€
                            </li>

                            <li>
                                <input type="radio" name="precio" value="20-50" <?php if ($precio == '20-50')
                                    echo 'checked'; ?>>
                                20€ - 50€
                            </li>

                            <li>
                                <input type="radio" name="precio" value="50+" <?php if ($precio == '50+')
                                    echo 'checked'; ?>>
                                Más de 50€
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="col-12 col-md-3 d-flex gap-2">

                    <button type="submit" class="btn btn-info w-100 fw-bold text-uppercase">
                        <i class="bi bi-filter"></i> Aplicar
                    </button>

                    <a href="mostrar-accesorios-xbox.php" class="btn btn-secondary w-100">
                        Reset
                    </a>

                </div>

            </form>
        </section>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">


                <?php
                $productos = obtenerAccesoriosPorPlataformaFiltrados(
                    $conexion,
                    'Xbox', // cambia a PS5 o Switch según página
                    $categoria,
                    $precio
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
                            <?php if ($fila['stock'] > 0): ?>
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                    data-id="<?php echo $fila['id_producto']; ?>">
                                    <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                    Sin stock
                                </button>
                            <?php endif; ?>
                            <a href="producto/<?php echo $fila['slug']; ?>" class="btn btn-secondary btn-sm w-100">
                                <i class="bi bi-eye"></i> VER
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>

    <!-- ================= FOOTER ================= -->
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