<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';

session_start();

// Seguridad: solo admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado");
}

// Validar ID correctamente
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int) $_GET['id'];

    if (eliminarUsuario($conexion, $id)) {

        // REDIRECCIÓN LIMPIA
        header("Location: /gestionar-usuarios?msj=eliminado");
        exit();

    } else {

        // Error controlado
        header("Location: /gestionar-usuarios?error=historial");
        exit();
    }

} else {

    // Si no viene ID válido
    header("Location: /gestionar-usuarios");
    exit();
}