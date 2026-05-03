<?php
// Inicia la sesión de PHP para manejar variables de sesión
session_start();

// Incluye el archivo de configuración que define constantes como ROOT_PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de conexión a la base de datos
require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el DAO para productos
require_once ROOT_PATH . 'dao/productoDAO.php';

// Verifica si el carrito no está inicializado en la sesión
if (!isset($_SESSION['carrito'])) {
    // Inicializa el carrito como un array vacío
    $_SESSION['carrito'] = [];
}

// Verifica si se recibió el parámetro 'id' por GET
if (isset($_GET['id'])) {
    // Obtiene el ID del producto
    $id = $_GET['id'];
    // Obtiene los datos del producto desde la base de datos
    $producto = obtenerProductoPorId($conexion, $id);

    // Si el producto existe
    if ($producto) {
        // Convierte el stock a entero
        $stock = (int)$producto['stock'];

        // SIN STOCK
        if ($stock <= 0) {
            // Envía respuesta JSON indicando que no hay stock
            echo json_encode([
                "ok" => false,
                "mensaje" => "Producto sin stock"
            ]);
            // Termina la ejecución
            exit;
        }

        // SI YA EXISTE EN CARRITO
        if (isset($_SESSION['carrito'][$id])) {
            // Obtiene la cantidad actual en el carrito
            $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];

            // SI SUPERA STOCK
            if ($cantidadActual >= $stock) {
                // Envía respuesta JSON indicando que no se puede añadir más
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "No puedes añadir más unidades (stock máximo alcanzado)"
                ]);
                // Termina la ejecución
                exit;
            }

            // Incrementa la cantidad en el carrito
            $_SESSION['carrito'][$id]['cantidad']++;

        } else {
            // NUEVO PRODUCTO
            $_SESSION['carrito'][$id] = [
                "id_producto" => $id,
                "nombre" => $producto['nombre'],
                "precio" => $producto['precio'],
                "img" => $producto['img_url'],
                "plataforma" => $producto['plataforma'],
                "tipo" => $producto['tipo'],
                "cantidad" => 1
            ];
        }
    }
}

// RESPUESTA
// Envía respuesta JSON con el estado OK y el carrito actualizado
echo json_encode([
    "ok" => true,
    "carrito" => $_SESSION['carrito']
]);