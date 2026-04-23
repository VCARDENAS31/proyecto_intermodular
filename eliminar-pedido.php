<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

// SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    if (eliminarPedido($conexion, $id)) {

        header("Location: actualizar-pedidos.php?status=deleted");
        exit();

    } else {
        echo "Error al eliminar el pedido.";
        echo "<br><a href='actualizar-pedidos.php'>Volver</a>";
    }
}