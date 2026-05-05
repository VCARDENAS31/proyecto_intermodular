<?php
// Inicia el archivo PHP

session_start();
// Inicia la sesión para manejar datos de usuario

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos

require_once ROOT_PATH . 'dao/cuponDAO.php';
// Incluye el DAO para operaciones con cupones


// Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Verifica que la solicitud sea POST y que el usuario sea admin; de lo contrario, deniega acceso
    die("Acceso no autorizado.");
}

// Datos
$id = $_POST['id'] ?? null;
// Obtiene el ID del cupón desde el formulario POST, o null si no existe

$codigo = $_POST['codigo'] ?? '';
// Obtiene el código del cupón desde el formulario POST, o cadena vacía si no existe

$descuento = $_POST['descuento'] ?? 0;
// Obtiene el descuento del cupón desde el formulario POST, o 0 si no existe

$fecha = $_POST['fecha'] ?? '';
// Obtiene la fecha de expiración del cupón desde el formulario POST, o cadena vacía si no existe

$activo = $_POST['activo'] ?? 0;
// Obtiene el estado activo del cupón desde el formulario POST, o 0 si no existe

$hoy = date('Y-m-d');
// Obtiene la fecha actual en formato YYYY-MM-DD

// Validación
if (!empty($fecha) && $fecha < $hoy && $activo == 1) {
    // Valida que si hay fecha y es anterior a hoy, y el cupón está activo, redirige con error
    header("Location: gestionar-cupones.php?error=cupon_caducado");
    exit();
}

// Actualizar
$res = actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo);
// Llama a la función para actualizar el cupón en la base de datos

// Redirección
if ($res) {
    // Si la actualización fue exitosa, redirige con mensaje de éxito
    header("Location: gestionar-cupones.php?res=edit_ok");
} else {
    // Si falló, redirige con mensaje de error
    header("Location: gestionar-cupones.php?res=error");
}
exit();
// Termina la ejecución del script
