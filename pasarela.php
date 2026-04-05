<?php

include 'conexion-bd.php';
include 'consultas.php';

session_start();

if (!isset($_SESSION['usuario_nombre'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['carrito'])) {
    echo "Carrito vacío";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tienda de Videojuegos</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://googleapis.com" rel="stylesheet">
</head>

<body>
    <div class="checkout-nav py-3 px-4 d-flex justify-content-between align-items-center">

        <!-- LOGO -->
        <div class="logo-checkout">
            <img src="assets/imagenes/logo_tienda.png" height="40">
        </div>

        <!-- PASOS -->
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

            <!-- 🛒 CARRITO -->
            <div class="col-lg-8">

                <h3 class="fw-bold mb-4">Cesta (<?php echo count($_SESSION['carrito'] ?? []); ?> productos)</h3>

                <?php
                $total = 0;

                if (!empty($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $id => $producto) {

                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;

                        $claseMarco = ($producto['tipo'] == 'Juego') ? strtolower($producto['plataforma']) : '';

                        ?>

                        <div class="mb-3 p-3 shadow-sm">
                            <div class="row align-items-center bg-white border border-primary p-3 rounded">

                                <div class="col-md-3 d-flex justify-content-center d-md-block text-center">
                                    <div class="card">
                                        <?php if (!empty($claseMarco)): ?>
                                            <div class="<?php echo $claseMarco; ?>">
                                                <div class="card-img-container rounded shadow-sm">
                                                    <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img']; ?>">
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div>
                                                <img class="card-img-top" src="assets/imagenes/<?php echo $producto['img']; ?>">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="fw-bold m-5"><?php echo $producto['nombre']; ?></h5>
                                    <p class="text-muted mb-1">Plataforma: <?php echo $producto['plataforma']; ?></p>

                                    <a href="#" class="text-danger btn-eliminar" data-id="<?php echo $id; ?>">
                                        Eliminar
                                    </a>
                                </div>

                                <div class="col-md-3 text-end">
                                    <h5><?php echo number_format($subtotal, 2); ?>€</h5>

                                    <h5>Cantidad: <?php echo $producto['cantidad']; ?></h5>
                                    
                                </div>

                            </div>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p>Carrito vacío</p>";
                }
                ?>

            </div>

            <!-- 💳 RESUMEN -->
            <div class="col-lg-4 bg-transparent">

                <div class="p-4 shadow-sm">

                    <h4 class="fw-bold mb-3">Resumen</h4>

                    <!-- CODIGO DESCUENTO -->
                    <p class="mb-2 fw-bold">¿Tienes un código descuento?</p>

                    <div class="d-flex mb-3">
                        <input type="text" class="form-control me-2 w-75" placeholder="Introduce código">
                        <button class="btn btn-primary">Aplicar</button>
                    </div>

                    <!-- RESUMEN PRECIOS -->
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span><?php echo number_format($total, 2); ?>€</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 align-items-center">
                        <span>
                            <i class="bi bi-truck"></i> Envío
                        </span>
                        <span>2,99€</span>
                    </div>

                    <hr>

                    <?php $totalFinal = $total + 2.99; ?>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalFinal, 2); ?>€</strong>
                    </div>

                    <?php if (isset($_SESSION['usuario_nombre']) && $_SESSION['usuario_nombre'] !== ''): ?>

                        <a href="procesar-pedido.php" class="btn btn-primary w-100">
                            Finalizar compra
                        </a>

                    <?php else: ?>

                        <div class="alert alert-danger py-2 text-center">
                            Debes iniciar sesión para comprar
                        </div>

                        <a href="login.php" class="btn btn-primary w-100">
                            Iniciar sesión
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>
    </div>
    <!-- Scripts requeridos para Bootstrap -->
    <script src="efectos.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>