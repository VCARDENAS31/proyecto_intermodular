<?php
// Inicia el bloque de código PHP para el script de eliminación de productos

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/productoDAO.php';
// Incluye el archivo DAO (Data Access Object) de productos, que contiene funciones como eliminarProducto

session_start();
// Inicia la sesión para acceder a variables de sesión como el rol del usuario

// Validación de seguridad: solo administradores pueden eliminar productos
if (!esAdmin()) {
    accesoDenegado();
}

// Validar que se reciba un ID válido para eliminar
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Verifica si el parámetro 'id' está presente en la URL y es numérico
    // Esto asegura que el ID sea válido antes de proceder

    $id = (int) $_GET['id'];
    // Convierte el ID a entero para mayor seguridad y consistencia

    if (eliminarProducto($conexion, $id)) {
        // Llama a la función eliminarProducto del DAO, pasando la conexión y el ID
        // Si la eliminación es exitosa, redirige con mensaje de éxito

        header("Location: gestionar-productos?msj=eliminado");
        // Redirige a la página de gestión de productos con parámetro de mensaje 'eliminado'

        exit();
        // Termina la ejecución del script después de la redirección
    } else {
        // Si la eliminación falla, redirige con mensaje de error

        header("Location: gestionar-productos?error=1");
        // Redirige a la página de gestión de productos con parámetro de error

        exit();
        // Termina la ejecución del script después de la redirección
    }

} else {
    // Si el ID no es válido o no está presente, redirige sin parámetros

    header("Location: gestionar-productos");
    // Redirige a la página de gestión de productos sin parámetros adicionales

    exit();
    // Termina la ejecución del script después de la redirección
}