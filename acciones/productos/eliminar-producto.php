<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

session_start();

// SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado");
}

// Validar ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int) $_GET['id'];

    if (eliminarProducto($conexion, $id)) {
        header("Location: /gestionar-productos?msj=eliminado");
        exit();
    } else {
        header("Location: /gestionar-productos?error=1");
        exit();
    }

} else {
    header("Location: /gestionar-productos");
    exit();
}