<?php
include 'conexion-bd.php';
include 'consultas.php';

//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

//Comprobar si el usuario tiene permiso (debe ser admin)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo mandamos al login o mostramos error
    die("Acceso denegado: No tienes permisos para realizar esta acción.");
}

$resultado = obtenerProductos($conexion); // Llamamos a la función
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica -->
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

    <?php include 'header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">

            <h1 class="text-center">Gestionar Productos</h1>
            <br>
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-producto.php" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Añadir producto
                </a>
            </div>


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
                                        <a href="editar-producto.php?id=<?php echo $producto['id_producto']; ?>"
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

    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
    <script src="efectos.js"></script>
</body>

</html>