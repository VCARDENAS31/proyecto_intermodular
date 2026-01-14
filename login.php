<?php session_start(); ?>
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
    <div class="auth-card">
        <div class="auth-logo">
            <img src="assets/imagenes/logo_tienda.png" class="img-fluid">
            <p class="text-light mt-2">Inicia sesión</p>
        </div>

        <?php if(isset($_SESSION['error_login'])): ?>
            <div style="color: #ff4d4d; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                <?php echo $_SESSION['error_login']; unset($_SESSION['error_login']); ?>
            </div>
        <?php endif; ?>

        <form action="autentificacion.php" method="POST">
            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-auth text-white">Entrar</button>
            </div>
        </form>

        <div class="auth-links">
            <a href="registro.php">¿No tienes cuenta? Crear una cuenta</a>
        </div>
    </div>
</div>
</body>
</html>