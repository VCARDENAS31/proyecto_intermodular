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
    $sql = "SELECT id_producto, nombre, precio, stock, categoria, plataforma FROM productos";
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
?>