<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $descripcion = $_POST['descripcion'];

    $tipoCarpeta = $_POST['tipoCarpeta'] ?? '';
    $subcarpeta = $_POST['subcarpeta'] ?? '';

    // 🔥 RUTA SEGÚN ESTRUCTURA REAL
    if ($tipoCarpeta == "videojuegos") {

        // videojuegos NO tiene plataforma
        $rutaBase = "assets/imagenes/productos/videojuegos/$subcarpeta/";
        $rutaBD = "productos/videojuegos/$subcarpeta/";

    } else {

        // accesorios y consolas SI tienen plataforma
        $rutaBase = "assets/imagenes/productos/$tipoCarpeta/$subcarpeta/";
        $rutaBD = "productos/$tipoCarpeta/$subcarpeta/";
    }

    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0) {
        header("Location: anadir-producto.php?error=img");
        exit();
    }

    $nombreImagen = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];

    // VALIDACIÓN REAL WEBP
    $tipoMime = mime_content_type($tmp);

    if ($tipoMime !== 'image/webp') {
        header("Location: anadir-producto.php?error=img");
        exit();
    }

    // Crear carpeta si no existe
    if (!file_exists($rutaBase)) {
        mkdir($rutaBase, 0777, true);
    }

    // nombre seguro
    $nombreFinal = time() . ".webp";

    move_uploaded_file($tmp, $rutaBase . $nombreFinal);

    // Guardar en BD
    if (insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $rutaBD . $nombreFinal)) {
        header("Location: gestionarProductos.php?res=ok");
    } else {
        header("Location: gestionarProductos.php?res=error");
    }
}
?>