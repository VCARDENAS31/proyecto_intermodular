<?php
// ================= INICIO DE SESIÓN =================
// Iniciamos la sesión para poder usar variables $_SESSION
// (necesario para mostrar mensajes de error/éxito)
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Login</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth">
    <!-- ================= CONTENEDOR PRINCIPAL CENTRADO ================= -->
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">

        <!-- ================= TARJETA DE LOGIN ================= -->
        <div class="auth-card">

            <!-- ================= LOGO Y TÍTULO ================= -->
            <div class="auth-logo">
                <img src="assets/imagenes/logo/logo_tienda.png" class="img-fluid">
                <p class="text-light mt-4">Inicia sesión</p>
            </div>

            <!-- ================= MENSAJE DE ERROR DE LOGIN ================= -->
            <!-- Se muestra si existe un error almacenado en la sesión -->
            <?php if (isset($_SESSION['error_login'])): ?>
                <div style="color: #ff4d4d; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                    <?php
                    // Mostramos el error y lo eliminamos de la sesión
                    echo $_SESSION['error_login'];
                    unset($_SESSION['error_login']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- ================= MENSAJE DE ÉXITO DE REGISTRO ================= -->
            <!-- Se muestra cuando el usuario acaba de registrarse exitosamente -->
            <?php if (isset($_SESSION['exito_registro'])): ?>
                <div style="color: #4CAF50; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                    <?php
                    echo $_SESSION['exito_registro'];
                    unset($_SESSION['exito_registro']);
                    ?>
                </div>
            <?php endif; ?>

            <!-- ================= FORMULARIO DE LOGIN ================= -->
            <!-- Envía los datos a la página de autentificación -->
            <form action="autentificacion" method="POST">

                <!-- ================= CAMPO EMAIL CON ICONO ================= -->
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>

                <!-- ================= CAMPO CONTRASEÑA CON ICONO ================= -->
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>

                <!-- ================= BOTÓN DE ENVÍO ================= -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-auth text-white">Entrar</button>
                </div>
            </form>

            <!-- ================= ENLACE A REGISTRO ================= -->
            <div class="auth-links">
                <a href="registro">¿No tienes cuenta? Crear una cuenta</a>
            </div>
        </div>
    </div>
</body>

</html>