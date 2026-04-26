<?php

function crearPedido($conexion, $usuario_id, $carrito, $direccion, $telefono, $total, $cupon_id = null, $nombre_cliente = '', $metodo_pago = '')
{

    $direccion = mysqli_real_escape_string($conexion, $direccion);
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    $nombre_cliente = mysqli_real_escape_string($conexion, $nombre_cliente);
    $metodo_pago = mysqli_real_escape_string($conexion, $metodo_pago);

    $cupon_sql = ($cupon_id !== null) ? $cupon_id : "NULL";

    $sql = "INSERT INTO pedidos 
        (usuario_id, total, direccion_envio, telefono, cupon_id, nombre_cliente, metodo_pago)
        VALUES 
        ($usuario_id, $total, '$direccion', '$telefono', $cupon_sql, '$nombre_cliente', '$metodo_pago')";

    $res = mysqli_query($conexion, $sql);

    if (!$res)
        return false;

    $id_pedido = mysqli_insert_id($conexion);

    foreach ($carrito as $producto) {

        $id_producto = $producto['id'] ?? $producto['id_producto'] ?? 0;

        if ($id_producto == 0)
            return false;

        $precio = $producto['precio'];
        $cantidad = $producto['cantidad'];
        $total_linea = $precio * $cantidad;

        $sqlDetalle = "INSERT INTO detalles_pedidos 
            (pedido_id, producto_id, precio_unitario, cantidad, total_linea)
            VALUES ($id_pedido, $id_producto, $precio, $cantidad, $total_linea)";

        if (!mysqli_query($conexion, $sqlDetalle))
            return false;

        $sqlStock = "UPDATE productos 
                     SET stock = stock - $cantidad 
                     WHERE id_producto = $id_producto";

        if (!mysqli_query($conexion, $sqlStock))
            return false;
    }

    return $id_pedido;
}


/**
 * Obtener los pedidos incluyendo el nombre del usuario
 * Tablas: pedidos y usuarios (JOIN)
 */

// Obtener pedidos (admin)
function obtenerPedidosAdmin($conexion)
{
    $sql = "SELECT p.*, u.nombre AS nombre_usuario
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id_usuario
            ORDER BY p.fecha_pedido DESC";

    return mysqli_query($conexion, $sql);
}



function obtenerPedidosUsuario($conexion, $usuario_id)
{
    $sql = "SELECT * FROM pedidos 
            WHERE usuario_id = ? 
            ORDER BY fecha_pedido DESC";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}


function obtenerDetallesPedido($conexion, $pedido_id)
{
    $sql = "SELECT dp.*, p.nombre 
            FROM detalles_pedidos dp
            JOIN productos p ON dp.producto_id = p.id_producto
            WHERE dp.pedido_id = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $pedido_id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}



// 🔹 Actualizar estado pedido
function actualizarEstadoPedido($conexion, $id_pedido, $estado)
{
    $id_pedido = intval($id_pedido);
    $estado = mysqli_real_escape_string($conexion, $estado);

    $sql = "UPDATE pedidos 
            SET estado = '$estado'
            WHERE id_pedido = $id_pedido";

    return mysqli_query($conexion, $sql);
}


function eliminarPedido($conexion, $id)
{
    $sql1 = "DELETE FROM detalles_pedidos WHERE pedido_id = ?";
    $stmt1 = mysqli_prepare($conexion, $sql1);
    mysqli_stmt_bind_param($stmt1, "i", $id);
    mysqli_stmt_execute($stmt1);

    $sql2 = "DELETE FROM pedidos WHERE id_pedido = ?";
    $stmt2 = mysqli_prepare($conexion, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $id);

    return mysqli_stmt_execute($stmt2);
}



function buscarPedidosFiltrados($conexion, $id = null, $estado = null)
{
    $sql = "SELECT p.*, u.nombre AS nombre_usuario
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id_usuario
            WHERE 1=1";

    if (!empty($id)) {
        $id = intval($id);
        $sql .= " AND p.id_pedido = $id";
    }

    if (!empty($estado)) {
        $estado = mysqli_real_escape_string($conexion, $estado);
        $sql .= " AND p.estado = '$estado'";
    }

    $sql .= " ORDER BY p.fecha_pedido DESC";

    return mysqli_query($conexion, $sql);
}



?>