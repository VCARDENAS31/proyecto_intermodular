<?php
// Inicia el bloque de código PHP para el script de inserción de usuarios por admin

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/usuarioDAO.php';
// Incluye el archivo DAO (Data Access Object) de usuarios con funciones para gestionar usuarios

session_start();
// Inicia la sesión para acceder a variables de sesión y validar permisos

if (!esAdmin()) {
    // Verifica si el usuario actual es administrador

    accesoDenegado();
    // Si no es admin, ejecuta el manejador de acceso denegado y termina el script
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que la solicitud HTTP sea POST, lo que indica que se envió el formulario

    $nombre = $_POST['nombre'];
    // Obtiene el nombre del nuevo usuario desde el formulario

    $apellidos = $_POST['apellidos'];
    // Obtiene los apellidos del nuevo usuario desde el formulario

    $email = $_POST['email'];
    // Obtiene el email del nuevo usuario desde el formulario

    $password = $_POST['password'];
    // Obtiene la contraseña sin cifrar proporcionada en el formulario

    $rol = $_POST['rol'];
    // Obtiene el rol asignado al nuevo usuario (por ejemplo admin o user)

    if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{5,}$/', $password)) {
        // Valida la contraseña: mínimo 5 caracteres, al menos una mayúscula y un carácter especial

        header("Location: anadir-usuario.php?error=pass");
        // Si la contraseña no cumple el patrón, redirige con el error correspondiente

        exit();
        // Termina la ejecución del script tras la redirección
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    // Cifra la contraseña de forma segura antes de guardarla en la base de datos

    try {
        // Intenta ejecutar la inserción de usuario en la base de datos

        $resultado = insertarUsuario(
            $conexion,
            $nombre,
            $apellidos,
            $email,
            $password_hash,
            $rol
        );
        // Llama a la función DAO para insertar el nuevo usuario

        header("Location: gestionar-usuarios.php?res=ok");
        // Si la inserción fue exitosa, redirige a la gestión de usuarios con un mensaje OK

        exit();
        // Termina la ejecución del script

    } catch (mysqli_sql_exception $e) {
        // Captura excepciones de MySQL en caso de error durante la inserción

        if ($e->getCode() == 1062) {
            // Si el error corresponde a duplicidad de clave única (email repetido)
            header("Location: anadir-usuario.php?error=email");
            // Redirige a la página de añadir usuario indicando error de email duplicado

            exit();
            // Termina la ejecución del script
        }

        header("Location: anadir-usuario.php?error=general");
        // Para cualquier otro error, redirige con un error general

        exit();
        // Termina la ejecución del script
    }
}
?>