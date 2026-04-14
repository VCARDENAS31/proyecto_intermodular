<?php
session_start();

include 'conexion-bd.php';
include 'consultas.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    $producto = obtenerProductoPorId($conexion, $id);

    if ($producto) {

        $stock = (int)$producto['stock'];

        // ❌ SIN STOCK
        if ($stock <= 0) {
            echo json_encode([
                "ok" => false,
                "mensaje" => "Producto sin stock"
            ]);
            exit;
        }

        // ✅ SI YA EXISTE EN CARRITO
        if (isset($_SESSION['carrito'][$id])) {

            $cantidadActual = $_SESSION['carrito'][$id]['cantidad'];

            // ❌ SI SUPERA STOCK
            if ($cantidadActual >= $stock) {
                echo json_encode([
                    "ok" => false,
                    "mensaje" => "No puedes añadir más unidades (stock máximo alcanzado)"
                ]);
                exit;
            }

            $_SESSION['carrito'][$id]['cantidad']++;

        } else {

            // ✅ NUEVO PRODUCTO
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
echo json_encode([
    "ok" => true,
    "carrito" => $_SESSION['carrito']
]);