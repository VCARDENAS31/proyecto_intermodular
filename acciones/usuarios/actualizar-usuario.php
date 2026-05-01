<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';

session_start();

// Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// Datos
$id_usuario = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$rol = $_POST['rol'] ?? '';
$password = $_POST['password'] ?? '';

// Validación contraseña
if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{5,}$/', $password)) {
    header("Location: editar-usuario/$id_usuario?error=pass_corta");
    exit();
}

// Actualizar
if (!empty($password)) {

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $resultado = actualizarUsuarioConPassword(
        $conexion,
        $id_usuario,
        $nombre,
        $apellidos,
        $email,
        $rol,
        $password_hash
    );

} else {

    $resultado = actualizarUsuario(
        $conexion,
        $id_usuario,
        $nombre,
        $apellidos,
        $email,
        $rol
    );
}

// Redirección
if ($resultado) {
    header("Location: gestionar-usuarios?res=edit_ok");
} else {
    header("Location: gestionar-usuarios?res=error");
}
exit();