<?php

// Incluye archivos necesarios
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/pedidoDAO.php';

// Inicia la sesión
session_start();

// Comprueba permisos de administrador
if (!esAdmin()) {
    accesoDenegado();
}

// ================= FILTROS =================

// Buscar por ID
$idBuscar = $_GET['buscar'] ?? null;

// Filtrar por estado
$estadoFiltro = $_GET['estado'] ?? null;

// Si hay filtros, busca pedidos filtrados
if (!empty($idBuscar) || !empty($estadoFiltro)) {

    $resultado = buscarPedidosFiltrados($conexion, $idBuscar, $estadoFiltro);

} else {

    // Si no hay filtros, obtiene todos los pedidos
    $resultado = obtenerPedidosAdmin($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- Base de rutas -->
    <base href="http://viciogames.test">

    <!-- Configuración -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Título y favicon -->
    <title>Viciogames | Gestionar Pedidos</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- Fuentes e iconos -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Header administrador -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- Contenido principal -->
    <div class="contenido-gestion p-4">

        <div class="container">

            <!-- Título -->
            <h1 class="text-center mb-4">Gestión de Pedidos</h1>

            <!-- Formulario filtros -->
            <form method="GET" class="mb-4 row g-2 justify-content-center">

                <!-- Buscar por ID -->
                <div class="col-12 col-md-3">

                    <input type="number" name="buscar" class="form-control"
                        placeholder="ID pedido"
                        value="<?php echo $_GET['buscar'] ?? ''; ?>">

                </div>

                <!-- Filtrar por estado -->
                <div class="col-12 col-md-3">

                    <select name="estado" class="form-select">

                        <option value="">-- Estado --</option>

                        <option value="pendiente"
                            <?= (($_GET['estado'] ?? '') == 'pendiente') ? 'selected' : '' ?>>
                            Pendiente
                        </option>

                        <option value="enviado"
                            <?= (($_GET['estado'] ?? '') == 'enviado') ? 'selected' : '' ?>>
                            Enviado
                        </option>

                        <option value="reparto"
                            <?= (($_GET['estado'] ?? '') == 'reparto') ? 'selected' : '' ?>>
                            En reparto
                        </option>

                        <option value="entregado"
                            <?= (($_GET['estado'] ?? '') == 'entregado') ? 'selected' : '' ?>>
                            Entregado
                        </option>

                    </select>

                </div>

                <!-- Botones -->
                <div class="col-12 col-md-3 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i>
                    </button>

                    <a href="gestionar-pedidos" class="btn btn-secondary">
                        Reset
                    </a>

                </div>

            </form>

            <!-- Mensajes -->
            <?php if (isset($_GET['msj'])): ?>

                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Pedido eliminado correctamente
                </div>

            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>

                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> Error al eliminar el pedido
                </div>

            <?php endif; ?>

            <!-- Tabla -->
            <div class="table-responsive">

                <table class="table table-bordered text-center align-middle">

                    <!-- Cabecera -->
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
                            <th>Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        <!-- Si no hay pedidos -->
                        <?php if (mysqli_num_rows($resultado) == 0): ?>

                            <tr>
                                <td colspan="13">No se encontraron pedidos</td>
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

                                <!-- Nombre cliente -->
                                <td><?php echo $pedido['nombre_cliente'] ?? '—'; ?></td>

                                <!-- Usuario -->
                                <td><?php echo $pedido['nombre_usuario']; ?></td>

                                <!-- Productos -->
                                <td>

                                    <?php
                                    $detalles = obtenerDetallesPedido($conexion, $pedido['id_pedido']);

                                    while ($prod = mysqli_fetch_assoc($detalles)) {

                                        echo " - " . $prod['nombre'] . " x" . $prod['cantidad'] . "<br>";
                                    }
                                    ?>

                                </td>

                                <!-- Total -->
                                <td><?php echo number_format($pedido['total'], 2); ?>€</td>

                                <!-- Dirección -->
                                <td><?php echo $pedido['direccion_envio']; ?></td>

                                <!-- Teléfono -->
                                <td><?php echo $pedido['telefono']; ?></td>

                                <!-- Método pago -->
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

                                <!-- Fecha -->
                                <td><?php echo $pedido['fecha_pedido']; ?></td>

                                <!-- Estado -->
                                <td>

                                    <form method="POST" action="cambiar-estado">

                                        <input type="hidden" name="id_pedido"
                                            value="<?php echo $pedido['id_pedido']; ?>">

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

                                        <select name="estado"
                                            class="form-select estado-select <?php echo $colorEstado; ?>"
                                            onchange="cambiarColor(this); this.form.submit();">

                                            <option value="pendiente"
                                                <?php if ($estado == 'pendiente') echo 'selected'; ?>>
                                                Pendiente
                                            </option>

                                            <option value="enviado"
                                                <?php if ($estado == 'enviado') echo 'selected'; ?>>
                                                Enviado
                                            </option>

                                            <option value="reparto"
                                                <?php if ($estado == 'reparto') echo 'selected'; ?>>
                                                En reparto
                                            </option>

                                            <option value="entregado"
                                                <?php if ($estado == 'entregado') echo 'selected'; ?>>
                                                Entregado
                                            </option>

                                        </select>

                                    </form>

                                </td>

                                <!-- Eliminar -->
                                <td>

                                    <button class="btn btn-danger btn-sm"
                                        onclick="confirmarEliminarPedido(<?php echo $pedido['id_pedido']; ?>)">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Funciones CRUD -->
    <script src="js/admin/funciones-crud.js"></script>

    <!-- Cambiar color estado -->
    <script src="js/ui/estado.js"></script>

    <!-- Modal -->
    <script src="js/utils/modal.js"></script>

    <!-- Sidebar -->
    <script src="js/ui/sidebar.js"></script>

    <!-- Logout -->
    <script src="js/usuario/logout.js"></script>

</body>

</html>