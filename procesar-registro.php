<?php
session_start(); 
include('conexion-bd.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password_plana = $_POST['password'];

    $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, contraseña, nombre, apellidos, rol) VALUES (?, ?, ?, ?, 'user')";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_segura, $nombre, $apellidos);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.php?registro=exito");
        exit();
    } else {
        $_SESSION['error_registro'] = "Error: El correo ya está registrado.";
        header("Location: registro.php");
        exit();
    }
}
?>
