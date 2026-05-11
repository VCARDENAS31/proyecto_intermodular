<?php
// ================= INICIO DE SESIÓN =================
// Iniciamos sesión para poder usar variables $_SESSION
// (necesario para mostrar mensajes de error)
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Registro</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="auth">
    <!-- ================= CONTENEDOR PRINCIPAL CENTRADO ================= -->
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
        
        <!-- ================= TARJETA DE REGISTRO ================= -->
        <div class="auth-card">
            
            <!-- ================= LOGO Y TÍTULO ================= -->
            <div class="auth-logo">
                <img src="assets/imagenes/logo/logo_tienda.png" class="img-fluid">
                <br><br>
                <p class="text-light mb-0">Regístrate</p>
            </div>

            <!-- ================= FORMULARIO DE REGISTRO ================= -->
            <!-- Envía los datos a procesar-registro -->
            <form action="procesar-registro" method="POST">
                
                <!-- ================= CAMPO NOMBRE ================= -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                
                <!-- ================= CAMPO APELLIDOS ================= -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                </div>
                
                <!-- ================= CAMPO EMAIL ================= -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                </div>
                
                <!-- ================= CAMPO CONTRASEÑA ================= -->
                <!-- Incluye validación HTML5 con pattern para requisitos de seguridad -->
                <div class="mb-3 input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required 
                           pattern="^(?=.*[A-Z])(?=.*[\W_]).{5,}$" 
                           title="Debe tener mínimo 5 caracteres, una mayúscula y un carácter especial">
                </div>

                <!-- ================= MENSAJE DE ERROR DE REGISTRO ================= -->
                <!-- Se muestra si existe un error en la sesión -->
                <?php if (isset($_SESSION['error_registro'])): ?>
                    <div style="color: #ff4d4d; text-align: center; margin-bottom: 15px; font-size: 0.9em;">
                        <?php 
                        echo $_SESSION['error_registro'];
                        // Eliminamos el mensaje después de mostrarlo
                        unset($_SESSION['error_registro']);
                        ?>
                    </div>
                <?php endif; ?>

                <!-- ================= BOTÓN DE ENVÍO ================= -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-auth text-white">
                        Crear cuenta
                    </button>
                </div>
            </form>

            <!-- ================= ENLACE A LOGIN ================= -->
            <div class="auth-links">
                <a href="login">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</body>

</html>
