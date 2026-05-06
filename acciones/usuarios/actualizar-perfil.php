<?php
// Inicia el bloque de código PHP para el script de actualización de perfil de usuario

session_start();
// Inicia la sesión para acceder a variables de sesión como el ID del usuario

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/usuarioDAO.php';
// Incluye el archivo DAO (Data Access Object) de usuarios con funciones para gestionar usuarios

// Validación de seguridad: solo POST de usuarios logueados pueden actualizar perfil
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['usuario_id'])) {
    // Verifica que: 1) La solicitud sea POST, 2) Exista ID de usuario en sesión

    header("Location: login");
    // Si no cumple requisitos, redirige a la página de login

    exit;
    // Termina la ejecución del script
}

// Obtiene el ID del usuario de la sesión
$usuario_id = $_SESSION['usuario_id'];
// Almacena el ID del usuario actual para usarlo en la actualización

// Obtención de datos del formulario con espacios en blanco eliminados
$usuarioNombre = trim($_POST['usuario_nombre'] ?? '');
// Obtiene el nombre de usuario (opcional) del formulario o string vacío si no existe

$nombre = trim($_POST['nombre'] ?? '');
// Obtiene el nombre del perfil del formulario o string vacío si no existe

$apellidos = trim($_POST['apellidos'] ?? '');
// Obtiene los apellidos del perfil del formulario o string vacío si no existe

$email = trim($_POST['email'] ?? '');
// Obtiene el email del perfil del formulario o string vacío si no existe

// Validación de campos obligatorios
if (empty($nombre) || empty($apellidos) || empty($email)) {
    // Verifica que todos los campos requeridos hayan sido completados (no estén vacíos)

    header("Location: perfil?error=1");
    // Si faltan campos, redirige a la página de perfil con parámetro de error

    exit;
    // Termina la ejecución del script
}

// Actualiza el perfil del usuario en la base de datos
actualizarPerfilUsuario($conexion, $usuario_id, $nombre, $apellidos, $email);
// Llama a la función del DAO para actualizar los datos del perfil en la base de datos

// Sincroniza la sesión con el nuevo nombre del usuario
$_SESSION['usuario_nombre'] = $nombre;
// Actualiza la variable de sesión con el nuevo nombre para reflejar los cambios en la interfaz

// Redirige a la página de perfil con mensaje de éxito
header("Location: perfil?ok=1");
// Redirige a la página de perfil con parámetro de éxito para mostrar confirmación

exit;
// Termina la ejecución del script
?>