<?php
// Inicia la sesión
session_start();

// Incluye la conexión a la base de datos
include('conexion-bd.php');

// Verifica que el formulario haya sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtiene y limpia los datos del formulario
    $email = trim($_POST['email']); 
    $password = $_POST['password']; 

    // Consulta SQL para obtener los datos del usuario que coincide con el email
    $sql = "SELECT id_usuario, nombre, rol, contraseña FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $sql);           // Prepara la consulta para evitar inyección SQL
    mysqli_stmt_bind_param($stmt, "s", $email);       // Vincula el parámetro del email
    mysqli_stmt_execute($stmt);                        // Ejecuta la consulta
    $resultado = mysqli_stmt_get_result($stmt);        // Obtiene el resultado de la consulta

    // Verifica la existencia de un usuario con ese email
    if ($usuario = mysqli_fetch_assoc($resultado)) {

        // Compara la contraseña ingresada con la contraseña hasheada en la base de datos
        if (password_verify($password, $usuario['contraseña'])) {
            
            // Guarda datos importantes del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirige según el rol del usuario
            if ($usuario['rol'] === 'admin') {
                header("Location: index-admin.html");   
            } else {
                header("Location: index-user.html");
            }
            exit();

        } else {
            // Mensaje de error si la constraseña es incorrecta
            $_SESSION['error_login'] = "Contraseña incorrecta.";
        }

    } else {
            // Mensaje de error si el correo es incorrecta
        $_SESSION['error_login'] = "Email incorrecto.";
    }

    // Redirige a la página de login mostrando el mensaje de error si hubo fallo
    header("Location: login.php");
    exit();
}
?>
