<?php
// Inicia la sesión de PHP para manejar variables de sesión.
session_start();

// Incluye el archivo de configuración que define constantes como ROOT_PATH.
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de conexión a la base de datos.
require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el DAO (Objeto de Acceso a Datos) para productos.
require_once ROOT_PATH . 'dao/productoDAO.php';

// Verifica si el carrito no está inicializado en la sesión.
if (!isset($_SESSION['carrito'])) {
    // Si no está inicializado, crea el carrito como un array vacío.
    $_SESSION['carrito'] = [];
}

// Verifica si se recibió el parámetro 'id' a través de GET.
if (isset($_GET['id'])) {
    // Obtiene el ID del producto desde la URL.
    $id = $_GET['id'];
    // Obtiene los datos completos del producto desde la base de datos utilizando su ID.
    $producto = obtenerProductoPorId($conexion, $id);

    // Si el producto existe en la base de datos.
    if ($producto) {
        // Convierte el stock del producto a un número entero.
        $stock = (int) $producto['stock'];

        // SIN STOCK
        // Si el stock del producto es menor o igual a 0.
        if ($stock <= 0) {
            // Envía una respuesta JSON indicando que no hay stock disponible.
            echo json_encode([
                "ok" => false,
                "mensaje" => "Producto sin stock"
            ]);
            // Termina la ejecución del script.
            exit;
        }

        // SI YA EXISTE EN CARRITO
        // Si el producto ya se encuentra en el carrito de la sesión.
        if (isset($_SESSION['carrito'][$id])) {
            // Obtiene la cantidad actual de este producto en el carrito.
            $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];

            // SI SUPERA STOCK
            // Si la cantidad actual en el carrito es igual o superior al stock disponible.
            if ($cantidadActual >= $stock) {
                // Envía una respuesta JSON indicando que no se pueden añadir más unidades.
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "No puedes añadir más unidades (stock máximo alcanzado)"
                ]);
                // Termina la ejecución del script.
                exit;
            }

            // Incrementa la cantidad de este producto en el carrito.
            $_SESSION['carrito'][$id]['cantidad']++;

        } else {
            // NUEVO PRODUCTO
            // Si el producto no está en el carrito, lo añade como un nuevo elemento.
            $_SESSION['carrito'][$id] = [
                "id_producto" => $id, // ID del producto
                "nombre" => $producto['nombre'], // Nombre del producto
                "precio" => $producto['precio'], // Precio del producto
                "img" => $producto['img_url'], // URL de la imagen del producto
                "plataforma" => $producto['plataforma'], // Plataforma del producto
                "tipo" => $producto['tipo'], // Tipo de producto
                "cantidad" => 1 // Cantidad inicial, siempre 1 al añadir un nuevo producto
            ];
        }
    }
}

// RESPUESTA
// Envía una respuesta JSON final con el estado OK y el contenido actualizado del carrito.
echo json_encode([
    "ok" => true,
    "carrito" => $_SESSION['carrito']
]);