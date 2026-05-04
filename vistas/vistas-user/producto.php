<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    die("Producto no encontrado");
}

$producto = obtenerProductoPorSlug($conexion, $slug);

if (!$producto) {
    die("Producto no existe");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | <?php echo $producto['nombre']; ?></title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <div class="container mt-5">

        <div class="row flex-column flex-md-row">

            <?php
            $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
            ?>

            <!-- IMAGEN -->
            <div class="col-12 col-md-6 mb-4">

                <div class="<?php echo $claseMarco; ?> container-modal-producto d-flex justify-content-center align-items-center h-100 p-3"
                    data-bs-toggle="modal" data-bs-target="#modalImagen">

                    <div class="card-img-container-ver-detalle rounded">
                        <img class="card-img-top rounded-3" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">
                    </div>

                </div>

            </div>

            <!-- TEXTO -->
            <div class="col-12 col-md-6">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $producto['tipo']; ?></li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold"><?php echo $producto['nombre']; ?></h1>

                <span class="badge mb-3 p-2 bg-<?php
                echo ($producto['plataforma'] == 'Xbox') ? 'success' :
                    (($producto['plataforma'] == 'PS5') ? 'primary' : 'danger'); ?> w-25">
                    <?php echo $producto['plataforma']; ?>
                </span>

                <h4 class="text-dark mb-4">
                    Precio: <?php echo $producto['precio']; ?>€
                </h4>

                <h4 class="text-dark mb-4">
                    Stock: <?php echo $producto['stock']; ?>
                </h4>

                <div class="tabs-container">

                    <div class="tabs">
                        <button class="tab active" onclick="mostrarTab('descripcion')">Descripción</button>
                        <button class="tab" onclick="mostrarTab('detalles')">Ver detalles</button>
                    </div>

                    <div class="tab-content active" id="descripcion">
                        <p class="text-break"><?php echo $producto['descripcion']; ?></p>
                    </div>

                    <div class="tab-content" id="detalles">
                        <ul>
                            <li><strong>Tipo:</strong> <?php echo $producto['tipo']; ?></li>
                            <li><strong>Categoría:</strong> <?php echo $producto['categoria']; ?></li>
                            <li><strong>Plataforma:</strong> <?php echo $producto['plataforma']; ?></li>

                            <?php if ($producto['tipo'] == 'Consola'): ?>
                                <li><strong>Lector de discos:</strong>
                                    <?php echo ($producto['tieneLector'] == 1) ? 'Sí' : 'No (Digital)'; ?>
                                </li>
                            <?php endif; ?>

                            <?php if (!empty($producto['almacenamiento'])): ?>
                                <li><strong>Almacenamiento:</strong>
                                    <?php echo $producto['almacenamiento']; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>

                <?php if ($producto['stock'] > 0): ?>
                    <button class="btn btn-primary btn-lg w-100 mb-2 btn-add-carrito"
                        data-id="<?php echo $producto['id_producto']; ?>">
                        <i class="bi bi-cart-plus"></i> Añadir al Carrito
                    </button>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                        Sin stock
                    </button>
                <?php endif; ?>

            </div>
        </div>

        <!-- RECOMENDADOS -->
        <div class="mt-5 pt-5 border-top border-secondary">
            <h3>También te puede interesar</h3>
        </div>

        <div class="contenedor-slider">

            <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">

                <?php
                $recomendadosAleatorios = obtenerRecomendadosAleatorios(
                    $conexion,
                    $producto['plataforma'],
                    $producto['id_producto']
                );

                foreach ($recomendadosAleatorios as $recomendado):
                    $claseMarco = ($recomendado['tipo'] == 'Juego') ? strtolower($recomendado['plataforma']) : '';
                    ?>

                    <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2 <?php echo $claseMarco; ?>">

                        <?php if (!empty($claseMarco)): ?>
                            <div class="<?php echo $claseMarco; ?>">
                                <div class="card-img-container rounded shadow-sm">
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $recomendado['img_url']; ?>">
                                </div>
                            </div>
                        <?php else: ?>
                            <div>
                                <img class="card-img-top" src="assets/imagenes/<?php echo $recomendado['img_url']; ?>">
                            </div>
                        <?php endif; ?>

                        <div class="text-center">
                            <p class="fw-bold mb-0 mt-3"><?php echo $recomendado['nombre']; ?></p>
                            <p class="mb-3"><b>Precio:</b> <?php echo $recomendado['precio']; ?>€</p>
                        </div>

                        <div class="mt-auto">
                            <?php if ($recomendado['stock'] > 0): ?>

                                <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                    data-id="<?php echo $recomendado['id_producto']; ?>">
                                    <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                </a>
                            <?php else: ?>

                                <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                    Sin stock
                                </button>

                            <?php endif; ?>
                            <a href="producto/<?php echo $recomendado['slug']; ?>" class="btn btn-secondary btn-sm w-100">
                                <i class="bi bi-eye"></i> VER
                            </a>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>


            <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>

    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalImagen" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-center">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"></button>

                <div class="<?php echo $claseMarco; ?> d-flex justify-content-center align-items-center p-4">

                    <div class="card-img-container-ver-detalle-modal position-relative">
                        <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">
                    </div>

                </div>

            </div>
        </div>
    </div>

    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/ui/submenu.js"></script>
    <script src="js/ui/tabs.js"></script>
    <script src="js/ui/slider.js"></script>
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>