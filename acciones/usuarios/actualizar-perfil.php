<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';

// Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_id'])) {
    header("Location: login");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Datos
$usuarioNombre = trim($_POST['usuario_nombre'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$apellidos = trim($_POST['apellidos'] ?? '');
$email = trim($_POST['email'] ?? '');

// (Opcional) validación básica
if (empty($nombre) || empty($apellidos) || empty($email)) {
    header("Location: perfil?error=1");
    exit;
}

// Actualizar
actualizarPerfilUsuario($conexion, $usuario_id, $nombre, $apellidos, $email);

$_SESSION['usuario_nombre'] = $nombre; // Actualiza el nombre en la sesión para mostrarlo en el header

// Redirect (MUY IMPORTANTE evitar reenvío de formulario)
header("Location: perfil?ok=1");
exit;