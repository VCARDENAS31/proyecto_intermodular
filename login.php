<?php 
// Inicia la sesión
session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login | VicioGames</title>

    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">

    <!-- Tarjeta de login/registro -->
    <div class="auth-card">

        <!-- Logo y título -->
        <div class="auth-logo">
            <img src="assets/imagenes/logo_tienda.png" class="img-fluid">
            <p class="text-light mt-2">Inicia sesión</p>
        </div>

        <!-- Mensaje de error -->
        <?php if(isset($_SESSION['error_login'])): ?>
            <div style="color: #ff4d4d; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                <?php 
                // Muestra el error de login almacenado en la sesión y luego lo elimina
                echo $_SESSION['error_login']; 
                unset($_SESSION['error_login']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Formulario de inicio de sesión -->
        <form action="autentificacion.php" method="POST">

            <!-- Input de email con icono -->
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>

            <!-- Input de contraseña con icono -->
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>

            <!-- Botón de envío -->
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-auth text-white">Entrar</button>
            </div>
        </form>

        <!-- Enlace a la página de registro -->
        <div class="auth-links">
            <a href="registro.php">¿No tienes cuenta? Crear una cuenta</a>
        </div>

    </div>
</div>

</body>
</html>
