<?php

// Incluir archivos necesarios
include 'conexion-bd.php';
include 'consultas.php';

// Iniciar sesión
session_start();

// Comprobar que:
// 1. La petición sea POST (se envió un formulario)
// 2. El usuario tenga rol de administrador
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] === 'admin') {

    // Guardar los datos recibidos del formulario
    $id_usuario = $_POST['id_usuario'];
    $nombre     = $_POST['nombre'];
    $apellidos  = $_POST['apellidos'];
    $email      = $_POST['email'];
    $rol        = $_POST['rol'];

    // Llamar a la función que actualiza el usuario en la base de datos
    $resultado = actualizarUsuario(
        $conexion,
        $id_usuario,
        $nombre,
        $apellidos,
        $email,
        $rol
    );

    // Redirigir según el resultado
    if ($resultado) {
        header("Location: gestionarUsuarios.php?res=edit_ok");
    } else {
        header("Location: gestionarUsuarios.php?res=error");
    }
}
?>