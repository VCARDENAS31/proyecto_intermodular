<?php
/* ============================================================
   ENVIO-PAGO.PHP (checkout.php)
   Paso 2 del checkout: formulario de envío, método de pago
   y confirmación del pedido.
   ============================================================ */
/* ------------------------------------------------------------
   INICIALIZACIÓN DE SESIÓN
   ------------------------------------------------------------ */
session_start();
/* ------------------------------------------------------------
   VALIDACIONES PREVIAS
   - Carrito vacío → redirige al inicio.
   - Usuario no logueado → redirige al login.
   ------------------------------------------------------------ */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

if (empty($_SESSION['carrito'])) {
    header("Location: /");
    exit();
}
if (!usuarioLogueado()) {
    redirigir('login');
}
/* ------------------------------------------------------------
   CÁLCULO DEL TOTAL DE PRODUCTOS
   ------------------------------------------------------------ */
$total = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}
/* ------------------------------------------------------------
   CUPÓN Y DESCUENTO
   ------------------------------------------------------------ */
$cupon = $_SESSION['cupon'] ?? null;
$descuento = 0;
if ($cupon) {
    $descuento = ($total * $cupon['descuento_porcentaje']) / 100;
}
/* ------------------------------------------------------------
   TOTAL FINAL (productos − descuento + envío)
   ------------------------------------------------------------ */
$totalFinal = $total - $descuento + 2.99;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========== META Y BASE ========== -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Envío y Pago</title>
    <!-- ========== ESTILOS ========== -->
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- ========== BARRA DE NAVEGACIÓN DEL CHECKOUT ========== -->
    <div class="checkout-nav py-3 px-4 d-flex justify-content-between align-items-center">
        <a href="/">
            <div class="logo-checkout">
                <img src="assets/imagenes/logo/logo_tienda.png" height="40">
            </div>
        </a>
        <!-- Indicador de pasos (Paso 2 activo) -->
        <div class="checkout-steps d-flex align-items-center gap-3">
            <div class="step">
                <span>1</span>
                <p>Cesta</p>
            </div>
            <div class="line"></div>
            <div class="step active">
                <span>2</span>
                <p>Envío y Pago</p>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row">
            <!-- ===================================================
                 COLUMNA IZQUIERDA: FORMULARIO DE ENVÍO Y PAGO
                 =================================================== -->
            <div class="col-lg-8">
                <div class="p-4 bg-white shadow-sm rounded mb-4">
                    <!-- ===== DATOS DE ENVÍO ===== -->
                    <h4 class="fw-bold mb-3">Datos de envío</h4>
                    <form id="formCompra">
                        <!-- Nombre y Apellidos -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Nombre" name="nombre"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo letras" required>
                            </div>
                        </div>
                        <!-- Dirección -->
                        <div class="mb-3">
                            <input type="text" name="direccion" class="form-control" placeholder="Dirección" required>
                        </div>
                        <!-- Ciudad y Código Postal -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="ciudad" class="form-control" placeholder="Ciudad" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" name="cp" class="form-control" placeholder="Código Postal"
                                    pattern="[0-9]{5}" title="Debe tener 5 números" required>
                            </div>
                        </div>
                        <!-- Teléfono -->
                        <div class="mb-4">
                            <input type="text" name="telefono" class="form-control" placeholder="Teléfono"
                                pattern="[69][0-9]{8}" title="Debe tener 9 números y empezar por 6 o 9" required>
                        </div>
                        <!-- ===== MÉTODO DE PAGO ===== -->
                        <h4 class="fw-bold mb-3">Método de pago</h4>
                        <!-- Opción Tarjeta -->
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pago" value="tarjeta" checked
                                onclick="toggleTarjeta(true)">
                            <label class="form-check-label">
                                <i class="bi bi-credit-card"></i> Tarjeta
                            </label>
                        </div>
                        <!-- Campos de tarjeta (visibles por defecto) -->
                        <div id="camposTarjeta">
                            <div class="mb-3">
                                <input type="text" id="tarjeta" class="form-control" placeholder="Número de tarjeta"
                                    pattern="[0-9]{16}" title="16 números">
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <input type="text" id="fecha" class="form-control" placeholder="MM/AA"
                                        pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Formato MM/AA">
                                    <!-- Mensaje de error si la tarjeta está caducada -->
                                    <small id="errorFecha" class="text-danger" style="display: none;">
                                        La tarjeta está caducada
                                    </small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" id="cvv" class="form-control" placeholder="CVV"
                                        pattern="[0-9]{3}" title="3 números">
                                </div>
                            </div>
                        </div>
                        <!-- Opción Contra reembolso -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="pago" value="contra"
                                onclick="toggleTarjeta(false)">
                            <label class="form-check-label">
                                <i class="bi bi-cash"></i> Contra reembolso
                            </label>
                        </div>
                        <!-- Botón de confirmación -->
                        <button type="submit" class="btn btn-primary w-100">
                            Confirmar pedido
                        </button>
                    </form>
                </div>
            </div>
            <!-- FIN columna izquierda -->
            <!-- ===================================================
                 COLUMNA DERECHA: RESUMEN DEL PEDIDO
                 =================================================== -->
            <div class="col-lg-4">
                <div class="p-4 shadow-sm bg-white rounded">
                    <h4 class="fw-bold mb-3">Resumen</h4>
                    <!-- Listado de productos -->
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo $producto['nombre']; ?> x<?php echo $producto['cantidad']; ?></span>
                            <span><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>€</span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span><?php echo number_format($total, 2); ?>€</span>
                    </div>
                    <!-- Descuento (si hay) -->
                    <?php if ($descuento > 0): ?>
                        <div class="d-flex justify-content-between text-success">
                            <span>Descuento</span>
                            <span>-<?php echo number_format($descuento, 2); ?>€</span>
                        </div>
                    <?php endif; ?>
                    <!-- Envío -->
                    <div class="d-flex justify-content-between">
                        <span>Envío (no aplica para el descuento)</span>
                        <span>2,99€</span>
                    </div>
                    <hr>
                    <!-- Total final -->
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalFinal, 2); ?>€</strong>
                    </div>
                </div>
            </div>
            <!-- FIN columna derecha -->
        </div>
    </div>
    <!-- ========== MODAL DE COMPRA REALIZADA ========== -->
    <div id="modalCompra" class="modal-compra">
        <div class="modal-box">
            <div class="check">✔</div>
            <h3>Compra realizada</h3>
            <p>Tu pedido se ha procesado correctamente</p>
            <div class="botones">
                <a href="historial" class="btn btn-primary">Ver mis pedidos</a>
                <a href="/" class="btn btn-secondary">Ir al inicio</a>
            </div>
        </div>
    </div>
    <!-- ========== SCRIPTS ========== -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/pago/pago.js"></script>
    <script src="js/pago/tarjeta.js"></script>
    <script src="js/pago/checkout.js"></script>
    <script src="js/cupon/cupon.js"></script>
</body>
</html>