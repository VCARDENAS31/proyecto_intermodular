<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';


//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

//Comprobar si el usuario tiene permiso (debe ser admin)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo mandamos al login o mostramos error
    die("Acceso denegado: No tienes permisos para realizar esta acción.");
}

// BUSCADOR
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $idBuscar = $_GET['buscar'];
    $resultado = buscarProductoPorId($conexion, $idBuscar);
} else {
    $resultado = obtenerProductos($conexion);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8">
    <title>Panel de Administración - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">

            <h1 class="text-center">Gestionar Productos</h1>
            <br>
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-producto" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Añadir producto
                </a>
            </div>
            <form method="GET" class="mb-4 d-flex justify-content-center gap-2">

                <input type="number" name="buscar" class="form-control w-25" placeholder="Buscar producto por ID"
                    value="<?php echo $_GET['buscar'] ?? ''; ?>">

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>

                <a href="gestionar-productos.php" class="btn btn-secondary">
                    Reset
                </a>
            </form>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto añadido correctamente
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['msj']) && $_GET['msj'] == 'eliminado' ): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto eliminado correctamente
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['res']) && $_GET['res'] == 'edit_ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto editado correctamente
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Tipo</th>
                            <th>Categoría</th>
                            <th>Imagen</th>
                            <th>Plataforma</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) == 0): ?>
                            <tr>
                                <td colspan="10">No se encontró ningún producto</td>
                            </tr>
                        <?php endif; ?>
                        <?php
                        $n = 1;
                        while ($producto = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><?php echo $n++; ?></td>
                                <td><?php echo $producto['id_producto']; ?></td>
                                <td><?php echo $producto['nombre']; ?></td>
                                <td><?php echo $producto['precio']; ?>€</td>
                                <td><?php echo $producto['stock']; ?></td>
                                <td><?php echo $producto['tipo']; ?></td>
                                <td><?php echo $producto['categoria']; ?></td>
                                <td><img src="assets/imagenes/<?php echo $producto['img_url']; ?>"
                                        alt="<?php echo $producto['nombre']; ?>" width="80" height="auto"></td>
                                <td><?php echo $producto['plataforma']; ?></td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-3">
                                        <a href="editar-producto/<?php echo $producto['id_producto']; ?>"
                                            class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button class="btn btn-danger btn-sm"
                                            onclick="confirmarEliminarProducto(<?php echo $producto['id_producto']; ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO ================= -->

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin/funciones-crud.js"></script>
    <script src="js/utils/modal.js"></script>
</body>

</html>