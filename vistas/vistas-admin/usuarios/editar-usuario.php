<?php
// ================= CONFIGURACIÓN E INCLUDES =================
// Cargamos configuración principal
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Conexión a la base de datos
require_once ROOT_PATH . 'dao/conexion-bd.php';

// Funciones DAO para operaciones con usuarios
require_once ROOT_PATH . 'dao/usuarioDAO.php';

// ================= CONTROL DE SESIÓN Y ACCESO =================
session_start();

// Solo administradores pueden acceder
if (!esAdmin()) {
    accesoDenegado();
}

// ================= OBTENER DATOS DEL USUARIO A EDITAR =================
// Recuperamos el usuario por el ID pasado por GET
$user = obtenerUsuarioPorId($conexion, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Editar Usuario</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DEL PANEL DE ADMINISTRACIÓN ================= -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL - FORMULARIO DE EDICIÓN ================= -->
    <div class="contenido-gestion p-4 flex-grow-1 mt-5">
        <div class="row h-100 align-items-center justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">
                
                <!-- ================= TARJETA DEL FORMULARIO ================= -->
                <div class="bg-white shadow">
                    
                    <!-- Cabecera -->
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Usuario</h4>
                    </div>
                    
                    <div class="card-body p-3">
                        
                        <!-- ================= MENSAJE DE ERROR DE CONTRASEÑA ================= -->
                        <?php if (isset($_GET['error']) && $_GET['error'] == 'pass_corta'): ?>
                            <div class="alert alert-danger">
                                La contraseña debe tener al menos 5 caracteres, una mayúscula y un carácter especial.
                            </div>
                        <?php endif; ?>

                        <!-- Formulario de edición que envía a actualizar-usuario -->
                        <form action="actualizar-usuario" method="POST">
                            
                            <!-- ================= CAMPO OCULTO - ID DEL USUARIO ================= -->
                            <!-- Necesario para identificar qué usuario actualizar -->
                            <input type="hidden" name="id" value="<?php echo $user['id_usuario']; ?>">
                            
                            <!-- ================= CAMPO NOMBRE ================= -->
                            <!-- Precargado con el valor actual del usuario -->
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo $user['nombre']; ?>" required>
                            </div>
                            
                            <!-- ================= CAMPO APELLIDOS ================= -->
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" value="<?php echo $user['apellidos']; ?>" required>
                            </div>
                            
                            <!-- ================= CAMPO EMAIL ================= -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                            </div>
                            
                            <!-- ================= CAMPO CONTRASEÑA (OPCIONAL) ================= -->
                            <!-- Si se deja en blanco, no se modifica la contraseña actual -->
                            <div class="mb-3">
                                <label class="form-label">Contraseña (dejar en blanco para no cambiar)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            
                            <!-- ================= SELECTOR DE ROL ================= -->
                            <!-- Preselecciona el rol actual del usuario -->
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select name="rol" class="form-select">
                                    <!-- Opción user - seleccionada si el rol actual es 'user' -->
                                    <option value="user" <?php echo $user['rol'] == 'user' ? 'selected' : ''; ?>>Usuario Estándar (user)</option>
                                    <!-- Opción admin - seleccionada si el rol actual es 'admin' -->
                                    <option value="admin" <?php echo $user['rol'] == 'admin' ? 'selected' : ''; ?>> Administrador (admin)</option>
                                </select>
                            </div>
                            
                            <!-- ================= BOTONES DE ACCIÓN ================= -->
                            <div class="d-flex justify-content-between">
                                <a href="gestionar-usuarios" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- ================= SCRIPTS ================= -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>
