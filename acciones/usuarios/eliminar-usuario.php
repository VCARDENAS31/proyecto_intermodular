<?php
// Inicia el bloque de código PHP para el script de eliminación de usuarios

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/usuarioDAO.php';
// Incluye el archivo DAO (Data Access Object) de usuarios, que contiene funciones como eliminarUsuario

session_start();
// Inicia la sesión para acceder a variables de sesión y validar permisos

if (!esAdmin()) {
    // Verifica si el usuario actual es administrador usando la función de helper

    accesoDenegado();
    // Si no es admin, ejecuta la función de acceso denegado y detiene el script
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Verifica que el parámetro 'id' exista en la URL y sea un número válido

    $id = (int) $_GET['id'];
    // Convierte el ID a entero para mayor seguridad y consistencia

    if (eliminarUsuario($conexion, $id)) {
        // Llama a la función del DAO para eliminar el usuario de la base de datos
        // Si la eliminación se realiza correctamente, redirige con mensaje de éxito

        header("Location: /gestionar-usuarios?msj=eliminado");
        // Redirige a la página de gestión de usuarios con un mensaje de usuario eliminado

        exit();
        // Termina la ejecución del script después de la redirección

    } else {
        // Si la eliminación falla (por ejemplo, por historial de pedidos), redirige con error

        header("Location: /gestionar-usuarios?error=historial");
        // Redirige a la página de gestión de usuarios con un parámetro de error específico

        exit();
        // Termina la ejecución del script después de la redirección
    }

} else {
    // Si no se proporciona un ID válido, redirige de vuelta a la gestión de usuarios

    header("Location: /gestionar-usuarios");
    // Redirige a la página de gestión de usuarios sin parámetros adicionales

    exit();
    // Termina la ejecución del script
}