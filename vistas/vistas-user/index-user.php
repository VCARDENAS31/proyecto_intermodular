<?php
// ================= CONFIGURACIÓN E INCLUDES =================
// Cargamos la configuración principal del proyecto
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Conexión a la base de datos
require_once ROOT_PATH . 'dao/conexion-bd.php';

// Funciones DAO para operaciones con productos
require_once ROOT_PATH . 'dao/productoDAO.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DE USUARIO ================= -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>

    <main>
        <!-- ================= CAROUSEL PRINCIPAL ================= -->
        <!-- Carousel responsivo con imágenes promocionales -->
        <div class="container mt-5 mb-5 ">
            <div id="carrusel-imagenes" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicadores del carousel (puntos de navegación) -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="0"
                        class="active"></button>
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#carrusel-imagenes" data-bs-slide-to="2"></button>
                </div>

                <!-- Slides del carousel -->
                <div class="carousel-inner">
                    <!-- Primer slide (activo por defecto) -->
                    <div class="carousel-item active">
                        <img src="assets/imagenes/banner1-principal.webp" class="d-block w-100 img-fluid rounded-4" alt="Banner principal">
                    </div>
                    <!-- Segundo slide -->
                    <div class="carousel-item">
                        <img src="assets/imagenes/banner2-principal.webp" class="d-block w-100 img-fluid rounded-4" alt="Banner secundario">
                    </div>
                    <!-- Tercer slide -->
                    <div class="carousel-item">
                        <img src="assets/imagenes/banner3-principal.webp" class="d-block w-100 img-fluid rounded-4" alt="Banner terciario">
                    </div>
                </div>

                <!-- Controles de navegación (flechas) -->
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

        <!-- ================= SECCIÓN: PRÓXIMOS LANZAMIENTOS ================= -->
        <!-- Muestra juegos que saldrán próximamente (solo imágenes, sin funcionalidad de compra) -->
        <section id="proximos-lanzamientos">
            <div class="container rounded-4 p-4">
                
                <!-- Título responsive (diferente tamaño en móvil y desktop) -->
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">
                    <!-- Título para móvil -->
                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">PRÓXIMAMENTE</h6>
                    </div>
                    <!-- Título para desktop -->
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">PRÓXIMAMENTE</h2>
                    </div>
                </div>

                <hr>
                
                <!-- ================= SLIDER HORIZONTAL ================= -->
                <div class="contenedor-slider">
                    <!-- Botón scroll izquierda -->
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>
                    
                    <!-- Contenedor de cards con scroll horizontal -->
                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">

                        <!-- Cards de próximos lanzamientos (estáticas) -->
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
                    
                    <!-- Botón scroll derecha -->
                    <button class="btn-scroll next-btn" onclick="scrollSlider(this, 300)"><i
                            class="bi bi-chevron-right"></i></button>
                </div>

        </section>

        <!-- ================= SECCIÓN: VIDEOJUEGOS ================= -->
        <!-- Muestra los últimos videojuegos intercalados por plataforma -->
        <section id="videojuegos">
            <div class="container p-4">
                
                <!-- Título y botón "Ver todo" -->
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">
                    <!-- Título móvil -->
                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">VIDEOJUEGOS</h6>
                    </div>
                    <!-- Título desktop -->
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">VIDEOJUEGOS</h2>
                    </div>
                    <!-- Enlace a la página completa de videojuegos -->
                    <a href="videojuegos" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>
                </div>
                <hr>

                <!-- ================= SLIDER DE VIDEOJUEGOS ================= -->
                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // ================= CARGA DINÁMICA DE VIDEOJUEGOS =================
                        // Obtenemos los últimos juegos intercalados por plataforma
                        $ultimosJuegos = obtenerUltimosJuegosIntercalados($conexion);

                        // Iteramos sobre cada juego para crear su card
                        foreach ($ultimosJuegos as $juego) {
                            // Convertimos la plataforma a minúsculas para usar como clase CSS
                            // Ejemplo: 'PS5' -> 'ps5', 'Switch' -> 'switch'
                            $clasePlataforma = strtolower($juego['plataforma']);
                            ?>

                            <!-- Card del videojuego con clase de plataforma para estilos específicos -->
                            <div class="card <?php echo $clasePlataforma; ?> col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                
                                <!-- Contenedor de imagen -->
                                <div class="card-img-container">
                                    <img class="card-img-top rounded-3"
                                        src="assets/imagenes/<?php echo $juego['img_url']; ?>">
                                </div>
                                
                                <!-- Información del producto -->
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $juego['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $juego['precio']; ?>€</p>
                                </div>
                                
                                <!-- Botones de acción -->
                                <div class="mt-auto">
                                    <?php if ($juego['stock'] > 0): ?>
                                        <!-- Botón añadir al carrito (solo si hay stock) -->
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $juego['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>
                                        <!-- Botón deshabilitado si no hay stock -->
                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>
                                    
                                    <!-- Botón ver detalles del producto -->
                                    <a href="producto/<?php echo $juego['slug']; ?>" class="btn btn-secondary btn-sm w-100">
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


        <!-- ================= SECCIÓN: CONSOLAS ================= -->
        <!-- Muestra las últimas consolas intercaladas por plataforma -->
        <section id="consolas">
            <div class="container p-4">
                
                <!-- Título y botón "Ver todo" -->
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">
                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">CONSOLAS</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">CONSOLAS</h2>
                    </div>
                    <a href="consolas" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>
                </div>
                <hr>

                <!-- ================= SLIDER DE CONSOLAS ================= -->
                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // ================= CARGA DINÁMICA DE CONSOLAS =================
                        $ultimasConsolas = obtenerUltimasConsolasIntercaladas($conexion);

                        foreach ($ultimasConsolas as $consolas) {
                            ?>

                            <!-- Card de consola (sin clase de plataforma ya que no aplica el mismo estilo) -->
                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $consolas['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $consolas['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $consolas['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($consolas['stock'] > 0): ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $consolas['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>
                                    <a href="producto/<?php echo $consolas['slug']; ?>"
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

        <!-- ================= SECCIÓN: ACCESORIOS ================= -->
        <!-- Muestra los últimos accesorios intercalados -->
        <section id="accesorios">
            <div class="container p-4">
                
                <!-- Título y botón "Ver todo" -->
                <div class="mb-4 mb-md-5 justify-content-between align-items-center d-flex">
                    <div class="d-md-none">
                        <h6 class="fw-bold mb-0">ACCESORIOS</h6>
                    </div>
                    <div class="d-none d-md-block">
                        <h2 class="fw-bold mb-0">ACCESORIOS</h2>
                    </div>
                    <a href="accesorios" class="btn btn-sm btn-outline-primary rounded-pill px-3 px-md-4">
                        Ver todo
                    </a>
                </div>
                <hr>

                <!-- ================= SLIDER DE ACCESORIOS ================= -->
                <div class="contenedor-slider">
                    <button class="btn-scroll prev-btn" onclick="scrollSlider(this, -300)"><i
                            class="bi bi-chevron-left"></i></button>

                    <div id="arrastrar-scroll" class="d-flex flex-nowrap gap-3 overflow-auto pb-3">
                        <?php
                        // ================= CARGA DINÁMICA DE ACCESORIOS =================
                        $ultimosAccesorios = obtenerUltimosAccesoriosIntercalados($conexion);

                        foreach ($ultimosAccesorios as $accesorio) {
                            ?>

                            <!-- Card de accesorio -->
                            <div class="card col-9 col-sm-6 col-md-4 col-lg-3 p-2 m-2">
                                <div>
                                    <img class="card-img-top" src="assets/imagenes/<?php echo $accesorio['img_url']; ?>">
                                </div>
                                <div class="text-center">
                                    <p class="fw-bold mb-0 mt-3"><?php echo $accesorio['nombre']; ?></p>
                                    <p class="mb-3"><b>Precio:</b> <?php echo $accesorio['precio']; ?>€</p>
                                </div>
                                <div class="mt-auto">
                                    <?php if ($accesorio['stock'] > 0): ?>
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm w-100 mb-1 btn-add-carrito"
                                            data-id="<?php echo $accesorio['id_producto']; ?>">
                                            <i class="bi bi-cart"></i> AÑADIR AL CARRITO
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm w-100 mb-1" disabled>
                                            Sin stock
                                        </button>
                                    <?php endif; ?>
                                    <a href="producto/<?php echo $accesorio['slug']; ?>"
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

        <!-- ================= SECCIÓN: NOTICIAS DE VIDEOJUEGOS ================= -->
        <!-- Muestra cards con enlaces a noticias externas del sector -->
        <section id="noticias-videojuegos" class="py-5">
            <div class="container">
                <hr class="mb-5">

                <div class="row g-4">
                    
                    <!-- ================= NOTICIA 1: Hardware ================= -->
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
                            </a>
                        </div>
                    </div>

                    <!-- ================= NOTICIA 2: Hardware ================= -->
                    <div class="col-md-4">
                        <a href="https://www.muycomputer.com/2026/01/12/intel-panther-lake-estara-al-nivel-de-ps6-portatil"
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

                    <!-- ================= NOTICIA 3: Lanzamientos ================= -->
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
    <?php include 'includes/footer.php'; ?>

    <!-- ================= SCRIPTS ================= -->
    <!-- Bootstrap JS -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Utilidades para modales -->
    <script src="js/utils/modal.js"></script>
    <!-- Control del sidebar -->
    <script src="js/ui/sidebar.js"></script>
    <!-- Control del submenú desplegable -->
    <script src="js/ui/submenu.js"></script>
    <!-- Funcionalidad del slider horizontal -->
    <script src="js/ui/slider.js"></script>
    <!-- Interfaz de usuario del carrito -->
    <script src="js/carrito/carrito-ui.js"></script>
    <!-- Llamadas API del carrito -->
    <script src="js/carrito/carrito-api.js"></script>
    <!-- Funcionalidad de logout -->
    <script src="js/usuario/logout.js"></script>
</body>

</html>
