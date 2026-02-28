<?php
// Incluimos la conexión (asumiendo que tienes un archivo conexion.php)
// include 'conexion.php'; 

/**
 * Obtener todos los usuarios registrados
 * Tabla: usuarios
 */
function obtenerUsuarios($conexion) {
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol FROM usuarios";
    return mysqli_query($conexion, $sql);
}

/**
 * Obtener todos los productos y su stock
 * Tabla: productos
 */
function obtenerProductos($conexion) {
    $sql = "SELECT id_producto, nombre, precio, stock, tipo, categoria, img_url, plataforma FROM productos";
    return mysqli_query($conexion, $sql);
}

/**
 * Obtener todos los cupones de descuento
 * Tabla: cupones
 */
function obtenerCupones($conexion) {
    $sql = "SELECT id_cupon, codigo, descuento_porcentaje, fecha_caducidad, activo FROM cupones";
    return mysqli_query($conexion, $sql);
}

/**
 * Obtener los pedidos incluyendo el nombre del usuario
 * Tablas: pedidos y usuarios (JOIN)
 */
function obtenerPedidos($conexion) {
    $sql = "SELECT p.id_pedido, u.nombre, u.apellidos, p.total, p.estado, p.fecha_pedido 
            FROM pedidos p 
            INNER JOIN usuarios u ON p.usuario_id = u.id_usuario 
            ORDER BY p.fecha_pedido DESC";
    return mysqli_query($conexion, $sql);
}

function eliminarUsuario($conexion, $id) {
    $id = intval($id);

    // 1. Limpiamos el carrito primero para evitar errores de integridad
    $sql_carrito = "DELETE FROM carrito WHERE usuario_id = $id";
    mysqli_query($conexion, $sql_carrito);

    // 2. Eliminamos al usuario
    $sql_usuario = "DELETE FROM usuarios WHERE id_usuario = $id";
    
    // Retornamos true si funcionó, false si hubo error (ej. tiene pedidos)
    return mysqli_query($conexion, $sql_usuario);
}

function insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $imagen) {
    $sql = "INSERT INTO productos (nombre, precio, stock, tipo, categoria, descripcion, plataforma, img_url) 
            VALUES ('$nombre', $precio, $stock, '$tipo', '$categoria', '$descripcion', '$plataforma', '$imagen')";
    
    return mysqli_query($conexion, $sql);
}

function eliminarProducto($conexion, $id) {
    $id = intval($id);
    $sql = "DELETE FROM productos WHERE id_producto = $id";
    return mysqli_query($conexion, $sql);
}

?>