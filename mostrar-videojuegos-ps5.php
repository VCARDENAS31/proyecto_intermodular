<?php
include 'consultas.php'; // Incluimos tus funciones
include 'conexion-bd.php'; // Tu conexión a la DB
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tienda de Videojuegos</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/prueba.css">

</head>

<body>
    <?php include 'header-user.php'; ?>

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
                    <li class="nav-item border-bottom border-secondary border-opacity-25 border-lg-0">
                        <a class="text-white nav-link p-3 p-lg-4" href="#">
                            <i class="bi bi-controller"></i> PS5
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-25 border-lg-0">
                        <a class="text-white nav-link p-3 p-lg-4" href="#">
                            <i class="bi bi-xbox"></i> XBOX SERIES X/S
                        </a>
                    </li>
                    <li class="nav-item border-bottom border-secondary border-opacity-25 border-lg-0">
                        <a class="text-white nav-link p-3 p-lg-4" href="#">
                            <i class="bi bi-nintendo-switch"></i> NINTENDO SWITCH
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <section class="barra-filtro p-4 mb-5 shadow-lg">
            <form class="row g-3 align-items-end justify-content-center">
                <div class="col-12 col-md-4">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">Filtrar por Género</label>
                    <div class="dropdown">
                        <button
                            class="btn btn-dark w-100 dropdown-toggle text-start d-flex justify-content-between align-items-center border-secondary"
                            type="button" data-bs-toggle="dropdown">
                            Categorías
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100 shadow-lg">
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="cat1"><label
                                        class="form-check-label" for="cat1">Deportes</label></div>
                            </li>
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="cat2"><label
                                        class="form-check-label" for="cat2">Acción</label></div>
                            </li>
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="cat3"><label
                                        class="form-check-label" for="cat3">Aventura</label></div>
                            </li>
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="cat4"><label
                                        class="form-check-label" for="cat4">Terror</label></div>
                            </li>
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="cat5"><label
                                        class="form-check-label" for="cat5">RPG</label></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label text-info small fw-bold mb-2 uppercase">Presupuesto</label>
                    <div class="dropdown">
                        <button
                            class="btn btn-dark w-100 dropdown-toggle text-start d-flex justify-content-between align-items-center border-secondary"
                            type="button" data-bs-toggle="dropdown">
                            Rango de Precio
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark p-3 w-100">
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="p1"><label
                                        class="form-check-label" for="p1">Menos de 20€</label></div>
                            </li>
                            <li>
                                <div class="form-check"><input class="form-check-input" type="checkbox" id="p2"><label
                                        class="form-check-label" for="p2">20€ - 50€</label></div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-info w-100 fw-bold py-2 shadow-sm text-uppercase">
                        <i class="bi bi-filter"></i> Aplicar
                    </button>
                </div>
            </form>
        </section>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                
                
                <?php
                $productosPS5 = obtenerJuegosPorPlataforma($conexion, 'PS5');
                while ($fila = mysqli_fetch_assoc($productosPS5)) {
                    ?>
                    <div class="card ps5 col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                        <div class="card-img-container">
                            <img class="card-img-top" src="assets/imagenes/<?php echo $fila['img_url']; ?>">
                        </div>
                        <div class="text-center">
                            <p class="fw-bold mb-0 mt-3"><?php echo $fila['nombre']; ?></p>
                            <p class=" mb-3"><b>Precio:</b> <?php echo $fila['precio']; ?>€</p>
                        </div>
                        <div class="mt-auto">
                            <button class="btn btn-primary btn-sm w-100 mb-1">
                                <i class="bi bi-cart"></i> COMPRAR
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
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="funciones-crud.js"></script>
<script src="efectos.js"></script>

</html>