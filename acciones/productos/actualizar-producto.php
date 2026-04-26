<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] === 'admin') {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $plataforma = $_POST['plataforma'];

    // Obtener imagen actual
    $producto = obtenerProductoPorId($conexion, $id);
    $img_actual = $producto['img_url'];

    if (!empty($_FILES['imagen']['name'])) {

        $archivo = $_FILES['imagen'];

        // 🔒 VALIDACIÓN REAL WEBP (no extensión)
        $tipoMime = mime_content_type($archivo['tmp_name']);

        if ($tipoMime !== 'image/webp') {
            header("Location: editar-producto.php?id=$id&error=img");
            exit();
        }

        $nuevo_nombre = uniqid() . ".webp";

        // mantener carpeta original
        $carpeta_relativa = dirname($img_actual);

        $ruta = "assets/imagenes/" . $carpeta_relativa . "/" . $nuevo_nombre;

        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {

            // borrar antigua
            if (!empty($img_actual) && file_exists("assets/imagenes/" . $img_actual)) {
                unlink("assets/imagenes/" . $img_actual);
            }

            $img_final = $carpeta_relativa . "/" . $nuevo_nombre;

        } else {
            header("Location: editar-producto.php?id=$id&error=upload");
            exit();
        }

    } else {
        $img_final = $img_actual;
    }

    // Guardar en BD
    $resultado = actualizarProducto(
        $conexion,
        $id,
        $nombre,
        $precio,
        $stock,
        $plataforma,
        $img_final
    );

    if ($resultado) {
        header("Location: gestionarProductos.php?res=edit_ok");
    } else {
        header("Location: gestionarProductos.php?res=error");
    }
}