<?php
include 'conexion-bd.php';
include 'consultas.php';

session_start();

// Solo admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado");
}

// FILTROS
$idBuscar = $_GET['buscar'] ?? null;
$estadoFiltro = $_GET['estado'] ?? null;

if (!empty($idBuscar) || !empty($estadoFiltro)) {
    $resultado = buscarPedidosFiltrados($conexion, $idBuscar, $estadoFiltro);
} else {
    $resultado = obtenerPedidosAdmin($conexion);
}

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


            <form method="GET" class="mb-4 row g-2 justify-content-center">

                <!-- BUSCAR POR ID -->
                <div class="col-12 col-md-3">
                    <input type="number" name="buscar" class="form-control" placeholder="ID pedido"
                        value="<?php echo $_GET['buscar'] ?? ''; ?>">
                </div>

                <!-- FILTRAR POR ESTADO -->
                <div class="col-12 col-md-3">
                    <select name="estado" class="form-select">
                        <option value="">-- Estado --</option>

                        <option value="pendiente" <?= (($_GET['estado'] ?? '') == 'pendiente') ? 'selected' : '' ?>>
                            Pendiente
                        </option>

                        <option value="enviado" <?= (($_GET['estado'] ?? '') == 'enviado') ? 'selected' : '' ?>>
                            Enviado
                        </option>

                        <option value="reparto" <?= (($_GET['estado'] ?? '') == 'reparto') ? 'selected' : '' ?>>
                            En reparto
                        </option>

                        <option value="entregado" <?= (($_GET['estado'] ?? '') == 'entregado') ? 'selected' : '' ?>>
                            Entregado
                        </option>
                    </select>
                </div>

                <!-- BOTONES -->
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Buscar
                    </button>

                    <a href="actualizar-pedidos.php" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID pedido</th>
                            <th>ID usuario</th>
                            <th>Cliente</th>
                            <th>Usuario</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Método pago</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (mysqli_num_rows($resultado) == 0): ?>
                            <tr>
                                <td colspan="12">No se encontraron pedidos</td>
                            </tr>
                        <?php endif; ?>
                        <?php
                        $n = 1;
                        while ($pedido = mysqli_fetch_assoc($resultado)):
                            ?>

                            <tr>
                                <td><?php echo $n++; ?></td>

                                <td>#<?php echo $pedido['id_pedido']; ?></td>
                                <td>#<?php echo $pedido['usuario_id']; ?></td>

                                <!-- 🔥 NUEVO: nombre cliente -->
                                <td><?php echo $pedido['nombre_cliente'] ?? '—'; ?></td>

                                <td><?php echo $pedido['nombre_usuario']; ?></td>

                                <!-- PRODUCTOS -->
                                <td>
                                    <?php
                                    $detalles = obtenerDetallesPedido($conexion, $pedido['id_pedido']);
                                    while ($prod = mysqli_fetch_assoc($detalles)) {
                                        echo " - " . $prod['nombre'] . " x" . $prod['cantidad'] . "<br>";
                                    }
                                    ?>
                                </td>

                                <td><?php echo number_format($pedido['total'], 2); ?>€</td>

                                <!-- 🔥 Dirección ya completa -->
                                <td><?php echo $pedido['direccion_envio']; ?></td>

                                <td><?php echo $pedido['telefono']; ?></td>

                                <!-- 🔥 NUEVO: método de pago -->
                                <td>
                                    <?php
                                    if ($pedido['metodo_pago'] == 'tarjeta') {
                                        echo '<span class="badge bg-primary">Tarjeta</span>';
                                    } elseif ($pedido['metodo_pago'] == 'contra') {
                                        echo '<span class="badge bg-secondary">Contra reembolso</span>';
                                    } else {
                                        echo '—';
                                    }
                                    ?>
                                </td>

                                <td><?php echo $pedido['fecha_pedido']; ?></td>

                                <!-- ESTADO (NO TOCADO) -->
                                <td>
                                    <form method="POST" action="cambiar-estado.php">
                                        <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">

                                        <?php
                                        $estado = $pedido['estado'];

                                        $colorEstado = '';
                                        if ($estado == 'pendiente') {
                                            $colorEstado = 'estado-pendiente';
                                        } elseif ($estado == 'enviado') {
                                            $colorEstado = 'estado-enviado';
                                        } elseif ($estado == 'reparto') {
                                            $colorEstado = 'estado-reparto';
                                        } elseif ($estado == 'entregado') {
                                            $colorEstado = 'estado-entregado';
                                        }
                                        ?>

                                        <select name="estado" class="form-select estado-select <?php echo $colorEstado; ?>"
                                            onchange="cambiarColor(this); this.form.submit();">

                                            <option value="pendiente" <?php if ($estado == 'pendiente')
                                                echo 'selected'; ?>>
                                                Pendiente
                                            </option>

                                            <option value="enviado" <?php if ($estado == 'enviado')
                                                echo 'selected'; ?>>
                                                Enviado
                                            </option>

                                            <option value="reparto" <?php if ($estado == 'reparto')
                                                echo 'selected'; ?>>
                                                En reparto
                                            </option>

                                            <option value="entregado" <?php if ($estado == 'entregado')
                                                echo 'selected'; ?>>
                                                Entregado
                                            </option>

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

    <script src="efectos.js"></script>
</body>

</html>