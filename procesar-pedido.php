<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["ok" => false]);
    exit();
}

if (empty($_SESSION['carrito'])) {
    echo json_encode(["ok" => false]);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$carrito = $_SESSION['carrito'];
$direccion = $_POST['direccion'] ?? 'Sin dirección';

// calcular total
$total = 0;
foreach ($carrito as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

// crear pedido
$id_pedido = crearPedido($conexion, $usuario_id, $carrito, $direccion, $total);

// vaciar carrito
$_SESSION['carrito'] = [];

echo json_encode([
    "ok" => true,
    "pedido_id" => $id_pedido
]);