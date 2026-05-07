<?php
// ==========================================
// PÁGINA DE BÚSQUEDA DE PRODUCTOS
// ==========================================

// ====== CONFIGURACIÓN Y CONEXIÓN ======
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/busquedaDAO.php';

// ====== INICIO DE SESIÓN ======
session_start();

// ====== VALIDACIÓN DEL TÉRMINO DE BÚSQUEDA ======
// Si no hay término de búsqueda o está vacío, redirige al inicio
if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
    header("Location: /");
    exit();
}

// Sanitiza el término de búsqueda
$busqueda = trim($_GET['q']);

// Realiza la búsqueda en la base de datos
$resultados = buscarProductos($conexion, $busqueda);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Búsqueda</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- ====== HEADER ====== -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <!-- ====== CONTENIDO PRINCIPAL ====== -->
    <div class="container">

        <!-- Título con el término de búsqueda (sanitizado con htmlspecialchars para evitar XSS) -->
        <h2 class="mt-5">Resultados para: "<?php echo htmlspecialchars($busqueda); ?>"</h2>
        <hr>

        <!-- Grid de resultados -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

            <?php if (mysqli_num_rows($resultados) > 0): ?>
                <!-- Si hay resultados, los muestra -->

                <?php while ($producto = mysqli_fetch_assoc($resultados)):
                    // Si es un videojuego, aplica clase de marco según la plataforma
                    // Si no es videojuego (consola, accesorio), no aplica marco
                    $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
                    ?>

                    <div class="col d-flex justify-content-center">
                        <div class="card h-100 p-2 <?php echo $claseMarco; ?>">

                            <?php if (!empty($claseMarco)): ?>
                                <!-- Para videojuegos: contenedor con estilo de plataforma -->
                                <div class="<?php echo $claseMarco; ?>">
                                    <div class="card-img-container rounded shadow-sm">
                                        <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>">
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Para otros productos: imagen sin marco especial -->
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>">
                                </div>
                            <?php endif; ?>

                            <!-- Información del producto -->
                            <div class="text-center">
                                <p class="fw-bold mb-0 mt-3"><?php echo $producto['nombre']; ?></p>
                                <p class="mb-3"><b>Precio:</b> <?php echo $producto['precio']; ?>€</p>
                            </div>

                            <!-- Botones de acción -->
                            <div class="mt-auto">
                                <?php if ($producto['stock'] > 0): ?>
                                    <!-- Botón añadir al carrito (solo si hay stock) -->
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                        data-id="<?php echo $producto['id_producto']; ?>">
                                        <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                    </a>
                                <?php else: ?>
                                    <!-- Botón deshabilitado si no hay stock -->
                                    <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                        Sin stock
                                    </button>
                                <?php endif; ?>
                                <!-- Botón para ver detalle del producto -->
                                <a href="producto/<?php echo $producto['slug']; ?>" class="btn btn-secondary btn-sm w-100">
                                    <i class="bi bi-eye"></i> VER
                                </a>
                            </div>

                        </div>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                <!-- Si no hay resultados, muestra mensaje -->
                <div class="col-12 text-center">
                    <p>No se encontraron resultados.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

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
