<?php

include 'conexion-bd.php';
include 'consultas.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {

    $id_usuario = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $password = $_POST['password'];

    // 🔴 VALIDACIÓN PASSWORD
    if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{5,}$/', $password)) {
        header("Location: editar-usuario.php?id=$id_usuario&error=pass_corta");
        exit;
    }

    // Si hay contraseña válida
    if (!empty($password)) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $resultado = actualizarUsuarioConPassword(
            $conexion,
            $id_usuario,
            $nombre,
            $apellidos,
            $email,
            $rol,
            $password_hash
        );

    } else {
        // Sin cambiar contraseña
        $resultado = actualizarUsuario(
            $conexion,
            $id_usuario,
            $nombre,
            $apellidos,
            $email,
            $rol
        );
    }

    if ($resultado) {
        header("Location: gestionarUsuarios.php?res=edit_ok");
    } else {
        header("Location: gestionarUsuarios.php?res=error");
    }
}