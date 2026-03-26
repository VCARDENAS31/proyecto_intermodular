<?php
include 'conexion-bd.php';
include 'consultas.php';

$id = $_GET['id'] ?? 0;
$producto = obtenerProductoPorId($conexion, $id);

if (!$producto) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto['nombre']; ?> - Tienda</title>

    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <!-- TU NAVBAR TAL CUAL -->
        <nav class="navbar-principal navbar navbar-expand-lg d-flex p-2 navbar-dark">

            <button class="navbar-toggler" type="button" id="botonMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="logo">
                <img class="img-fluid" src="assets/imagenes/logo_tienda.png">
            </div>

            <div id="sidebarMovil" class="d-flex flex-column">
                <button id="cerrarSidebar" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"></button>

                <h2 class="text-white mt-5 text-center mb-5">Categorías</h2>

                <a href="#" class="text-white menu-item text-decoration-none">VIDEOJUEGOS</a>
                <a href="#" class="text-white menu-item text-decoration-none">CONSOLAS</a>
                <a href="#" class="text-white menu-item text-decoration-none">ACCESORIOS</a>
                <a href="#" class="text-white menu-item text-decoration-none">PRÓXIMOS LANZAMIENTOS</a>

                <form class="d-flex w-100 my-3 px-4">
                    <input class="form-control rounded-pill px-4" type="search" placeholder="Buscar videojuegos">
                </form>

                <button class="btn btn-danger logout-btn btn-cerrar-sesion">
                    CERRAR SESIÓN
                </button>
            </div>

            <div id="overlaySidebar"></div>

            <form class="d-none d-lg-flex w-100 my-3 px-4">
                <input class="form-control rounded-pill px-4 d-flex" type="search" placeholder="Buscar videojuegos">
            </form>

            <div class="d-flex iconos-nav">
                <a href="#" class="text-white">
                    <i class="bi bi-person-circle fs-4"></i>
                </a>
                <a href="#" class="text-white">
                    <i class="bi bi-cart fs-4"></i>
                </a>
            </div>
        </nav>

        <!-- NAVBAR SECUNDARIO -->
        <div class="navbar-secundario d-none d-lg-block">
            <div class="container">
                <ul class="nav w-100 justify-content-between text-center">
                    <li class="nav-item"><a class="nav-link text-white p-3">VIDEOJUEGOS</a></li>
                    <li class="nav-item"><a class="nav-link text-white p-3">CONSOLAS</a></li>
                    <li class="nav-item"><a class="nav-link text-white p-3">ACCESORIOS</a></li>
                    <li class="nav-item"><a class="nav-link text-white p-3">PRÓXIMOS LANZAMIENTOS</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- CONTENIDO -->
    <div class="container mt-5">

        <!-- 🔥 RESPONSIVE REAL -->
        <div class="row flex-column flex-md-row">

            <?php
            $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
            ?>

            <!-- IMAGEN -->
            <div class="col-12 col-md-6 mb-4">

                <!-- 🔥 PADRE: marco -->
                <div class="<?php echo $claseMarco; ?> container-modal-producto d-flex justify-content-center align-items-center h-100 p-3"
                    data-bs-toggle="modal" data-bs-target="#modalImagen">

                    <!-- 🔥 HIJO: contenedor de imagen -->
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
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $producto['tipo']; ?></li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold"><?php echo $producto['nombre']; ?></h1>

                <span class="badge mb-3 p-2 bg-<?php
                echo ($producto['plataforma'] == 'Xbox') ? 'success' :
                    (($producto['plataforma'] == 'PS5') ? 'primary' : 'danger'); ?>">
                    <?php echo $producto['plataforma']; ?>
                </span>

                <h2 class="text-dark mb-4">Precio: <?php echo $producto['precio']; ?>€</h2>

                <div class="mb-4">
                    <h5>Descripción</h5>
                    <p class="text-black"><?php echo $producto['descripcion']; ?></p>
                </div>

                <div class="card w-100 border-secondary p-3 mb-4">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Stock disponible:</strong> <?php echo $producto['stock']; ?> unidades
                        </li>
                        <li class="mb-2"><strong>Categoría:</strong> <?php echo $producto['categoria'] ?: 'General'; ?>
                        </li>

                        <?php if ($producto['tipo'] == 'Juego'): ?>
                            <li><i class="bi bi-controller"></i><strong> Formato:</strong> Disco Físico</li>
                        <?php elseif ($producto['tipo'] == 'Accesorio'): ?>
                            <li><i class="bi bi-usb-plug"></i> <strong>Conectividad:</strong> USB / Inalámbrico</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <button class="btn btn-primary btn-lg w-100 mb-2">
                    <i class="bi bi-cart-plus"></i> Añadir al Carrito
                </button>

            </div>
        </div>

        <!-- RECOMENDADOS -->
        <div class="mt-5 pt-5 border-top border-secondary">
            <h3>También te puede interesar</h3>
        </div>

    </div>

    <div class="modal fade" id="modalImagen" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content text-center ">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"></button>

                <div class="<?php echo $claseMarco; ?> d-flex justify-content-center align-items-center p-4">

                    <!-- 🔥 IMPORTANTE: añadir clase original -->
                    <div class="card-img-container-ver-detalle-modal position-relative">

                        <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="efectos.js"></script>
    <script src="funciones.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>