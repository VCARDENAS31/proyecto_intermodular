<?php
// Inicia el bloque de código PHP para el script de eliminación de pedidos

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/pedidoDAO.php';
// Incluye el archivo DAO (Data Access Object) de pedidos, que contiene funciones como eliminarPedido

session_start();
// Inicia la sesión para acceder a variables de sesión como el rol del usuario

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Verifica si la sesión tiene el rol establecido y si es 'admin'
    // Si no es admin, deniega el acceso

    die("Acceso no autorizado.");
    // Termina la ejecución del script con un mensaje de error si no es admin
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Verifica si el parámetro 'id' está presente en la URL y es numérico
    // Esto asegura que el ID sea válido antes de proceder

    $id = (int) $_GET['id'];
    // Convierte el ID a entero para mayor seguridad y consistencia

    if (eliminarPedido($conexion, $id)) {
        // Llama a la función eliminarPedido del DAO, pasando la conexión y el ID
        // Si la eliminación es exitosa, redirige con mensaje de éxito

        header("Location: gestionar-pedidos?msj=eliminado");
        // Redirige a la página de gestión de pedidos con parámetro de mensaje 'eliminado'

        exit();
        // Termina la ejecución del script después de la redirección

    } else {
        // Si la eliminación falla, redirige con mensaje de error

        header("Location: gestionar-pedidos?error=1");
        // Redirige a la página de gestión de pedidos con parámetro de error

        exit();
        // Termina la ejecución del script después de la redirección
    }

} else {
    // Si el ID no es válido o no está presente, redirige sin parámetros

    header("Location: gestionar-pedidos");
    // Redirige a la página de gestión de pedidos sin parámetros adicionales

    exit();
    // Termina la ejecución del script después de la redirección
}