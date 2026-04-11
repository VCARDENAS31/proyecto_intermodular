<?php
include 'conexion-bd.php';
include 'consultas.php';

session_start();

// Solo admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado");
}

$resultado = obtenerPedidosAdmin($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Pedidos</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<?php include 'header-admin.php'; ?>

<div class="contenido-gestion p-4">
    <div class="container">

        <h1 class="text-center mb-4">Gestión de Pedidos</h1>

        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Productos</th>
                        <th>Usuario</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $n = 1;
                while ($pedido = mysqli_fetch_assoc($resultado)):
                ?>

                <tr>
                    <td><?php echo $n++; ?></td>

                    <td>#<?php echo $pedido['id_pedido']; ?></td>

                    <!-- PRODUCTOS -->
                    <td>
                        <?php
                        $detalles = obtenerDetallesPedido($conexion, $pedido['id_pedido']);
                        while ($prod = mysqli_fetch_assoc($detalles)) {
                            echo $prod['nombre'] . " x" . $prod['cantidad'] . "<br>";
                        }
                        ?>
                    </td>

                    <td><?php echo $pedido['nombre_usuario']; ?></td>

                    <td><?php echo number_format($pedido['total'],2); ?>€</td>

                    <td><?php echo $pedido['fecha_pedido']; ?></td>

                    <!-- ESTADO -->
                    <td>
                        <form method="POST" action="cambiar-estado.php">
                            <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">

                            <select name="estado" class="form-select" onchange="this.form.submit()">

                                <option value="recibido" <?php if($pedido['estado']=='recibido') echo 'selected'; ?>>Recibido</option>
                                <option value="procesando" <?php if($pedido['estado']=='procesando') echo 'selected'; ?>>Procesando</option>
                                <option value="enviado" <?php if($pedido['estado']=='enviado') echo 'selected'; ?>>Enviado</option>
                                <option value="cancelado" <?php if($pedido['estado']=='cancelado') echo 'selected'; ?>>Cancelado</option>

                            </select>
                        </form>
                    </td>

                </tr>

                <?php endwhile; ?>

                </tbody>

            </table>
        </div>

    </div>
</div>

</body>
</html>