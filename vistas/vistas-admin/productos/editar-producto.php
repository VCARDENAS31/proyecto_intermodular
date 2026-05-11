<?php

// Configuración general, conexión y funciones de productos
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

// Iniciar sesión y comprobar permisos
session_start();

if (!esAdmin()) {
    accesoDenegado();
}

// Obtener producto por ID
$producto = obtenerProductoPorId($conexion, $_GET['id']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Viciogames | Editar Producto</title>

    <!-- Icono y estilos -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- HEADER ADMIN -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 mt-5">

        <div class="row h-100 align-items-center justify-content-center mt-5">

            <div class="col-12 col-md-8 col-lg-6">

                <div class="bg-white shadow">

                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Producto</h4>
                    </div>

                    <div class="card-body p-3">

                        <!-- FORMULARIO -->
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

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">¿Tiene lector?</label>

                                    <select name="tieneLector" class="form-select">

                                        <option value="Sí" <?php echo ($producto['tieneLector'] == 'Sí') ? 'selected' : ''; ?>>
                                            Sí
                                        </option>

                                        <option value="No" <?php echo ($producto['tieneLector'] == 'No') ? 'selected' : ''; ?>>
                                            No
                                        </option>

                                        <option value="" <?php echo empty($producto['tieneLector']) ? 'selected' : ''; ?>>
                                            No aplica
                                        </option>

                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">Almacenamiento</label>

                                    <select name="almacenamiento" class="form-select">

                                        <option value="" <?php echo empty($producto['almacenamiento']) ? 'selected' : ''; ?>>
                                            No aplica
                                        </option>

                                        <option value="32GB" <?php echo ($producto['almacenamiento'] == '32GB') ? 'selected' : ''; ?>>
                                            32GB
                                        </option>

                                        <option value="64GB" <?php echo ($producto['almacenamiento'] == '64GB') ? 'selected' : ''; ?>>
                                            64GB
                                        </option>

                                        <option value="512GB" <?php echo ($producto['almacenamiento'] == '512GB') ? 'selected' : ''; ?>>
                                            512GB
                                        </option>

                                        <option value="825GB" <?php echo ($producto['almacenamiento'] == '825GB') ? 'selected' : ''; ?>>
                                            825GB
                                        </option>

                                        <option value="1TB" <?php echo ($producto['almacenamiento'] == '1TB') ? 'selected' : ''; ?>>
                                            1TB
                                        </option>

                                        <option value="2TB" <?php echo ($producto['almacenamiento'] == '2TB') ? 'selected' : ''; ?>>
                                            2TB
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Descripción</label>

                                <textarea name="descripcion" class="form-control" rows="4"
                                    required><?php echo $producto['descripcion']; ?></textarea>

                            </div>

                            <!-- BOTONES -->
                            <div class="d-flex justify-content-between">

                                <a href="gestionar-productos.php" class="btn btn-secondary">
                                    Cancelar
                                </a>

                                <button type="submit" class="btn btn-success">
                                    Guardar Cambios
                                </button>

                            </div>

                        </form>
                        <!-- ================= FIN FORMULARIO ================= -->

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>

</body>

</html>