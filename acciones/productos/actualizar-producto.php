<?php
// Inicia el bloque de código PHP para el script de actualización de productos

session_start();
// Inicia la sesión para acceder a variables de sesión como el rol del usuario

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/productoDAO.php';
// Incluye el archivo DAO (Data Access Object) de productos con funciones para gestionar productos

// Se realizan validaciones de seguridad

if (!esAdmin()) {
    accesoDenegado();
}

// Obtiene los datos del formulario POST o asigna valores por defecto
$id = $_POST['id'] ?? null;
// Obtiene el ID del producto a actualizar (null si no está presente)

$nombre = $_POST['nombre'] ?? '';
// Obtiene el nombre del producto o string vacío si no está presente

$precio = $_POST['precio'] ?? 0;
// Obtiene el precio del producto o 0 si no está presente

$stock = $_POST['stock'] ?? 0;
// Obtiene el stock del producto o 0 si no está presente

$descripcion = $_POST['descripcion'] ?? '';
// Obtiene la descripción del producto o string vacío si no está presente

// Verifica que el producto exista en la base de datos
$producto = obtenerProductoPorId($conexion, $id);
// Llama a la función del DAO para obtener los datos actuales del producto

if (!$producto) {
    // Verifica si el producto fue encontrado

    die("Producto no encontrado.");
    // Termina la ejecución con error si el producto no existe
}

// Actualiza el producto en la base de datos
$resultado = actualizarProducto(
    // Llama a la función del DAO para actualizar el producto
    $conexion,
    // Pasa la conexión a la base de datos
    $id,
    // Pasa el ID del producto a actualizar
    $nombre,
    // Pasa el nuevo nombre del producto
    $precio,
    // Pasa el nuevo precio del producto
    $stock,
    // Pasa el nuevo stock del producto
    $descripcion
    // Pasa la nueva descripción del producto
);

// Redirige según el resultado de la actualización
if ($resultado) {
    // Si la actualización fue exitosa, redirige con mensaje de éxito

    header("Location: gestionar-productos?res=edit_ok");
    // Redirige a la página de gestión de productos con parámetro de éxito
} else {
    // Si la actualización falló, redirige con mensaje de error

    header("Location: gestionar-productos?res=error");
    // Redirige a la página de gestión de productos con parámetro de error
}

exit();
// Termina la ejecución del script después de la redirección