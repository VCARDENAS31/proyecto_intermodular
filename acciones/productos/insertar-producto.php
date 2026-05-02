<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';

// 🔒 SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // =========================
    // DATOS
    // =========================
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];
    $plataforma = $_POST['plataforma'];
    $descripcion = $_POST['descripcion'];
    $slug = $_POST['slug'];

    $tipoCarpeta = $_POST['tipoCarpeta'] ?? '';
    $subcarpeta = $_POST['subcarpeta'] ?? '';

    // =========================
    // LIMPIAR SLUG
    // =========================
    $slug = strtolower(trim($slug));
    $slug = preg_replace('/[^a-z0-9-]/', '', $slug);

    // =========================
    // VALIDAR SLUG DUPLICADO
    // =========================
    if (existeSlug($conexion, $slug)) {
        header("Location: anadir-producto.php?error=slug");
        exit();
    }

    // =========================
    // RUTAS
    // =========================
    if ($tipoCarpeta == "videojuegos") {
        $rutaBase = ROOT_PATH . "assets/imagenes/productos/videojuegos/$subcarpeta/";
        $rutaBD = "productos/videojuegos/$subcarpeta/";
    } else {
        $rutaBase = ROOT_PATH . "assets/imagenes/productos/$tipoCarpeta/$subcarpeta/";
        $rutaBD = "productos/$tipoCarpeta/$subcarpeta/";
    }

    // =========================
    //IMAGEN
    // =========================
    $imagen_existente = $_POST['imagen_existente'] ?? '';

    if (!empty($imagen_existente)) {

        // Usar imagen existente
        $rutaFinalBD = $imagen_existente;

    } else {

        // Obligatorio subir imagen
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0) {
            header("Location: anadir-producto.php?error=img");
            exit();
        }

        $tmp = $_FILES['imagen']['tmp_name'];

        // Validar MIME real
        $tipoMime = mime_content_type($tmp);

        if ($tipoMime !== 'image/webp') {
            header("Location: anadir-producto.php?error=img");
            exit();
        }

        // Crear carpeta si no existe
        if (!file_exists($rutaBase)) {
            mkdir($rutaBase, 0777, true);
        }

// =========================
//  NOMBRE DE IMAGEN = ORIGINAL DEL ARCHIVO
// =========================
        $nombreOriginal = pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME);
        $nombreOriginal = strtolower(trim($nombreOriginal));
        $nombreOriginal = preg_replace('/[^a-z0-9-]/', '', $nombreOriginal);

        // opcional: evitar colisiones
        $nombreFinal = $nombreOriginal . ".webp";
        $rutaCompleta = $rutaBase . $nombreFinal;

        
        // 🚫 Evitar sobrescribir imágenes
        if (file_exists($rutaCompleta)) {
            header("Location: anadir-producto.php?error=img-existe");
            exit();
        }

        // 📦 Mover archivo
        if (!move_uploaded_file($tmp, $rutaCompleta)) {
            header("Location: anadir-producto.php?error=upload");
            exit();
        }

        $rutaFinalBD = $rutaBD . $nombreFinal;
    }

    // =========================
    // 💾 INSERTAR
    // =========================
    $resultado = insertarProducto(
        $conexion,
        $nombre,
        $precio,
        $stock,
        $tipo,
        $categoria,
        $descripcion,
        $plataforma,
        $rutaFinalBD,
        $slug
    );

    // =========================
    // 🔁 REDIRECCIÓN
    // =========================
    if ($resultado) {
        header("Location: gestionar-productos.php?res=ok");
    } else {
        header("Location: anadir-producto.php?error=general");
    }

    exit();
}
?>