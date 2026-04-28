<?php
session_start();

// forma PRO
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT id_usuario, nombre, rol, contrasena FROM usuarios WHERE email = ?";
    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($usuario = mysqli_fetch_assoc($resultado)) {

        if (password_verify($password, $usuario['contrasena'])) {

            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];

            header("Location: /");
            exit();

        } else {
            $_SESSION['error_login'] = "Contraseña incorrecta.";
        }

    } else {
        $_SESSION['error_login'] = "Email incorrecto.";
    }

    header("Location: /login");
    exit();
}