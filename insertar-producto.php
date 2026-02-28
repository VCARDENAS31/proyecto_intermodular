<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre     = $_POST['nombre'];
    $precio     = $_POST['precio'];
    $stock      = $_POST['stock'];
    $tipo       = $_POST['tipo'];
    $categoria  = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $imagen     = $_POST['imagen'];
    $descripcion = $_POST['descripcion'];

    if (insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion ,$plataforma, $imagen)) {
        header("Location: gestionarProductos.php?res=ok");
    } else {
        header("Location: gestionarProductos.php?res=error");
    }
}
?>