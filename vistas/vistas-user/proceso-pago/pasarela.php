<?php
/* ============================================================
   PASARELA.PHP
   Paso 1 del checkout: muestra el contenido de la cesta,
   permite aplicar cupones y avanza al paso de pago.
   ============================================================ */
/* ------------------------------------------------------------
   INICIALIZACIÓN DE SESIÓN
   ------------------------------------------------------------ */
session_start();
/* ------------------------------------------------------------
   CUPÓN Y TOTAL INICIAL
   Se recupera el cupón de sesión (si existe) y se inicializa
   el acumulador del total de productos.
   ------------------------------------------------------------ */
$cupon = $_SESSION['cupon'] ?? null;
$total = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========== META Y BASE ========== -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pasarela de pago</title>
    <!-- ========== FAVICON ========== -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <!-- ========== FUENTES Y ESTILOS ========== -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- ========== BARRA DE NAVEGACIÓN DEL CHECKOUT ========== -->
    <div class="checkout-nav py-3 px-4 d-flex justify-content-between align-items-center">
        <!-- Logo con enlace al inicio -->
    <a href="/">
        <div class="logo-checkout">
            <img src="assets/imagenes/logo/logo_tienda.png" height="40">
        </div>
    </a>
        <!-- Indicador de pasos (Paso 1 activo) -->
        <div class="checkout-steps d-flex align-items-center gap-3">
            <div class="step active">
                <span>1</span>
                <p>Cesta</p>
            </div>
            <div class="line"></div>
            <div class="step">
                <span>2</span>
                <p>Envío y Pago</p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <!-- ===================================================
                 COLUMNA IZQUIERDA: PRODUCTOS DEL CARRITO
                 =================================================== -->
            <div class="col-lg-8">
                <!-- Título con contador de productos -->
                <h3 class="fw-bold mb-4">
                    Cesta (<?php echo count($_SESSION['carrito']); ?> productos)
                </h3>
                <?php
                /* ------------------------------------------------
                   RECORRIDO DEL CARRITO
                   Por cada producto se calcula el subtotal de línea
                   y se acumula en $total.
                   ------------------------------------------------ */
                foreach ($_SESSION['carrito'] as $id => $producto):
                    $subtotal = $producto['precio'] * $producto['cantidad'];
                    $total += $subtotal;
                    /* Clase CSS para el marco de imagen según plataforma
                       (solo se aplica a juegos). */
                    $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';
                    ?>
                    <!-- Tarjeta de producto -->
                    <div class="mb-3 p-3 shadow-sm">
                        <div class="row align-items-center bg-white p-3 rounded">
                            <!-- Imagen del producto -->
                            <div class="col-md-3 text-center justify-content-center d-flex">
                                <div class="card">
                                    <?php if (!empty($claseMarco)): ?>
                                        <!-- Juego: marco con clase de plataforma -->
                                        <div class="<?php echo $claseMarco; ?>">
                                            <div class="card-img-container rounded shadow-sm">
                                                <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img']; ?>">
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- Consola/accesorio: sin marco especial -->
                                        <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img']; ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Nombre y plataforma -->
                            <div class="col-md-6 text-center text-md-start">
                                <h5 class="fw-bold m-3"><?php echo $producto['nombre']; ?></h5>
                                <p class="text-muted mb-1">Plataforma: <?php echo $producto['plataforma']; ?></p>
                            </div>
                            <!-- Precio y cantidad -->
                            <div class="col-md-3 text-end">
                                <h5><?php echo number_format($subtotal, 2); ?>€</h5>
                                <h5>Cantidad: <?php echo $producto['cantidad']; ?></h5>
                            </div>
                        </div>
                    </div>
                    <!-- FIN tarjeta producto -->
                <?php endforeach; ?>
            </div>
            <!-- FIN columna izquierda -->
            <!-- ===================================================
                 COLUMNA DERECHA: RESUMEN Y CUPÓN
                 =================================================== -->
            <div class="col-lg-4">
                <div class="p-4 shadow-sm bg-white rounded">
                    <h4 class="fw-bold mb-3">Resumen</h4>
                    <!-- ===== SECCIÓN DE CUPÓN ===== -->
                    <p class="mb-2 fw-bold">¿Tienes un código descuento?</p>
                    <div class="d-flex mb-2">
                        <input type="text" id="inputCupon" class="form-control me-2" placeholder="Introduce código">
                        <button id="btnCupon" class="btn btn-primary">Aplicar</button>
                    </div>
                    <!-- Mensaje de cupón aplicado -->
                    <div id="mensajeCupon" class="mb-3">
                        <?php if ($cupon): ?>
                            <span style="color:green;">
                                Cupón aplicado (-<?php echo $cupon['descuento_porcentaje']; ?>%)
                            </span>
                        <?php endif; ?>
                    </div>
                    <!-- ===== DESGLOSE DE PRECIOS ===== -->
                    <!-- Subtotal productos -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span><?php echo number_format($total, 2); ?>€</span>
                    </div>
                    <?php
                    /* ------------------------------------------------
                       CÁLCULO DEL DESCUENTO POR CUPÓN
                       ------------------------------------------------ */
                    $descuento = 0;
                    if ($cupon) {
                        $descuento = ($total * $cupon['descuento_porcentaje']) / 100;
                    }
                    ?>
                    <!-- Descuento (si hay) -->
                    <?php if ($descuento > 0): ?>
                        <div class="d-flex justify-content-between text-success">
                            <span>Descuento</span>
                            <span>-<?php echo number_format($descuento, 2); ?>€</span>
                        </div>
                    <?php endif; ?>
                    <!-- Gastos de envío fijos -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío (No aplica para el descuento)</span>
                        <span>2,99€</span>
                    </div>
                    <hr>
                    <?php
                    /* ------------------------------------------------
                       TOTAL FINAL (productos − descuento + envío)
                       ------------------------------------------------ */
                    $totalFinal = $total - $descuento + 2.99;
                    ?>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalFinal, 2); ?>€</strong>
                    </div>
                    <!-- ===== BOTÓN DE CONTINUAR O LOGIN ===== -->
                    <?php if (isset($_SESSION['usuario_nombre'])): ?>
                        <!-- Usuario logueado: avanza al checkout -->
                        <a href="checkout" class="btn btn-primary w-100">
                            Finalizar compra
                        </a>
                    <?php else: ?>
                        <!-- Usuario no logueado: requiere iniciar sesión -->
                        <div class="alert alert-danger text-center">
                            Debes iniciar sesión para Añadir a la cesta
                        </div>
                        <a href="login" class="btn btn-primary w-100">
                            Iniciar sesión
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <!-- FIN columna derecha -->
        </div>
    </div>
    <!-- ========== SCRIPTS ========== -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/cupon/cupon.js"></script>
</body>
</html>