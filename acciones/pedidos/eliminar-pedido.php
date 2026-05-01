<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/pedidoDAO.php';
session_start();

// SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// VALIDAR ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int) $_GET['id'];

    if (eliminarPedido($conexion, $id)) {

        // REDIRECCIÓN CON MENSAJE
        header("Location: /gestionar-pedidos?msj=eliminado");
        exit();

    } else {
        header("Location: /gestionar-pedidos?error=1");
        exit();
    }

} else {
    header("Location: /gestionar-pedidos");
    exit();
}