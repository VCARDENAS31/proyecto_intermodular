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

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
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

// DEVOLVER RESPUESTA JSON
echo json_encode([
    "ok" => true,
    "carrito" => $_SESSION['carrito']
]);