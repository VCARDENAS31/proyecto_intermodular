<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$pedidos = obtenerPedidosUsuario($conexion, $usuario_id);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <?php include 'header-user.php'; ?>

    <div class="container my-5">

        <h2 class="fw-bold mb-4">Mis pedidos</h2>

        <?php if (mysqli_num_rows($pedidos) > 0): ?>

            <?php while ($pedido = mysqli_fetch_assoc($pedidos)): ?>

                <div class="bg-white mb-4 p-3 shadow-sm border border-primary rounded">

                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>ID Pedido #<?php echo $pedido['id_pedido']; ?></strong><br>
                            <small><?php echo $pedido['fecha_pedido']; ?></small>
                        </div>

                        <div>
                            <strong><?php echo number_format($pedido['total'], 2); ?>€</strong>
                        </div>
                    </div>

                    <p>Estado: <strong><?php echo $pedido['estado']; ?></strong></p>

                    <!-- PRODUCTOS -->
                    <div class="d-flex justify-content-between border-top pt-2">
                        <span>Gastos de envío</span>
                        <span>3,99€</span>
                    </div>
                    <?php
                    $subtotal = 0;
                    $detalles = obtenerDetallesPedido($conexion, $pedido['id_pedido']);

                    while ($prod = mysqli_fetch_assoc($detalles)):
                        $subtotal += $prod['total_linea'];
                        ?>

                        <div class="d-flex justify-content-between border-top pt-2">
                            <span><?php echo $prod['nombre']; ?> x<?php echo $prod['cantidad']; ?></span>
                            <span><?php echo number_format($prod['total_linea'], 2); ?>€</span>
                        </div>

                    <?php endwhile; ?>

                    <?php
                    $envio = 2.99; // mismo que usas en compra
                    $totalPedido = $pedido['total'];

                    // 🔥 calcular descuento automáticamente
                    $descuento = ($subtotal + $envio) - $totalPedido;
                    ?>

                    <div class="d-flex justify-content-between border-top pt-2">
                        <span>Subtotal</span>
                        <span><?php echo number_format($subtotal, 2); ?>€</span>
                    </div>

                    <?php if ($descuento > 0): ?>
                        <div class="d-flex justify-content-between text-success">
                            <span>Descuento</span>
                            <span>-<?php echo number_format($descuento, 2); ?>€</span>
                        </div>
                    <?php endif; ?>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalPedido, 2); ?>€</strong>
                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="alert alert-info">
                No tienes pedidos todavía
            </div>

        <?php endif; ?>

    </div>
    <script src="efectos.js"></script>
</body>

</html>