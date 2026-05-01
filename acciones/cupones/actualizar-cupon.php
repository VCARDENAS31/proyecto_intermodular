<?php

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';


// Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// Datos
$id = $_POST['id'] ?? null;
$codigo = $_POST['codigo'] ?? '';
$descuento = $_POST['descuento'] ?? 0;
$fecha = $_POST['fecha'] ?? '';
$activo = $_POST['activo'] ?? 0;

$hoy = date('Y-m-d');

// Validación
if (!empty($fecha) && $fecha < $hoy && $activo == 1) {
    header("Location: gestionar-cupones.php?error=cupon_caducado");
    exit();
}

// Actualizar
$res = actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo);

// Redirección
if ($res) {
    header("Location: gestionar-cupones.php?res=edit_ok");
} else {
    header("Location: gestionar-cupones.php?res=error");
}
exit();