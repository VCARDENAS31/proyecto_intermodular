<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/productoDAO.php';


// Seguridad
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// Datos
$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$stock = $_POST['stock'] ?? 0;
$plataforma = $_POST['plataforma'] ?? '';

// Obtener producto actual
$producto = obtenerProductoPorId($conexion, $id);

if (!$producto) {
    die("Producto no encontrado.");
}

$img_actual = $producto['img_url'];

// Subida imagen
if (!empty($_FILES['imagen']['name'])) {

    $archivo = $_FILES['imagen'];

    // Validar MIME REAL
    $tipoMime = mime_content_type($archivo['tmp_name']);

    if ($tipoMime !== 'image/webp') {
        header("Location: editar-producto/$id?error=img");
        exit();
    }

    $nuevo_nombre = uniqid() . ".webp";
    $carpeta_relativa = dirname($img_actual);

    $ruta = ROOT_PATH . "assets/imagenes/" . $carpeta_relativa . "/" . $nuevo_nombre;

    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {

        // Borrar imagen anterior
        $ruta_antigua = ROOT_PATH . "assets/imagenes/" . $img_actual;

        if (!empty($img_actual) && file_exists($ruta_antigua)) {
            unlink($ruta_antigua);
        }

        $img_final = $carpeta_relativa . "/" . $nuevo_nombre;

    } else {
        header("Location: editar-producto/$id?error=upload");
        exit();
    }

} else {
    $img_final = $img_actual;
}

// Guardar
$resultado = actualizarProducto(
    $conexion,
    $id,
    $nombre,
    $precio,
    $stock,
    $plataforma,
    $img_final
);

// Redirección
if ($resultado) {
    header("Location: gestionar-productos?res=edit_ok");
} else {
    header("Location: gestionar-productos?res=error");
}
exit();