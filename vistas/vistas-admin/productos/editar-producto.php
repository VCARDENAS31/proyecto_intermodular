<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: gestionar-productos.php");
    exit();
}

$producto = obtenerProductoPorId($conexion, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Editar Producto</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <div class="contenido-gestion p-4 flex-grow-1 mt-5">
        <div class="row h-100 align-items-center justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="bg-white shadow">
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Producto</h4>
                    </div>

                    <div class="card-body p-3">

                        <form action="actualizar-producto" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $producto['id_producto']; ?>">

                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="<?php echo $producto['nombre']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Precio (€)</label>
                                <input type="number" step="0.01" name="precio" class="form-control"
                                    value="<?php echo $producto['precio']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control"
                                    value="<?php echo $producto['stock']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="4" required><?php echo $producto['descripcion']; ?></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="gestionar-productos.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>