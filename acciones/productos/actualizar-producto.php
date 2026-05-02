<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

// 🔒 Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// =========================
//  DATOS
// =========================
$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$stock = $_POST['stock'] ?? 0;
$descripcion = $_POST['descripcion'] ?? '';

// =========================
// VALIDAR PRODUCTO
// =========================
$producto = obtenerProductoPorId($conexion, $id);

if (!$producto) {
    die("Producto no encontrado.");
}

// =========================
//  ACTUALIZAR
// =========================
$resultado = actualizarProducto(
    $conexion,
    $id,
    $nombre,
    $precio,
    $stock,
    $descripcion
);

// =========================
// REDIRECCIÓN
// =========================
if ($resultado) {
    header("Location: gestionar-productos?res=edit_ok");
} else {
    header("Location: gestionar-productos?res=error");
}

exit();