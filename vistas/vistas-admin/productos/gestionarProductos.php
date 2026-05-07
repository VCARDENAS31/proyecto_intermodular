<?php
// ================= CONFIGURACIÓN E INCLUDES =================
// Cargamos el archivo de configuración principal del proyecto
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Incluimos la conexión a la base de datos
require_once ROOT_PATH . 'dao/conexion-bd.php';

// Incluimos las funciones DAO para operaciones con productos
require_once ROOT_PATH . 'dao/productoDAO.php';

// ================= CONTROL DE SESIÓN Y ACCESO =================
// Iniciamos la sesión para verificar los datos del usuario logueado
session_start();

// Verificamos si el usuario es administrador, si no lo es, denegamos el acceso
if (!esAdmin()) {
    accesoDenegado();
}

// ================= LÓGICA DEL BUSCADOR =================
// Comprobamos si se ha enviado un parámetro de búsqueda por GET
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    // Obtenemos el ID a buscar
    $idBuscar = $_GET['buscar'];
    // Buscamos el producto específico por su ID
    $resultado = buscarProductoPorId($conexion, $idBuscar);
} else {
    // Si no hay búsqueda, obtenemos todos los productos
    $resultado = obtenerProductos($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <!-- URL base para rutas relativas -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Gestionar Productos</title>
    
    <!-- Favicon de la página -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DEL PANEL DE ADMINISTRACIÓN ================= -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">
            
            <!-- ================= TÍTULO DE LA PÁGINA ================= -->
            <h1 class="text-center">Gestionar Productos</h1>
            <br>
            
            <!-- ================= BOTÓN AÑADIR PRODUCTO ================= -->
            <!-- Enlace para acceder al formulario de creación de nuevo producto -->
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-producto" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Añadir producto
                </a>
            </div>

            <!-- ================= FORMULARIO DE BÚSQUEDA ================= -->
            <!-- Permite buscar productos por su ID -->
            <form method="GET" class="mb-4 d-flex justify-content-center gap-2">
                <!-- Campo de entrada para el ID del producto -->
                <input type="number" name="buscar" class="form-control w-25" placeholder="ID Producto" value="<?php echo $_GET['buscar'] ?? ''; ?>">
                <!-- Botón de búsqueda -->
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <!-- Botón para resetear la búsqueda y mostrar todos los productos -->
                <a href="gestionar-productos" class="btn btn-secondary">
                    Reset
                </a>
            </form>

            <!-- ================= MENSAJES DE FEEDBACK AL USUARIO ================= -->
            <!-- Mensaje de éxito al añadir producto -->
            <?php if (isset($_GET['res']) && $_GET['res'] == 'ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto añadido correctamente
                </div>
            <?php endif; ?>

            <!-- Mensaje de éxito al eliminar producto -->
            <?php if (isset($_GET['msj']) && $_GET['msj'] == 'eliminado'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto eliminado correctamente
                </div>
            <?php endif; ?>

            <!-- Mensaje de éxito al editar producto -->
            <?php if (isset($_GET['res']) && $_GET['res'] == 'edit_ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Producto editado correctamente
                </div>
            <?php endif; ?>

            <!-- ================= TABLA DE PRODUCTOS ================= -->
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">
                    
                    <!-- Cabecera de la tabla con las columnas -->
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
                        <!-- ================= MENSAJE SI NO HAY PRODUCTOS ================= -->
                        <?php if (mysqli_num_rows($resultado) == 0): ?>
                            <tr>
                                <td colspan="10">No se encontró ningún producto</td>
                            </tr>
                        <?php endif; ?>

                        <!-- ================= ITERACIÓN SOBRE LOS PRODUCTOS ================= -->
                        <?php $n = 1; // Contador para numerar las filas ?>
                        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <!-- Número de fila (contador) -->
                                <td><?php echo $n++; ?></td>
                                
                                <!-- ID del producto -->
                                <td><?php echo $producto['id_producto']; ?></td>
                                
                                <!-- Nombre del producto -->
                                <td><?php echo $producto['nombre']; ?></td>
                                
                                <!-- Precio con símbolo de euro -->
                                <td><?php echo $producto['precio']; ?>€</td>
                                
                                <!-- Stock disponible -->
                                <td><?php echo $producto['stock']; ?></td>
                                
                                <!-- Tipo de producto -->
                                <td><?php echo $producto['tipo']; ?></td>
                                
                                <!-- Categoría -->
                                <td><?php echo $producto['categoria']; ?></td>
                                
                                <!-- Imagen en miniatura del producto -->
                                <td><img src="assets/imagenes/<?php echo $producto['img_url']; ?>" alt="<?php echo $producto['nombre']; ?>" width="80" height="auto"></td>
                                
                                <!-- Plataforma del producto -->
                                <td><?php echo $producto['plataforma']; ?></td>
                                
                                <!-- ================= BOTONES DE ACCIÓN ================= -->
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-3">
                                        <!-- Botón para editar el producto -->
                                        <a href="editar-producto/<?php echo $producto['id_producto']; ?>" class="btn btn-warning btn-sm text-white">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <!-- Botón para eliminar el producto (llama a función JS de confirmación) -->
                                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminarProducto(<?php echo $producto['id_producto']; ?>)">
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
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    </div>

    <!-- ================= SCRIPTS ================= -->
    <!-- Bootstrap JS para componentes interactivos -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Funciones CRUD para administración (eliminar, etc.) -->
    <script src="js/admin/funciones-crud.js"></script>
    <!-- Utilidades para modales -->
    <script src="js/utils/modal.js"></script>
    <!-- Control del sidebar -->
    <script src="js/ui/sidebar.js"></script>
    <!-- Funcionalidad de logout -->
    <script src="js/usuario/logout.js"></script>
</body>

</html>
