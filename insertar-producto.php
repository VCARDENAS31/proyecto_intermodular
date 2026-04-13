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
    $descripcion = $_POST['descripcion'];

    $tipoCarpeta = $_POST['tipoCarpeta'] ?? '';
    $subcarpeta  = $_POST['subcarpeta'] ?? '';

    // Ruta base
    $rutaBase = "assets/imagenes/productos/$tipoCarpeta/$subcarpeta/";

    // Imagen
    $nombreImagen = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];

    // Crear carpeta si no existe
    if (!file_exists($rutaBase)) {
        mkdir($rutaBase, 0777, true);
    }

    // Evitar nombres duplicados
    $nombreFinal = time() . "_" . $nombreImagen;

    move_uploaded_file($tmp, $rutaBase . $nombreFinal);

    // Guardar en BD solo la ruta relativa
    $rutaBD = "productos/$tipoCarpeta/$subcarpeta/" . $nombreFinal;

    if (insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $rutaBD)) {
        header("Location: gestionarProductos.php?res=ok");
    } else {
        header("Location: gestionarProductos.php?res=error");
    }
}