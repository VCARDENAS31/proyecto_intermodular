<?php
// Iniciar sesión para poder usar variables $_SESSION
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | VicioGames</title>

    <link rel="stylesheet" href="css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/auth.css">
</head>

<body>

    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        <div class="auth-card">

            <!-- Logo y título del formulario -->
            <div class="auth-logo">
                <img src="assets/imagenes/logo_tienda.png" class="img-fluid">
                <br><br>
                <p class="text-light mb-0">Regístrate</p>
            </div>

            <!-- Formulario de registro -->
            <form action="procesar-registro.php" method="POST">

                <!-- Campo nombre -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>

                <!-- Campo apellidos -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                </div>

                <!-- Campo email -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>

                <!-- Campo contraseña -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>

                <!-- Muestra mensaje de error si existe en la sesión -->
                <?php if (isset($_SESSION['error_registro'])): ?>
                    <div style="color: #ff4d4d; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                        <?php
                        echo $_SESSION['error_registro'];
                        unset($_SESSION['error_registro']);
                        ?>
                    </div>
                <?php endif; ?>

                <!-- Botón para enviar el formulario -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-auth text-white">
                        Crear cuenta
                    </button>
                </div>
            </form>

            <!-- Enlace para ir a la página de login -->
            <div class="auth-links">
                <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
            </div>

        </div>
    </div>

</body>

</html>