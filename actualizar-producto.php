<?php

include 'conexion-bd.php';
include 'consultas.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $imagen = $_POST['img_url'];

    $resultado = actualizarProducto(
        $conexion,
        $id,
        $nombre,
        $precio,
        $stock,
        $tipo,
        $categoria,
        $plataforma,
        $imagen
    );

    if ($resultado) {
        header("Location: gestionarProductos.php?res=ok");
    } else {
        header("Location: gestionarProductos.php?res=error");
    }
}