<?php
session_start();
include 'conexion-bd.php';
include 'consultas.php';

// 1. Verificación de seguridad (Solo el admin borra)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso no autorizado.");
}

// 2. Comprobar que recibimos un ID válido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 3. Ejecutar la función que ya tenemos en consultas.php
    if (eliminarProducto($conexion, $id)) {
        // 4. Redirigir con un mensaje de éxito
        header("Location: gestionarProductos.php?status=deleted");
        exit();
    } else {
        echo "Error al intentar eliminar el producto.";
        echo "<br><a href='gestionarProductos.php'>Volver</a>";
    }
}
?>