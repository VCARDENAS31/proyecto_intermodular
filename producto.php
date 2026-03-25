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
    <title><?php echo $producto['nombre']; ?> - Tienda</title>
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <!-- NAVBAR PRINCIPAL -->
        <nav class="navbar-principal navbar navbar-expand-lg d-flex p-2 navbar-dark">
            <!-- Botón menú móvil -->
            <button class="navbar-toggler" type="button" id="botonMenu">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="logo">
                <img class="img-fluid" src="assets/imagenes/logo_tienda.png">
            </div>


            <!-- SIDEBAR MÓVIL -->
            <div id="sidebarMovil" class="d-flex flex-column">
                <!-- Botón cerrar sidebar -->
                <button id="cerrarSidebar" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    aria-label="Cerrar"></button>

                <h2 class="text-white mt-5 text-center mb-5">Categorías</h2>
                <!-- Menú categorías -->
                <a href="#" class="text-white menu-item text-decoration-none"><i class="bi bi-controller"></i>
                    VIDEOJUEGOS</a></li>
                <a href="#" class="text-white menu-item text-decoration-none"><i class="bi bi-box-fill"></i>
                    CONSOLAS</a></li>
                <a href="#" class="text-white menu-item text-decoration-none"><i class="bi bi-headset"></i>
                    ACCESORIOS</a></li>
                <a href="#" class="text-white menu-item text-decoration-none"><i class="bi bi-calendar-event"></i>
                    PRÓXIMOS
                    LANZAMIENTOS</a>
                </li>
                </ul>
                <!-- Buscador móvil -->
                <form class="d-flex w-100 my-3 px-4">
                    <input class="form-control rounded-pill px-4" type="search" placeholder="Buscar videojuegos">
                </form>
                <!-- Botón cerrar sesión -->
                <button class="btn btn-danger logout-btn btn-cerrar-sesion">
                    CERRAR SESIÓN
                </button>
            </div>
            <!-- ===== FIN SIDEBAR ===== -->

            <!-- Overlay -->
            <div id="overlaySidebar"></div>

            <!-- Buscador escritorio -->
            <form class="d-none d-lg-flex w-100 my-3 px-4">
                <input class="form-control rounded-pill px-4 d-flex" type="search" placeholder="Buscar videojuegos">
            </form>

            </div>

            <!-- Iconos usuario y carrito -->
            <div class="d-xs-none d-flex iconos-nav">
                <div class="dropdown">
                    <!-- icono login -->
                    <a href="#" class="text-white " id="userMenu" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item btn-cerrar-sesion" href="#"><i
                                    class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                    </ul>
                </div>

                <!-- icono Carrito -->
                <a href="#" class="text-white">
                    <i class="bi bi-cart fs-4"></i>
                </a>
            </div>
        </nav>


        <!-- NAVBAR SECUNDARIO -->
        <div class="navbar-secundario d-none d-lg-block">
            <div class="container">
                <ul class="nav w-100 justify-content-between text-center">
                    <li class="nav-item">
                        <a class="nav-link text-white p-3 menu-item mb-3 mt-2" href="#">
                            <i class="bi bi-controller"></i> VIDEOJUEGOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white p-3 menu-item mb-3 mt-2" href="#">
                            <i class="bi bi-box-fill"></i> CONSOLAS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white p-3 menu-item mb-3 mt-2" href="#">
                            <i class="bi bi-headset"></i> ACCESORIOS
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white p-3 menu-item mb-3 mt-2" href="#">
                            <i class="bi bi-calendar-event"></i> PRÓXIMOS LANZAMIENTOS
                        </a>
                    </li>
                </ul>
            </div>
        </div>

    </header>


    <div class="container mt-5">
        <div class="row">
            <?php
            // Solo activamos la clase de plataforma si es un Juego
            $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
            ?>
            <div class="col-md-6 mb-4">
                <div class=" <?php echo $claseMarco; ?> border border-primary border-3 justify-content-center align-items-center d-flex h-100 ">

                    <div class="card-img-container-ver-detalle rounded">
                        <img class="card-img-top rounded-3" src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                            alt="<?php echo $producto['nombre']; ?>">
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $producto['tipo']; ?></li>
                    </ol>
                </nav>

                <h1 class="display-5 fw-bold"><?php echo $producto['nombre']; ?></h1>

                <span
                    class="badge mb-3 p-2 bg-<?php echo ($producto['plataforma'] == 'Xbox') ? 'success' : (($producto['plataforma'] == 'PS5') ? 'primary' : 'danger'); ?>">
                    <?php echo $producto['plataforma']; ?>
                </span>

                <h2 class="text-warning mb-4"><?php echo $producto['precio']; ?>€</h2>

                <div class="mb-4">
                    <h5>Descripción</h5>
                    <p class="text-light-50"><?php echo $producto['descripcion']; ?></p>
                </div>

                <div class="card bg-dark border-secondary p-3 mb-4">
                    <ul class="list-unstyled mb-0">
                        <li><strong>Stock disponible:</strong> <?php echo $producto['stock']; ?> unidades</li>
                        <li><strong>Categoría:</strong> <?php echo $producto['categoria'] ?: 'General'; ?></li>

                        <?php if ($producto['tipo'] == 'Juego'): ?>
                            <li><i class="bi bi-controller"></i> Formato: Disco / Digital</li>
                        <?php elseif ($producto['tipo'] == 'Accesorio'): ?>
                            <li><i class="bi bi-usb-plug"></i> Conectividad: USB / Inalámbrico</li>
                        <?php endif; ?>
                    </ul>
                </div>

                <button class="btn btn-primary btn-lg w-100 mb-2">
                    <i class="bi bi-cart-plus"></i> Añadir al Carrito
                </button>
            </div>
        </div>

        <div class="mt-5 pt-5 border-top border-secondary">
            <h3>También te puede interesar</h3>
        </div>
    </div>

</body>

</html>