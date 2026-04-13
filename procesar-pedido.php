<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

header('Content-Type: application/json');

ini_set('display_errors', 0);
error_reporting(0);

function respuesta($ok, $msg = "", $extra = [])
{
    echo json_encode(array_merge([
        "ok" => $ok,
        "msg" => $msg
    ], $extra));
    exit();
}

if (!isset($_SESSION['usuario_id'])) {
    respuesta(false, "No logueado");
}

if (empty($_SESSION['carrito'])) {
    respuesta(false, "Carrito vacío");
}

$usuario_id = $_SESSION['usuario_id'];
$carrito = $_SESSION['carrito'];

/* 🔥 NUEVOS CAMPOS */
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$cp = $_POST['cp'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$pago = $_POST['pago'] ?? '';

if ($nombre == '' || $apellidos == '' || $direccion == '' || $ciudad == '' || $cp == '' || $telefono == '' || $pago == '') {
    respuesta(false, "Datos incompletos");
}

/* CONCATENAR */
$nombre_completo = $nombre . " " . $apellidos;
$direccion_completa = $direccion . ", " . $ciudad . " (" . $cp . ")";

/* VALIDAR PAGO */
if (!in_array($pago, ['tarjeta', 'contra'])) {
    respuesta(false, "Método de pago inválido");
}

/* TOTAL */
$total = 0;

foreach ($carrito as $producto) {

    $id_producto = $producto['id'] ?? $producto['id_producto'] ?? null;

    if (!$id_producto) {
        respuesta(false, "Producto inválido");
    }

    $stockBD = obtenerStockProducto($conexion, $id_producto);

    if ($producto['cantidad'] > $stockBD) {
        respuesta(false, "Sin stock de " . $producto['nombre']);
    }

    $total += $producto['precio'] * $producto['cantidad'];
}

/* CUPÓN */
$cupon = $_SESSION['cupon'] ?? null;
$descuento = 0;
$cupon_id = null;

if ($cupon) {

    if (usuarioUsoCupon($conexion, $usuario_id, $cupon['id_cupon'])) {
        respuesta(false, "Ya usaste este cupón");
    }

    $descuento = ($total * $cupon['descuento_porcentaje']) / 100;
    $cupon_id = $cupon['id_cupon'];
}

$totalFinal = $total - $descuento + 2.99;

/* CREAR PEDIDO */
$id_pedido = crearPedido(
    $conexion,
    $usuario_id,
    $carrito,
    $direccion_completa,
    $telefono,
    $totalFinal,
    $cupon_id,
    $nombre_completo,
    $pago
);

if (!$id_pedido) {
    respuesta(false, "Error al crear pedido");
}

/* GUARDAR CUPÓN */
if ($cupon_id) {
    guardarUsoCupon($conexion, $usuario_id, $cupon_id);
}

/* LIMPIAR */
$_SESSION['carrito'] = [];
unset($_SESSION['cupon']);

respuesta(true, "Pedido creado", [
    "pedido_id" => $id_pedido
]);