<?php
include 'conexion-bd.php';
include 'consultas.php';

if (isset($_POST['id_pedido']) && isset($_POST['estado'])) {

    $id = $_POST['id_pedido'];
    $estado = $_POST['estado'];

    actualizarEstadoPedido($conexion, $id, $estado);
}

header("Location: actualizar-pedidos.php");
exit();
?>