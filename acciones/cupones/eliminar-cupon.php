<?php
// Inicia el bloque de código PHP para el script de eliminación de cupones

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/cuponDAO.php';
// Incluye el archivo DAO (Data Access Object) para cupones, que contiene funciones como eliminarCupon

session_start();
// Inicia la sesión para acceder a variables de sesión como el rol del usuario

// Esta funcionalidad es exclusiva para administradores

if (!esAdmin()) {
    accesoDenegado();
}

// Validar ID
// Comentario indicando que se valida el ID del cupón a eliminar

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Verifica si el parámetro 'id' está presente en la URL y es numérico
    // Esto asegura que el ID sea válido antes de proceder

    $id = (int) $_GET['id'];
    // Convierte el ID a entero para mayor seguridad y consistencia

    if (eliminarCupon($conexion, $id)) {
        // Llama a la función eliminarCupon del DAO, pasando la conexión y el ID
        // Si la eliminación es exitosa, redirige con mensaje de éxito

        header("Location: /gestionar-cupones?msj=eliminado");
        // Redirige a la página de gestión de cupones con parámetro de mensaje 'eliminado'

        exit();
        // Termina la ejecución del script después de la redirección
    } else {
        // Si la eliminación falla, redirige con mensaje de error

        header("Location: /gestionar-cupones?error=1");
        // Redirige a la página de gestión de cupones con parámetro de error

        exit();
        // Termina la ejecución del script después de la redirección
    }

} else {
    // Si el ID no es válido o no está presente, redirige sin parámetros

    header("Location: /gestionar-cupones");
    // Redirige a la página de gestión de cupones sin parámetros adicionales

    exit();
    // Termina la ejecución del script después de la redirección
}