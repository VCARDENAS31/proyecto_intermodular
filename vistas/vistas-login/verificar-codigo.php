<?php
// Inicia la sesión para acceder a variables temporales
session_start();

// ================= VALIDAR SESIÓN TEMPORAL =================
// Verifica que exista información temporal del registro
// Si no existe, significa que el usuario entró manualmente
// a esta página sin registrarse antes
if (!isset($_SESSION['registro_temp'])) {

    // Redirige al formulario de registro
    header("Location: registro");

    // Finaliza la ejecución del script
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <!-- ================= CONFIGURACIÓN GENERAL ================= -->
    <base href="http://viciogames.test">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro | Verificar código</title>

    <!-- ================= ICONO ================= -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">

    <!-- ================= FUENTES Y ESTILOS ================= -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body class="auth">
    <!-- ================= CONTENEDOR PRINCIPAL ================= -->
    <!-- Centra el contenido vertical y horizontalmente -->
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">

        <!-- ================= TARJETA PRINCIPAL ================= -->
        <div class="auth-card">

            <!-- ================= LOGO Y TÍTULO ================= -->
            <div class="auth-logo">

                <!-- Logo de la tienda -->
                <img src="assets/imagenes/logo/logo_tienda.png" class="img-fluid">

                <br><br>

                <!-- Texto descriptivo -->
                <p class="text-light mb-0">
                    Verificación de cuenta
                </p>

            </div>

            <!-- ================= FORMULARIO ================= -->
            <!-- Envía el código a confirmar-registro -->
            <form action="confirmar-registro" method="POST">

                <!-- ================= INPUT CÓDIGO ================= -->
                <div class="mb-3 input-group">

                    <!-- Icono -->
                    <span class="input-group-text">
                        <i class="bi bi-shield-lock"></i>
                    </span>

                    <!-- Campo para introducir el código -->
                    <input type="text"
                        name="codigo"
                        class="form-control-auth form-control"
                        placeholder="Introduce el código"
                        required>

                </div>

                <!-- ================= MENSAJE DE ERROR ================= -->
                <!-- Se muestra si el código introducido es incorrecto -->
                <?php if (isset($_SESSION['error_codigo'])): ?>

                    <div class="alert alert-danger text-center">

                        <?php
                        // Mostrar mensaje de error
                        echo $_SESSION['error_codigo'];

                        // Eliminar mensaje tras mostrarlo
                        unset($_SESSION['error_codigo']);
                        ?>

                    </div>

                <?php endif; ?>

                <!-- ================= BOTONES ================= -->
                <div class="d-grid">

                    <!-- Botón verificar -->
                    <button type="submit" class="btn btn-auth text-white">
                        Verificar código
                    </button>

                    <!-- Botón volver -->
                    <a href="registro" class="btn btn-auth text-white mt-2">
                        Volver
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>