<?php
// PedidoDAO: funciones para crear, consultar y gestionar pedidos en la tienda

function crearPedido($conexion, $usuario_id, $carrito, $direccion, $telefono, $total, $cupon_id = null, $nombre_cliente = '', $metodo_pago = '')
{
    // Sanitiza la dirección usando la conexión actual para evitar inyección
    $direccion = mysqli_real_escape_string($conexion, $direccion);
    // Sanitiza el teléfono usando la conexión actual
    $telefono = mysqli_real_escape_string($conexion, $telefono);
    // Sanitiza el nombre completo del cliente
    $nombre_cliente = mysqli_real_escape_string($conexion, $nombre_cliente);
    // Sanitiza el método de pago para incluirlo en la consulta
    $metodo_pago = mysqli_real_escape_string($conexion, $metodo_pago);

    // Prepara el valor del cupón: si no hay cupón, usa NULL en SQL
    $cupon_sql = ($cupon_id !== null) ? $cupon_id : "NULL";

    // Construye la sentencia SQL para insertar el pedido principal
    $sql = "INSERT INTO pedidos 
        (usuario_id, total, direccion_envio, telefono, cupon_id, nombre_cliente, metodo_pago)
        VALUES 
        ($usuario_id, $total, '$direccion', '$telefono', $cupon_sql, '$nombre_cliente', '$metodo_pago')";

    // Ejecuta la consulta de inserción del pedido
    $res = mysqli_query($conexion, $sql);
    if (!$res)
        // Si la inserción falla, retorna false
        return false;

    // Recupera el ID del pedido recién creado
    $id_pedido = mysqli_insert_id($conexion);

    // Recorre cada producto del carrito para insertar sus detalles
    foreach ($carrito as $producto) {
        // Soporta ambos formatos posibles de ID de producto
        $id_producto = $producto['id'] ?? $producto['id_producto'] ?? 0;
        if ($id_producto == 0)
            // Si no hay ID válido, retorna false
            return false;

        // Obtiene el precio unitario del producto
        $precio = $producto['precio'];
        // Obtiene la cantidad pedida de ese producto
        $cantidad = $producto['cantidad'];
        // Calcula el total de la línea para el detalle del pedido
        $total_linea = $precio * $cantidad;

        // Construye la consulta para insertar el detalle del pedido
        $sqlDetalle = "INSERT INTO detalles_pedidos 
            (pedido_id, producto_id, precio_unitario, cantidad, total_linea)
            VALUES ($id_pedido, $id_producto, $precio, $cantidad, $total_linea)";

        // Ejecuta la inserción del detalle del pedido
        if (!mysqli_query($conexion, $sqlDetalle))
            return false;

        // Construye la consulta para restar el stock del producto
        $sqlStock = "UPDATE productos 
                     SET stock = stock - $cantidad 
                     WHERE id_producto = $id_producto";

        // Ejecuta la actualización del stock
        if (!mysqli_query($conexion, $sqlStock))
            return false;
    }

    // Devuelve el ID del pedido creado cuando todo ha sido exitoso
    return $id_pedido;
}


function obtenerPedidosAdmin($conexion)
{
    // Construye la consulta para obtener pedidos con el nombre del usuario
    $sql = "SELECT p.*, u.nombre AS nombre_usuario
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id_usuario
            ORDER BY p.fecha_pedido DESC";

    // Ejecuta la consulta y retorna el conjunto de resultados
    return mysqli_query($conexion, $sql);
}


function obtenerPedidosUsuario($conexion, $usuario_id)
{
    // Construye la consulta preparada para obtener pedidos de un usuario
    $sql = "SELECT * FROM pedidos 
            WHERE usuario_id = ? 
            ORDER BY fecha_pedido DESC";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID del usuario como entero
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}


function obtenerDetallesPedido($conexion, $pedido_id)
{
    // Construye la consulta para obtener los detalles del pedido y el nombre del producto
    $sql = "SELECT dp.*, p.nombre 
            FROM detalles_pedidos dp
            JOIN productos p ON dp.producto_id = p.id_producto
            WHERE dp.pedido_id = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID del pedido como entero
    mysqli_stmt_bind_param($stmt, "i", $pedido_id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}


function actualizarEstadoPedido($conexion, $id_pedido, $estado)
{
    // Convierte el ID a entero para mayor seguridad
    $id_pedido = intval($id_pedido);
    // Escapa el estado para evitar inyección SQL
    $estado = mysqli_real_escape_string($conexion, $estado);

    // Construye la consulta para actualizar el estado del pedido
    $sql = "UPDATE pedidos 
            SET estado = '$estado'
            WHERE id_pedido = $id_pedido";

    // Ejecuta la actualización y retorna el resultado
    return mysqli_query($conexion, $sql);
}


function eliminarPedido($conexion, $id)
{
    // Construye y ejecuta la consulta para eliminar primero los detalles del pedido
    $sql1 = "DELETE FROM detalles_pedidos WHERE pedido_id = ?";
    $stmt1 = mysqli_prepare($conexion, $sql1);
    mysqli_stmt_bind_param($stmt1, "i", $id);
    mysqli_stmt_execute($stmt1);

    // Construye y ejecuta la consulta para eliminar el pedido principal
    $sql2 = "DELETE FROM pedidos WHERE id_pedido = ?";
    $stmt2 = mysqli_prepare($conexion, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $id);

    // Retorna el resultado de la eliminación del pedido
    return mysqli_stmt_execute($stmt2);
}


function buscarPedidosFiltrados($conexion, $id = null, $estado = null)
{
    // Construye la consulta base para buscar pedidos con nombre de usuario
    $sql = "SELECT p.*, u.nombre AS nombre_usuario
            FROM pedidos p
            JOIN usuarios u ON p.usuario_id = u.id_usuario
            WHERE 1=1";

    if (!empty($id)) {
        // Si se recibe un ID, lo convierte a entero y lo añade a la consulta
        $id = intval($id);
        $sql .= " AND p.id_pedido = $id";
    }

    if (!empty($estado)) {
        // Si se recibe un estado, lo escapa y lo añade a la consulta
        $estado = mysqli_real_escape_string($conexion, $estado);
        $sql .= " AND p.estado = '$estado'";
    }

    // Añade el orden descendente por fecha de pedido
    $sql .= " ORDER BY p.fecha_pedido DESC";

    // Ejecuta la consulta y retorna el conjunto de resultados
    return mysqli_query($conexion, $sql);
}

?>