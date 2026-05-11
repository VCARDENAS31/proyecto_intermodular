<?php
// ================= CONFIGURACIÓN E INCLUDES =================
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';

// ================= CONTROL DE SESIÓN Y ACCESO =================
// Iniciamos sesión para leer los datos del usuario logueado
session_start();

// Verificamos permisos de administrador
if (!esAdmin()) {
    accesoDenegado();
}

// ================= LÓGICA DEL BUSCADOR =================
// Comprobamos si se ha realizado una búsqueda por ID
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $idBuscar = $_GET['buscar'];
    // Buscamos usuario específico por ID
    $resultado = buscarUsuarioPorId($conexion, $idBuscar);
} else {
    // Si no hay búsqueda, obtenemos todos los usuarios
    $resultado = obtenerUsuarios($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Gestionar Usuarios</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DEL PANEL DE ADMINISTRACIÓN ================= -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 d-flex justify-content-center align-items-center">
        <div class="container">
            
            <!-- ================= TÍTULO ================= -->
            <h1 class="text-center">Gestionar Usuarios</h1><br>
            
            <!-- ================= BOTÓN AÑADIR USUARIO ================= -->
            <div class="d-flex justify-content-end align-items-center mb-4">
                <a href="anadir-usuario">
                    <button class="btn btn-success shadow-sm">
                        <i class="bi bi-person-plus-fill me-2"></i>Añadir Usuario
                    </button>
                </a>
            </div>

            <!-- ================= FORMULARIO DE BÚSQUEDA ================= -->
            <form method="GET" class="mb-4 d-flex justify-content-center gap-2">
                <!-- Campo para buscar por ID de usuario -->
                <input type="number" name="buscar" class="form-control w-25" placeholder="ID Usuario" value="<?php echo $_GET['buscar'] ?? ''; ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <!-- Botón reset para mostrar todos los usuarios -->
                <a href="gestionar-usuarios" class="btn btn-secondary">
                    Reset
                </a>
            </form>

            <!-- ================= MENSAJES DE FEEDBACK ================= -->
            <!-- Mensaje de usuario eliminado -->
            <?php if (isset($_GET['msj']) && $_GET['msj'] === 'eliminado'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Usuario eliminado correctamente</div>
            <?php endif; ?>

            <!-- Mensaje de usuario creado -->
            <?php if (isset($_GET['res']) && $_GET['res'] == 'ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Usuario creado correctamente
                </div>
            <?php endif; ?>

            <!-- Mensaje de usuario editado -->
            <?php if (isset($_GET['res']) && $_GET['res'] == 'edit_ok'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> Usuario editado correctamente
                </div>
            <?php endif; ?>

            <!-- ================= TABLA DE USUARIOS ================= -->
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered mb-0 text-center align-middle">
                    
                    <!-- Cabecera de la tabla -->
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>             
                            <th>ID</th>             
                            <th>Nombre completo</th>
                            <th>Email</th>          
                            <th>Rol</th>            
                            <th>Acciones</th>       
                        </tr>
                    </thead>
                    
                    <!-- ================= MENSAJE SI NO HAY USUARIOS ================= -->
                    <?php if (mysqli_num_rows($resultado) == 0): ?>
                        <tr>
                            <td colspan="6">No se encontró ningún usuario</td>
                        </tr>
                    <?php endif; ?>

                    <!-- ================= ITERACIÓN SOBRE LOS USUARIOS ================= -->
                    <?php $n = 1; // Contador de filas ?>
                    <?php while ($user = mysqli_fetch_assoc($resultado)): ?>
                        <tbody>
                            <tr>
                                <!-- Número de fila -->
                                <td class="fw-bold">
                                    <?php echo $n++; ?>
                                </td>
                                
                                <!-- ID del usuario -->
                                <td>
                                    <?php echo $user['id_usuario']; ?>
                                </td>
                                
                                <!-- Nombre completo (nombre + apellidos) -->
                                <td>
                                    <?php echo $user['nombre'] . " " . $user['apellidos']; ?>
                                </td>
                                
                                <!-- Email del usuario -->
                                <td>
                                    <?php echo $user['email']; ?>
                                </td>
                                
                                <!-- Rol con badge de color según el tipo -->
                                <td>
                                    <!-- Badge azul para admin, gris para user -->
                                    <span class="badge <?php echo ($user['rol'] == 'admin') ? 'bg-primary' : 'bg-secondary'; ?>">
                                        <?php echo ($user['rol']); ?>
                                    </span>
                                </td>
                                
                                <!-- ================= BOTONES DE ACCIÓN ================= -->
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center gap-3">
                                        <!-- Botón editar -->
                                        <a href="editar-usuario/<?php echo $user['id_usuario']; ?>">
                                            <button class="btn btn-warning btn-sm text-white"><i class="bi bi-pencil-square"></i></button>
                                        </a>
                                        <!-- Botón eliminar con confirmación JS -->
                                        <button class="btn btn-danger btn-sm" onclick="confirmarEliminarUsuario(<?php echo $user['id_usuario']; ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                </table>
            </div>
            <!-- ================= FIN TABLA ================= -->

        </div>
    </div>

    <!-- ================= SCRIPTS ================= -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin/funciones-crud.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>
