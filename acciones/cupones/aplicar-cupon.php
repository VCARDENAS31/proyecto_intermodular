<?php
// Inicia el archivo PHP para aplicar un cupón en el carrito de compras

session_start();
// Inicia la sesión para acceder a datos del usuario y carrito

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración con constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos MySQL

require_once ROOT_PATH . 'dao/cuponDAO.php';
// Incluye el DAO para operaciones relacionadas con cupones

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON

if (!isset($_SESSION['usuario_id'])) {
    // Verifica si el usuario ha iniciado sesión; si no, sale un mensje de no logueado
    echo json_encode(["ok" => false, "msg" => "No logueado"]);
    exit();
}

$codigo = $_POST['codigo'] ?? '';
// Obtiene el código del cupón enviado por POST, o cadena vacía si no existe

$cupon = obtenerCupon($conexion, $codigo);
// Busca el cupón en la base de datos usando el código proporcionado

if (!$cupon) {
    // Si el cupón no existe, devuelve mensaje de error
    echo json_encode(["ok" => false, "msg" => "Cupón no válido"]);
    exit();
}

if (cuponUsado($conexion, $_SESSION['usuario_id'], $cupon['id_cupon'])) {
    // Verifica si el usuario ya ha usado este cupón; si sí, devuelve error
    echo json_encode(["ok" => false, "msg" => "Ya usaste este cupón"]);
    exit();
}

$_SESSION['cupon'] = $cupon;
// Guarda el cupón aplicado en la sesión del usuario

echo json_encode([
    // Devuelve una respuesta JSON con éxito y el porcentaje de descuento
    "ok" => true,
    "descuento" => $cupon['descuento_porcentaje']
]);