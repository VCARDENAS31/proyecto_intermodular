<?php
session_start();
include('conexion-bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id_usuario, nombre, rol, contraseña FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // password_verify utilizado para detectar la sal interna
        if (password_verify($password, $usuario['contraseña'])) {
            
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            // Redirección según el rol del usuario
            if ($usuario['rol'] === 'admin') {
                header("Location: index-admin.html");
            } else {
                header("Location: index-user.html");
            }
            exit();
        } else {
            $_SESSION['error_login'] = "Contraseña incorrecta.";
        }
    } else {
        $_SESSION['error_login'] = "Email incorrecto.";
    }
    header("Location: login.php");
    exit();
}
?>