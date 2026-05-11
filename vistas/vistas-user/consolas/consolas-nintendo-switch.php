<?php
// ==========================================
// CONSOLAS NINTENDO SWITCH
// ==========================================
// ====== INICIO DE SESIÓN Y CONFIGURACIÓN ======
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';
// ====== OBTENCIÓN DE PARÁMETROS DE FILTRO ======
// Filtros específicos para consolas: precio, lector de discos, almacenamiento
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
    <title>Viciogames | Consolas Nintendo Switch</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ====== HEADER ====== -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>
    <main>
        <!-- ====== CAROUSEL / BANNER ====== -->
        <div class="container-fluid p-0">
            <div id="carrusel-imagenes" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicadores del carrusel -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="0"
                        class="active"></button>
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="1"></button>
                </div>
                <!-- Slides del carrusel -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/imagenes/banner1-consolas-nintendo.webp" class="d-block w-100"
                            alt="Banner 1 consolas Nintendo Switch">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/banner2-consolas-nintendo.webp" class="d-block w-100"
                            alt="Banner 2 consolas Nintendo Switch">
                    </div>
                </div>
                <!-- Controles de navegación del carrusel -->
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
        <!-- ====== NAVBAR SECUNDARIO (NAVEGACIÓN POR PLATAFORMA) ====== -->
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
                        <a class="menu-item " href="consolas/switch">
                            <i class="bi bi-nintendo-switch"></i> NINTENDO SWITCH
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ====== SECCIÓN DE FILTROS (ESPECÍFICOS PARA CONSOLAS) ====== -->
        <section class="barra-filtro p-4 mb-5 shadow-lg">
            <form method="GET" class="row g-3 align-items-end justify-content-center">
                <!-- FILTRO POR PRECIO -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Filtrar por Precio
                    </label>
                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php
                            // Muestra el rango de precio seleccionado
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
                <!-- FILTRO POR TIPO DE CONSOLA (CON/SIN LECTOR) -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Tipo de Consola
                    </label>
                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php
                            // Muestra si tiene lector o es digital
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
                <!-- FILTRO POR ALMACENAMIENTO (ESPECÍFICO PARA SWITCH) -->
                <div class="col-md-3">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">
                        Almacenamiento
                    </label>
                    <div class="dropdown">
                        <button class="btn btn-dark w-100 dropdown-toggle text-start" data-bs-toggle="dropdown">
                            <?php echo $almacenamiento ?: 'Almacenamiento'; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100">
                            <!-- Opciones de almacenamiento para Nintendo Switch -->
                            <li><input type="radio" name="almacenamiento" value="32GB" <?php if ($almacenamiento == '32GB')
                                echo 'checked'; ?>> 32GB</li>
                            <li><input type="radio" name="almacenamiento" value="64GB" <?php if ($almacenamiento == '64GB')
                                echo 'checked'; ?>> 64GB</li>
                        </ul>
                    </div>
                </div>
                <!-- BOTONES DE APLICAR Y RESETEAR FILTROS -->
                <div class="col-md-3 d-flex gap-2 align-items-end">
                    <button type="submit" class="btn btn-info w-100">Aplicar</button>
                    <a href="consolas/switch" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </section>
        <!-- ====== LISTADO DE PRODUCTOS ====== -->
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                <?php
                // Consulta a la base de datos para obtener consolas Nintendo Switch filtradas
                $productos = obtenerConsolasFiltradas(
                    $conexion,
                    'Switch', // Plataforma: Nintendo Switch
                    $precio,
                    $tieneLector,
                    $almacenamiento
                );
                // Verificar si hay productos
                if (mysqli_num_rows($productos) > 0) {

                    // Recorre cada producto y genera su tarjeta
                    while ($fila = mysqli_fetch_assoc($productos)) {
                        ?>
                        <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                            <!-- Imagen del producto -->
                            <div>
                                <img class="card-img-top" src="assets/imagenes/<?php echo $fila['img_url']; ?>">
                            </div>

                            <!-- Información del producto -->
                            <div class="text-center">
                                <p class="fw-bold mb-0 mt-3"><?php echo $fila['nombre']; ?></p>
                                <p class="mb-3">
                                    <b>Precio:</b> <?php echo $fila['precio']; ?>€
                                </p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="mt-auto">
                                <?php if ($fila['stock'] > 0): ?>
                                    <!-- Botón añadir al carrito -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                        data-id="<?php echo $fila['id_producto']; ?>">
                                        <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                    </a>
                                <?php else: ?>
                                    <!-- Sin stock -->
                                    <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                        Sin stock
                                    </button>
                                <?php endif; ?>

                                <!-- Ver detalle -->
                                <a href="producto/<?php echo $fila['slug']; ?>" class="btn btn-secondary btn-sm w-100">
                                    <i class="bi bi-eye"></i> VER
                                </a>
                            </div>
                        </div>
                        <?php
                    }

                } else {
                    ?>
                    <div class="txt-sin-resultados">
                        <p>No se encontraron resultados.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </main>
    <!-- ====== FOOTER ====== -->
    <?php include ROOT_PATH . 'includes/footer.php'; ?>
    <!-- ====== SCRIPTS ====== -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/ui/submenu.js"></script>
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>