<?php
// ================= CONFIGURACIÓN E INCLUDES =================
// Cargamos el archivo de configuración principal del proyecto
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// ================= CONTROL DE SESIÓN Y ACCESO =================
// Iniciamos sesión para verificar permisos
session_start();

// Verificamos que el usuario sea administrador
if (!esAdmin()) {
    accesoDenegado();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Añadir Usuario</title>
    
    <!-- Favicon -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DEL PANEL DE ADMINISTRACIÓN ================= -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <!-- ================= CONTENIDO PRINCIPAL - FORMULARIO ================= -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 mt-5">
                
                <!-- ================= TARJETA DEL FORMULARIO ================= -->
                <div class="shadow bg-white mt-5">
                    
                    <!-- Cabecera de la tarjeta -->
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Nuevo Usuario</h4>
                    </div>
                    
                    <!-- Cuerpo del formulario -->
                    <div class="p-3 card-body">
                        <!-- Formulario que envía datos a insertar-usuario -->
                        <form action="insertar-usuario" method="POST">
                            
                            <!-- ================= CAMPO NOMBRE ================= -->
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            
                            <!-- ================= CAMPO APELLIDOS ================= -->
                            <div class="mb-3">
                                <label class="form-label">Apellidos</label>
                                <input type="text" name="apellidos" class="form-control" required>
                            </div>
                            
                            <!-- ================= CAMPO EMAIL ================= -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <!-- ================= CAMPO CONTRASEÑA ================= -->
                            <!-- Incluye requisitos de seguridad en la etiqueta -->
                            <div class="mb-3">
                                <label class="form-label">Contraseña (mínimo 5 caracteres, con mayúscula y símbolo)</label>
                                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                            </div>
                            
                            <!-- ================= SELECTOR DE ROL ================= -->
                            <div class="mb-3">
                                <label class="form-label">Rol de Usuario</label>
                                <select name="rol" class="form-select">
                                    <option value="user">Usuario Estándar (user)</option>
                                    <option value="admin">Administrador (admin)</option>
                                </select>
                            </div>

                            <!-- ================= MENSAJES DE ERROR ================= -->
                            <?php if (isset($_GET['error'])): ?>
                                
                                <!-- Error de contraseña inválida -->
                                <?php if ($_GET['error'] == 'pass'): ?>
                                    <div class="alert alert-danger">
                                        La contraseña debe tener mayúscula, símbolo y mínimo 5 caracteres
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Error de email ya registrado -->
                                <?php if ($_GET['error'] == 'email'): ?>
                                    <div class="alert alert-danger">
                                        El email ya está registrado
                                    </div>
                                <?php endif; ?>
                                
                            <?php endif; ?>

                            <!-- ================= BOTONES DE ACCIÓN ================= -->
                            <div class="d-flex justify-content-between">
                                <!-- Botón cancelar - vuelve a la lista de usuarios -->
                                <a href="gestionar-usuarios" class="btn btn-secondary">Cancelar</a>
                                <!-- Botón guardar - envía el formulario -->
                                <button type="submit" class="btn btn-success">Guardar Usuario</button>
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
