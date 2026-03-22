<?php
// Incluimos la conexión (asumiendo que tienes un archivo conexion.php)
// include 'conexion.php'; 

/**
 * Obtener todos los usuarios registrados
 * Tabla: usuarios
 */
function obtenerUsuarios($conexion)
{
    $sql = "SELECT id_usuario, nombre, apellidos, email, rol FROM usuarios";
    return mysqli_query($conexion, $sql);
}


/**
 * Obtener todos los cupones de descuento
 * Tabla: cupones
 */
function obtenerCupones($conexion)
{
    $sql = "SELECT id_cupon, codigo, descuento_porcentaje, fecha_caducidad, activo FROM cupones";
    return mysqli_query($conexion, $sql);
}

/**
 * Obtener los pedidos incluyendo el nombre del usuario
 * Tablas: pedidos y usuarios (JOIN)
 */
function obtenerPedidos($conexion)
{
    $sql = "SELECT p.id_pedido, u.nombre, u.apellidos, p.total, p.estado, p.fecha_pedido 
            FROM pedidos p 
            INNER JOIN usuarios u ON p.usuario_id = u.id_usuario 
            ORDER BY p.fecha_pedido DESC";
    return mysqli_query($conexion, $sql);
}

function eliminarUsuario($conexion, $id)
{
    $id = intval($id);

    // 1. Limpiamos el carrito primero para evitar errores de integridad
    $sql_carrito = "DELETE FROM carrito WHERE usuario_id = $id";
    mysqli_query($conexion, $sql_carrito);

    // 2. Eliminamos al usuario
    $sql_usuario = "DELETE FROM usuarios WHERE id_usuario = $id";

    // Retornamos true si funcionó, false si hubo error (ej. tiene pedidos)
    return mysqli_query($conexion, $sql_usuario);
}

function insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $imagen)
{
    $sql = "INSERT INTO productos (nombre, precio, stock, tipo, categoria, descripcion, plataforma, img_url) 
            VALUES ('$nombre', $precio, $stock, '$tipo', '$categoria', '$descripcion', '$plataforma', '$imagen')";

    return mysqli_query($conexion, $sql);
}

function eliminarProducto($conexion, $id)
{
    $id = intval($id);
    $sql = "DELETE FROM productos WHERE id_producto = $id";
    return mysqli_query($conexion, $sql);
}

/**
 * Actualizar datos de un usuario
 */
function actualizarUsuario($conexion, $id, $nombre, $apellidos, $email, $rol)
{
    $id = intval($id);
    $sql = "UPDATE usuarios SET 
            nombre = '$nombre', 
            apellidos = '$apellidos', 
            email = '$email', 
            rol = '$rol' 
            WHERE id_usuario = $id";
    return mysqli_query($conexion, $sql);
}

/**
 * Actualizar datos de un producto (URL de imagen como texto)
 */
function actualizarProducto($conexion, $id, $nombre, $precio, $stock, $tipo, $categoria, $plataforma, $imagen)
{
    $id = intval($id);
    $sql = "UPDATE productos SET 
            nombre = '$nombre', 
            precio = $precio, 
            stock = $stock, 
            tipo = '$tipo', 
            categoria = '$categoria', 
            plataforma = '$plataforma', 
            imagen = '$imagen' 
            WHERE id_producto = $id";
    return mysqli_query($conexion, $sql);
}


/**
 * Obtener un usuario específico por su ID
 *
 */
function obtenerUsuarioPorId($conexion, $id)
{
    $id = intval($id); // Seguridad: nos aseguramos que sea un número
    $sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
    $resultado = mysqli_query($conexion, $sql);

    // Retorna un array asociativo con los datos del usuario
    return mysqli_fetch_assoc($resultado);
}

/**
 * Obtener un producto específico por su ID
 *
 */
function obtenerProductoPorId($conexion, $id)
{
    $id = intval($id);
    $sql = "SELECT * FROM productos WHERE id_producto = $id";
    $resultado = mysqli_query($conexion, $sql);

    // Retorna un array asociativo con los datos del producto
    return mysqli_fetch_assoc($resultado);
}

function obtenerProductosPorPlataforma($conexion, $plataforma)
{
    // 1. Preparamos la consulta con un placeholder (?)
    $sql = "SELECT * FROM productos WHERE plataforma = ?";

    $stmt = mysqli_prepare($conexion, $sql);

    // 2. Vinculamos el parámetro (s = string)
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // 3. Ejecutamos
    mysqli_stmt_execute($stmt);

    // 4. Obtenemos el resultado
    $resultado = mysqli_stmt_get_result($stmt);

    return $resultado;
}

function obtenerUltimos18Juegos($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimos18JuegosPs5($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego' AND plataforma = 'PS5'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimos18JuegosXbox($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego' AND plataforma = 'Xbox'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimos18JuegosNintendo($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego' AND plataforma = 'Switch'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimas18consolas($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimas8consolasPs5($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola' AND plataforma = 'PS5'
            ORDER BY id_producto DESC
            LIMIT 8";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimas8consolasXbox($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola' AND plataforma = 'Xbox'
            ORDER BY id_producto DESC
            LIMIT 8";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimas8consolasNintendo($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola' AND plataforma = 'Switch'
            ORDER BY id_producto DESC
            LIMIT 8";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimos10Accesorios($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Accesorio' AND plataforma = 'PS5'
            ORDER BY id_producto DESC
            LIMIT 10";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}
?>


