<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: gestionarProductos.php");
    exit();
}

$producto = obtenerProductoPorId($conexion, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<?php include 'header-admin.php'; ?>

<div class="contenido-gestion p-4 flex-grow-1 mt-5">
    <div class="row h-100 align-items-center justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="bg-white shadow">
                <div class="p-3 bg-dark text-white">
                    <h4 class="mb-0">Editar Producto</h4>
                </div>

                <div class="card-body p-3">

                    <form action="actualizar-producto.php" method="POST">

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
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select">
                                <option value="Juego" <?php echo $producto['tipo'] == 'Juego' ? 'selected' : ''; ?>>Juego</option>
                                <option value="Accesorio" <?php echo $producto['tipo'] == 'Accesorio' ? 'selected' : ''; ?>>Accesorio</option>
                                <option value="Consola" <?php echo $producto['tipo'] == 'Consola' ? 'selected' : ''; ?>>Consola</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Categoría</label>
                            <input type="text" name="categoria" class="form-control"
                                value="<?php echo $producto['categoria']; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Plataforma</label>
                            <select name="plataforma" class="form-select">
                                <option value="PS5" <?php echo $producto['plataforma'] == 'PS5' ? 'selected' : ''; ?>>PS5</option>
                                <option value="Xbox" <?php echo $producto['plataforma'] == 'Xbox' ? 'selected' : ''; ?>>Xbox</option>
                                <option value="Switch" <?php echo $producto['plataforma'] == 'Switch' ? 'selected' : ''; ?>>Switch</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Imagen (nombre archivo)</label>
                            <input type="text" name="img_url" class="form-control"
                                value="<?php echo $producto['img_url']; ?>">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="gestionarProductos.php" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<div id="overlaySidebar"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="funciones-crud.js"></script>
<script src="efectos.js"></script>

</body>
</html>