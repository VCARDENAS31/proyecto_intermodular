<?php
// Inicia el bloque de código PHP para el script de actualización de usuario (admin)

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/usuarioDAO.php';
// Incluye el archivo DAO (Data Access Object) de usuarios con funciones para gestionar usuarios

session_start();
// Inicia la sesión para acceder a variables de sesión y validar permisos

// Validación de seguridad: solo administradores pueden actualizar usuarios
if (!esAdmin()) {
    // Llama a la función del DAO que verifica si el usuario actual es administrador

    accesoDenegado();
    // Si no es admin, llama a la función que maneja el acceso denegado y termina la ejecución
}

// Obtención de datos del formulario POST
$id_usuario = $_POST['id'] ?? null;
// Obtiene el ID del usuario a actualizar o null si no está presente

$nombre = $_POST['nombre'] ?? '';
// Obtiene el nombre del usuario o string vacío si no existe

$apellidos = $_POST['apellidos'] ?? '';
// Obtiene los apellidos del usuario o string vacío si no existe

$email = $_POST['email'] ?? '';
// Obtiene el email del usuario o string vacío si no existe

$rol = $_POST['rol'] ?? '';
// Obtiene el rol del usuario (admin, user, etc.) o string vacío si no existe

$password = $_POST['password'] ?? '';
// Obtiene la nueva contraseña si se proporciona o string vacío si no existe

// Validación de la contraseña cuando se proporciona una nueva
if (!empty($password) && !preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{5,}$/', $password)) {
    // Si hay contraseña y no cumple los requisitos de seguridad
    // Requisitos: 5+ caracteres, al menos una mayúscula, al menos un carácter especial

    header("Location: editar-usuario/$id_usuario?error=pass_corta");
    // Redirige de vuelta a la página de edición con parámetro de error

    exit();
    // Termina la ejecución del script
}

// Procesa la actualización según si hay nueva contraseña o no
if (!empty($password)) {
    // Si se proporciona una nueva contraseña, la encripta y actualiza con ella

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    // Encripta la contraseña usando bcrypt (PASSWORD_DEFAULT) para almacenamiento seguro

    $resultado = actualizarUsuarioConPassword(
        // Llama a la función del DAO para actualizar usuario incluyendo la contraseña
        $conexion,
        // Pasa la conexión a la base de datos
        $id_usuario,
        // Pasa el ID del usuario a actualizar
        $nombre,
        // Pasa el nuevo nombre del usuario
        $apellidos,
        // Pasa los nuevos apellidos del usuario
        $email,
        // Pasa el nuevo email del usuario
        $rol,
        // Pasa el nuevo rol del usuario
        $password_hash
        // Pasa la contraseña encriptada
    );

} else {
    // Si no se proporciona contraseña nueva, actualiza solo los otros datos

    $resultado = actualizarUsuario(
        // Llama a la función del DAO para actualizar usuario sin cambiar contraseña
        $conexion,
        // Pasa la conexión a la base de datos
        $id_usuario,
        // Pasa el ID del usuario a actualizar
        $nombre,
        // Pasa el nuevo nombre del usuario
        $apellidos,
        // Pasa los nuevos apellidos del usuario
        $email,
        // Pasa el nuevo email del usuario
        $rol
        // Pasa el nuevo rol del usuario
    );
}

// Redirige según el resultado de la actualización
if ($resultado) {
    // Si la actualización fue exitosa

    header("Location: gestionar-usuarios?res=edit_ok");
    // Redirige a la página de gestión de usuarios con parámetro de éxito
} else {
    // Si la actualización falló

    header("Location: gestionar-usuarios?res=error");
    // Redirige a la página de gestión de usuarios con parámetro de error
}

exit();
// Termina la ejecución del script