<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/pedidoDAO.php';

if (isset($_POST['id_pedido']) && isset($_POST['estado'])) {

    $id = $_POST['id_pedido'];
    $estado = $_POST['estado'];

    actualizarEstadoPedido($conexion, $id, $estado);
}

header("Location: gestionar-pedidos.php");
exit();
?>