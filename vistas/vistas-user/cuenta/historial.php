<?php
/* ============================================================
   HISTORIAL.PHP
   Página que muestra el historial de pedidos del usuario logueado.
   ============================================================ */
/* ------------------------------------------------------------
   INICIALIZACIÓN DE SESIÓN
   Arranca la sesión para acceder a las variables de sesión
   (usuario_id, carrito, etc.).
   ------------------------------------------------------------ */
session_start();
/* ------------------------------------------------------------
   CARGA DE CONFIGURACIÓN Y DAOs
   - config.php: constantes globales (ROOT_PATH, rutas, helpers).
   - conexion-bd.php: conexión mysqli a la base de datos.
   - pedidoDAO.php: funciones para consultar pedidos y detalles.
   ------------------------------------------------------------ */
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/pedidoDAO.php';
/* ------------------------------------------------------------
   CONTROL DE ACCESO
   Si el usuario no ha iniciado sesión se le redirige al login.
   ------------------------------------------------------------ */
if (!usuarioLogueado()) {
    redirigir('login');
}
/* ------------------------------------------------------------
   OBTENCIÓN DE PEDIDOS
   Recupera todos los pedidos asociados al usuario actual.
   ------------------------------------------------------------ */
$usuario_id = $_SESSION['usuario_id'];
$pedidos = obtenerPedidosUsuario($conexion, $usuario_id);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- ========== META Y BASE ========== -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis pedidos</title>
    <!-- ========== FAVICON ========== -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <!-- ========== FUENTES Y ESTILOS ========== -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- ========== CABECERA DE USUARIO ========== -->
    <?php include ROOT_PATH . 'includes/header-user.php'; ?>
    <div class="container my-5">
        <!-- ========== TÍTULO DE LA PÁGINA ========== -->
        <h2 class="fw-bold mb-4">Mis pedidos</h2>
        <!-- ========== LISTADO DE PEDIDOS ========== -->
        <?php if (mysqli_num_rows($pedidos) > 0): ?>
            <?php while ($pedido = mysqli_fetch_assoc($pedidos)): ?>
                <!-- ===== TARJETA DE UN PEDIDO ===== -->
                <div class="bg-white mb-4 p-3 shadow-sm border border-primary rounded">
                    <!-- ENCABEZADO: ID, fecha y total -->
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>ID Pedido #<?php echo $pedido['id_pedido']; ?></strong><br>
                            <small><?php echo $pedido['fecha_pedido']; ?></small>
                        </div>
                        <div>
                            <strong><?php echo number_format($pedido['total'], 2); ?>€</strong>
                        </div>
                    </div>
                    <!-- ESTADO DEL PEDIDO -->
                    <p>Estado: <strong><?php echo $pedido['estado']; ?></strong></p>
                    <!-- ===== DESGLOSE DE PRODUCTOS ===== -->
                    <!-- Gastos de envío fijos -->
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span>Gastos de envío</span>
                        <span>2,99€</span>
                    </div>
                    <?php
                    /* --------------------------------------------------------
                       OBTENCIÓN DE LÍNEAS DEL PEDIDO
                       Se recuperan los productos (detalles) de este pedido
                       y se acumula el subtotal de artículos.
                       -------------------------------------------------------- */
                    $subtotal = 0;
                    $detalles = obtenerDetallesPedido($conexion, $pedido['id_pedido']);
                    while ($prod = mysqli_fetch_assoc($detalles)):
                        $subtotal += $prod['total_linea'];
                        ?>
                        <!-- Línea de producto -->
                        <div class="d-flex justify-content-between border-top pt-2">
                            <span><?php echo $prod['nombre']; ?> x<?php echo $prod['cantidad']; ?></span>
                            <span><?php echo number_format($prod['total_linea'], 2); ?>€</span>
                        </div>
                    <?php endwhile; ?>
                    <?php
                    /* --------------------------------------------------------
                       CÁLCULO DEL DESCUENTO
                       Se suma el envío al subtotal de productos y se compara
                       con el total almacenado para deducir el descuento
                       aplicado en su momento.
                       -------------------------------------------------------- */
                    $envio = 2.99; // mismo valor que en el checkout
                    $totalPedido = $pedido['total'];
                    $subtotal += $envio;
                    $descuento = $subtotal - $totalPedido;
                    ?>
                    <!-- Subtotal (productos + envío) -->
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span>Subtotal</span>
                        <span><?php echo number_format($subtotal, 2); ?>€</span>
                    </div>
                    <!-- Descuento (solo si lo hubo) -->
                    <?php if ($descuento > 0): ?>
                        <div class="d-flex justify-content-between text-success">
                            <span>Descuento</span>
                            <span>-<?php echo number_format($descuento, 2); ?>€</span>
                        </div>
                    <?php endif; ?>
                    <hr>
                    <!-- Total final del pedido -->
                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalPedido, 2); ?>€</strong>
                    </div>
                </div>
                <!-- FIN tarjeta pedido -->
            <?php endwhile; ?>
        <?php else: ?>
            <!-- ===== MENSAJE CUANDO NO HAY PEDIDOS ===== -->
            <div class="alert alert-info">
                No tienes pedidos todavía
            </div>
        <?php endif; ?>
    </div>
    <!-- ========== SCRIPTS ========== -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/ui/submenu.js"></script>
    <script src="js/carrito/carrito-ui.js"></script>
    <script src="js/carrito/carrito-api.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>
</html>