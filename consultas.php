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

function obtenerJuegosPorPlataforma($conexion, $plataforma)
{
    // 1. Preparamos la consulta con un placeholder (?)
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Juego'";

    $stmt = mysqli_prepare($conexion, $sql);

    // 2. Vinculamos el parámetro (s = string)
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // 3. Ejecutamos
    mysqli_stmt_execute($stmt);

    // 4. Obtenemos el resultado
    $resultado = mysqli_stmt_get_result($stmt);

    return $resultado;
}

function obtenerConsolasPorPlataforma($conexion, $plataforma)
{
    // 1. Preparamos la consulta con un placeholder (?)
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Consola'";

    $stmt = mysqli_prepare($conexion, $sql);

    // 2. Vinculamos el parámetro (s = string)
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // 3. Ejecutamos
    mysqli_stmt_execute($stmt);

    // 4. Obtenemos el resultado
    $resultado = mysqli_stmt_get_result($stmt);

    return $resultado;
}


function obtenerAccesoriosPorPlataforma($conexion, $plataforma)
{
    // 1. Preparamos la consulta con un placeholder (?)
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Accesorio'";

    $stmt = mysqli_prepare($conexion, $sql);

    // 2. Vinculamos el parámetro (s = string)
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // 3. Ejecutamos
    mysqli_stmt_execute($stmt);

    // 4. Obtenemos el resultado
    $resultado = mysqli_stmt_get_result($stmt);

    return $resultado;
}


function obtenerUltimosJuegosIntercalados($conexion)
{
    // Definimos las plataformas exactamente como están en tu base de datos
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    $estantes = [];
    $nombresVistos = [];
    $listaFinal = [];

    // 1. Forzamos a SQL a buscar los más nuevos de CADA consola por separado
    foreach ($plataformas as $plataforma) {
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Juego' AND plataforma = '$plataforma' 
                ORDER BY id_producto DESC 
                LIMIT 20"; // Traemos 20 de cada una para tener margen
        
        $resultado = mysqli_query($conexion, $sql);
        $estantes[$plataforma] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // 2. Lógica de intercalado (Round Robin)
    // Queremos 18 juegos en total (6 de cada consola si hay suficientes)
    for ($i = 0; $i < 20; $i++) { 
        foreach ($plataformas as $p) {
            if (isset($estantes[$p][$i])) {
                $juego = $estantes[$p][$i];
                $nombreLimpio = strtolower(trim($juego['nombre']));

                // Evitamos duplicados (si el mismo juego está en PS5 y Xbox)
                if (!in_array($nombreLimpio, $nombresVistos)) {
                    $listaFinal[] = $juego;
                    $nombresVistos[] = $nombreLimpio;
                }
            }
            // Si ya llegamos a 18, dejamos de buscar
            if (count($listaFinal) >= 18) break 2; 
        }
    }

    return $listaFinal;
}

function obtenerUltimas18Consolas($conexion)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola'
            ORDER BY id_producto DESC
            LIMIT 18";
    $resultado = mysqli_query($conexion, $sql);
    return $resultado;
}

function obtenerUltimos18JuegosPorPlataforma($conexion, $plataforma)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 18";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return $resultado;
}

function obtenerUltimas8consolasPorPlataforma($conexion, $plataforma)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 8";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
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

function obtenerUltimos10AccesoriosPorPlataforma($conexion, $plataforma)
{
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Accesorio' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 10";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return $resultado;
}


?>