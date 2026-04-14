<?php

session_start();


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
    <link href="https://googleapis.com" rel="stylesheet">
</head>

<body>
    <?php include 'header-user.php'; ?>

    <main>
        <!-- CAROUSEL RESPONSIVO -->
        <div class="container mt-5 mb-5 ">
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
                        <img src="assets/imagenes/the_last_of_us_II.png" class="d-block w-100 img-fluid rounded-4"
                            alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/re2_remake.png" class="d-block w-100 img-fluid rounded-4" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/imagenes/gow_ragnarok.png" class="d-block w-100  rounded-4" alt="">
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
        <!-- Próximos lanzamientos -->
        <section id="proximos-lanzamientos">
            <div class="container rounded-4 p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">PRÓXIMAMENTE</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">PRÓXIMAMENTE</h2>
                    </div>

                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>

                </div>

                <hr>
                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>
                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/code-vein.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/crimsom.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/dragon-quest.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/final-fantasy-2.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/juego-007.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/mario-tennis.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/monster-hunters.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/pokemon-pokopia.webp">
                        </div>

                        <div class="card col-6 col-md-4 col-lg-3 flex-shrink-0">
                            <img class="card-img-top img-fluid" src="assets/imagenes/resident-evil-requiem.webp">
                        </div>

                    </div>
                    <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)"><i
                            class="bi bi-chevron-right"></i></button>
                </div>

        </section>

        <!-- Videojuegos -->
        <section id="videojuegos">
            <div class="container p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">VIDEOJUEGOS</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">VIDEOJUEGOS</h2>
                    </div>

                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
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
                        $ultimosJuegos = obtenerUltimosJuegosIntercalados($conexion);

                        // Supongamos que $ultimosJuegos es el resultado de tu consulta SQL
                        foreach ($ultimosJuegos as $juego) {
                            // Convertimos 'PS5' a 'ps5', 'Switch' a 'switch', etc.
                            $clasePlataforma = strtolower($juego['plataforma']);
                            ?>

                            <div class="card <?php echo $clasePlataforma; ?> col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div class="card-img-container">
                                    <img class="card-img-top rounded-3"
                                        src="assets/imagenes/<?php echo $juego['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $juego['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $juego['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($juego['stock'] > 0): ?>

                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $juego['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>

                                    <?php else: ?>

                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>

                                    <?php endif; ?>
                                    <a href="producto.php?id=<?php echo $juego['id_producto']; ?>"
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


        <!-- Consolas -->
        <section id="consolas">
            <div class="container p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">CONSOLAS</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">CONSOLAS</h2>
                    </div>

                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
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
                        $ultimasConsolas = obtenerUltimasConsolasIntercaladas($conexion);

                        // Supongamos que $ultimasConsolas es el resultado de tu consulta SQL
                        foreach ($ultimasConsolas as $consolas) {
                            ?>

                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $consolas['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $consolas['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $consolas['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <button class="btn btn-primary btn-sm w-100 mb-1">
                                        <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                    </button>
                                    <a href="producto.php?id=<?php echo $consolas['id_producto']; ?>"
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

        <!-- Accesorios -->
        <section id="accesorios">
            <div class="container p-4">
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">

                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">ACCESORIOS</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">ACCESORIOS</h2>
                    </div>

                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
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
                        $ultimosAccesorios = obtenerUltimosAccesoriosIntercalados($conexion);

                        // Supongamos que $ultimosAccesorios es el resultado de tu consulta SQL
                        foreach ($ultimosAccesorios as $accesorio) {
                            ?>

                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $accesorio['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $accesorio['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $accesorio['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <button class="btn btn-primary btn-sm w-100 mb-1">
                                        <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                    </button>
                                    <a href="producto.php?id=<?php echo $accesorio['id_producto']; ?>"
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

        <!-- ===== SECCIÓN NOTICIAS ===== -->
        <section id="noticias-videojuegos" class="py-5">
            <div class="container">
                <hr class="mb-5">

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card-noticia shadow-sm">
                            <a href="https://www.hobbyconsolas.com/videojuegos/sony-anuncia-coleccion-hyperpop-con-nuevos-mandos-carcasas-ps5-3-colores-reservas-precio-fecha-lanzamiento_6918304_0.html"
                                class="link-noticia">
                                <img src="https://images.unsplash.com/photo-1606144042614-b2417e99c4e3?auto=format&fit=crop&q=80&w=500"
                                    alt="DualSense PS5" class="card-img-top">
                                <div class="card-body p-4">
                                    <span>Hardware</span>
                                    <h3>Nuevos colores para el DualSense Edge confirmados</h3>
                                    <p>Sony anuncia una nueva línea de mandos profesionales con acabados metálicos que
                                        llegarán a las tiendas el próximo mes.</p>
                                </div>
                        </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="https://www.muycomputer.com/2026/01/12/intel-panther-lake-estara-al-nivel-de-ps6-portatil/"
                            class="link-noticia">
                            <div class="card-noticia shadow-sm">
                                <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&q=80&w=500"
                                    class="card-img-top" alt="Hardware">
                                <div class="card-body p-4">
                                    <span class="categoria-noticia">Hardware</span>
                                    <h3>Nueva consola portátil en desarrollo</h3>
                                    <p>Filtraciones indican que la nueva generación de dispositivos
                                        portátiles duplicará su potencia gráfica este otoño.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="https://www.clavecd.es/elden-ring-2-impactante-actualizacion-de-fromsoftware-news-d/"
                            class="link-noticia">
                            <div class="card-noticia shadow-sm">
                                <img src="https://images.unsplash.com/photo-1612287230202-1ff1d85d1bdf?auto=format&fit=crop&q=80&w=500"
                                    class="card-img-top" alt="Lanzamientos">
                                <div class="card-body p-4">
                                    <span>Lanzamientos</span>
                                    <h3>Elden Ring 2: Rumores sobre su mundo abierto</h3>
                                    <p>Nuevos reportes sugieren que el mapa será tres veces más
                                        grande e incluirá un sistema climático dinámico.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- ================= FOOTER ================= -->
    <?php include 'footer.php'; ?>

    <!-- Scripts requeridos para Bootstrap -->
    <script src="efectos.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>