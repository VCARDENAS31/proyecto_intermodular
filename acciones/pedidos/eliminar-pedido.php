<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/pedidoDAO.php';

// SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// VALIDAR ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = (int) $_GET['id'];

    if (eliminarPedido($conexion, $id)) {

        // REDIRECCIÓN CON MENSAJE
        header("Location: actualizar-pedidos.php?res=deleted");
        exit();

    } else {
        header("Location: actualizar-pedidos.php?res=error");
        exit();
    }

} else {
    header("Location: actualizar-pedidos.php?res=invalid");
    exit();
}