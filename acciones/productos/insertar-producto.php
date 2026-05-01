<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';


//  SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //  DATOS
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $descripcion = $_POST['descripcion'];

    $tipoCarpeta = $_POST['tipoCarpeta'] ?? '';
    $subcarpeta = $_POST['subcarpeta'] ?? '';

    //  RUTA SEGÚN ESTRUCTURA
    if ($tipoCarpeta == "videojuegos") {

        $rutaBase = "assets/imagenes/productos/videojuegos/$subcarpeta/";
        $rutaBD = "productos/videojuegos/$subcarpeta/";

    } else {

        $rutaBase = "assets/imagenes/productos/$tipoCarpeta/$subcarpeta/";
        $rutaBD = "productos/$tipoCarpeta/$subcarpeta/";
    }

    //  IMAGEN (OBLIGATORIA: NUEVA O EXISTENTE)
    $imagen_existente = $_POST['imagen_existente'] ?? '';

    if (!empty($imagen_existente)) {

        //  Usar imagen existente
        $rutaFinalBD = $imagen_existente;

    } else {

        //  Obligamos a subir imagen
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0) {
            header("Location: anadir-producto.php?error=img");
            exit();
        }

        $tmp = $_FILES['imagen']['tmp_name'];

        //  VALIDAR WEBP REAL
        $tipoMime = mime_content_type($tmp);

        if ($tipoMime !== 'image/webp') {
            header("Location: anadir-producto.php?error=img");
            exit();
        }

        //  Crear carpeta si no existe
        if (!file_exists($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }

        //   Nombre único
        $nombreFinal = uniqid() . ".webp";

        if (!move_uploaded_file($tmp, $rutaBase . $nombreFinal)) {
            header("Location: anadir-producto.php?error=upload");
            exit();
        }

        $rutaFinalBD = $rutaBD . $nombreFinal;
    }

    //  INSERTAR EN BD
    $resultado = insertarProducto(
        $conexion,
        $nombre,
        $precio,
        $stock,
        $tipo,
        $categoria,
        $descripcion,
        $plataforma,
        $rutaFinalBD
    );

    //  REDIRECCIÓN FINAL
    if ($resultado) {
        header("Location: gestionar-productos.php?res=ok");
    } else {
        header("Location: gestionar-productos.php?res=error");
    }

    exit();
}
?>