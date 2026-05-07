<?php
// ================= CONFIGURACIÓN E INCLUDES =================
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

// ================= OBTENCIÓN DEL SLUG DEL PRODUCTO =================
// El slug se pasa por URL (ej: producto/zelda-tears-of-the-kingdom)
$slug = $_GET['slug'] ?? null;

// Si no hay slug, mostramos error
if (!$slug) {
    die("Producto no encontrado");
}

// ================= CONSULTA DEL PRODUCTO =================
// Buscamos el producto en la BD usando su slug único
$producto = obtenerProductoPorSlug($conexion, $slug);

// Si no existe el producto, mostramos error
if (!$producto) {
    die("Producto no existe");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Título dinámico con el nombre del producto -->
    <title>Viciogames | <?php echo $producto['nombre']; ?></title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- ================= HEADER DE USUARIO ================= -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <div class="container mt-5">

        <!-- ================= CONTENEDOR PRINCIPAL - DETALLE PRODUCTO ================= -->
        <div class="row flex-column flex-md-row">

            <?php
            // ================= CLASE CSS SEGÚN PLATAFORMA =================
            // Solo aplicamos clase de plataforma si el producto es un juego
            // Esto añade un borde de color según la plataforma (ps5, xbox, switch)
            $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
            ?>

            <!-- ================= COLUMNA IZQUIERDA: IMAGEN ================= -->
            <div class="col-12 col-md-6 mb-4">

                <!-- Contenedor clickeable que abre el modal -->
                <div class="<?php echo $claseMarco; ?> container-modal-producto d-flex justify-content-center align-items-center h-100 p-3"
                    data-bs-toggle="modal" data-bs-target="#modalImagen">

                    <div class="card-img-container-ver-detalle rounded">
                        <img class="card-img-top rounded-3" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">
                    </div>

                </div>

            </div>

            <!-- ================= COLUMNA DERECHA: INFORMACIÓN ================= -->
            <div class="col-12 col-md-6">

                <!-- ================= BREADCRUMB (MIGAS DE PAN) ================= -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $producto['tipo']; ?></li>
                    </ol>
                </nav>

                <!-- ================= NOMBRE DEL PRODUCTO ================= -->
                <h1 class="display-5 fw-bold"><?php echo $producto['nombre']; ?></h1>

                <!-- ================= BADGE DE PLATAFORMA ================= -->
                <!-- Color del badge según plataforma: Xbox=verde, PS5=azul, otros=rojo -->
                <span class="badge mb-3 p-2 bg-<?php
                echo ($producto['plataforma'] == 'Xbox') ? 'success' :
                    (($producto['plataforma'] == 'PS5') ? 'primary' : 'danger'); ?> w-25">
                    <?php echo $producto['plataforma']; ?>
                </span>

                <!-- ================= PRECIO Y STOCK ================= -->
                <h4 class="text-dark mb-4">
                    Precio: <?php echo $producto['precio']; ?>€
                </h4>

                <h4 class="text-dark mb-4">
                    Stock: <?php echo $producto['stock']; ?>
                </h4>

                <!-- ================= SISTEMA DE TABS (DESCRIPCIÓN/DETALLES) ================= -->
                <div class="tabs-container">

                    <!-- Botones de navegación entre tabs -->
                    <div class="tabs">
                        <button class="tab active" onclick="mostrarTab('descripcion')">Descripción</button>
                        <button class="tab" onclick="mostrarTab('detalles')">Ver detalles</button>
                    </div>

                    <!-- ================= TAB: DESCRIPCIÓN ================= -->
                    <div class="tab-content active" id="descripcion">
                        <p class="text-break"><?php echo $producto['descripcion']; ?></p>
                    </div>

                    <!-- ================= TAB: DETALLES TÉCNICOS ================= -->
                    <div class="tab-content" id="detalles">
                        <ul>
                            <li><strong>Tipo:</strong> <?php echo $producto['tipo']; ?></li>
                            <li><strong>Categoría:</strong> <?php echo $producto['categoria']; ?></li>
                            <li><strong>Plataforma:</strong> <?php echo $producto['plataforma']; ?></li>

                            <!-- Mostrar lector de discos solo si es consola -->
                            <?php if ($producto['tipo'] == 'Consola'): ?>
                                <li><strong>Lector de discos:</strong>
                                    <?php echo ($producto['tieneLector'] == 1) ? 'Sí' : 'No (Digital)'; ?>
                                </li>
                            <?php endif; ?>

                            <!-- Mostrar almacenamiento si está definido -->
                            <?php if (!empty($producto['almacenamiento'])): ?>
                                <li><strong>Almacenamiento:</strong>
                                    <?php echo $producto['almacenamiento']; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>

                </div>

                <!-- ================= BOTÓN AÑADIR AL CARRITO ================= -->
                <?php if ($producto['stock'] > 0): ?>
                    <!-- Botón activo si hay stock -->
                    <button class="btn btn-primary btn-lg w-100 mb-2 btn-add-carrito"
                        data-id="<?php echo $producto['id_producto']; ?>">
                        <i class="bi bi-cart-plus"></i> Añadir al Carrito
                    </button>
                <?php else: ?>
                    <!-- Botón deshabilitado si no hay stock -->
                    <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                        Sin stock
                    </button>
                <?php endif; ?>

            </div>
        </div>

        <!-- ================= SECCIÓN: PRODUCTOS RECOMENDADOS ================= -->
        <div class="mt-5 pt-5 border-top border-secondary">
            <h3>También te puede interesar</h3>
        </div>

        <!-- ================= SLIDER DE RECOMENDADOS ================= -->
        <div class="contenedor-slider">

            <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)">
                <i class="bi bi-chevron-left"></i>
            </button>

            <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">

                <?php
                // ================= OBTENER PRODUCTOS RECOMENDADOS =================
                // Obtenemos productos aleatorios de la misma plataforma y tipo,
                // excluyendo el producto actual
                $recomendadosAleatorios = obtenerRecomendadosAleatorios(
                    $conexion,
                    $producto['plataforma'],
                    $producto['id_producto'],
                    $tipo = $producto['tipo'],
                );

                // Iteramos sobre los productos recomendados
                foreach ($recomendadosAleatorios as $recomendado):
                    // Aplicamos clase de plataforma solo si es juego
                    $claseMarco = ($recomendado['tipo'] == 'Juego') ? strtolower($recomendado['plataforma']) : '';
                    ?>

                    <!-- Card del producto recomendado -->
                    <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2 <?php echo $claseMarco; ?>">

                        <!-- Imagen con o sin marco según tipo de producto -->
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

                        <!-- Información del producto -->
                        <div class="text-center">
                            <p class="fw-bold mb-0 mt-3"><?php echo $recomendado['nombre']; ?></p>
                            <p class="mb-3"><b>Precio:</b> <?php echo $recomendado['precio']; ?>€</p>
                        </div>

                        <!-- Botones de acción -->
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

    <!-- ================= MODAL DE IMAGEN AMPLIADA ================= -->
    <!-- Se abre al hacer click en la imagen principal del producto -->
    <div class="modal fade" id="modalImagen" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-center">

                <!-- Botón cerrar modal -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"></button>

                <!-- Imagen ampliada con marco de plataforma -->
                <div class="<?php echo $claseMarco; ?> d-flex justify-content-center align-items-center p-4">

                    <div class="card-img-container-ver-detalle-modal position-relative">
                        <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- ================= FOOTER ================= -->
    <?php include ROOT_PATH . 'includes/footer.php'; ?>

    <!-- ================= SCRIPTS ================= -->
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
