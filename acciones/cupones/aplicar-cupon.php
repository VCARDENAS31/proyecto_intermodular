<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . '/dao/conexion-bd.php';
require_once ROOT_PATH . '/dao/productoDAO.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["ok" => false]);
    exit();
}

$codigo = $_POST['codigo'] ?? '';
$cupon = obtenerCupon($conexion, $codigo);

if (!$cupon) {
    echo json_encode(["ok" => false, "msg" => "Cupón no válido"]);
    exit();
}

if (cuponUsado($conexion, $_SESSION['usuario_id'], $cupon['id_cupon'])) {
    echo json_encode(["ok" => false, "msg" => "Ya usaste este cupón"]);
    exit();
}

$_SESSION['cupon'] = $cupon;

echo json_encode([
    "ok" => true,
    "descuento" => $cupon['descuento_porcentaje']
]);