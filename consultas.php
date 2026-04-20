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


function obtenerCupon($conexion, $codigo)
{
    $stmt = $conexion->prepare("
        SELECT * FROM cupones 
        WHERE codigo = ? 
        AND activo = 1 
        AND fecha_caducidad >= CURDATE()
    ");
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function cuponUsado($conexion, $id_usuario, $id_cupon)
{
    $stmt = $conexion->prepare("
        SELECT * FROM cupones_usuarios 
        WHERE id_usuario = ? AND id_cupon = ?
    ");
    $stmt->bind_param("ii", $id_usuario, $id_cupon);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}


function usuarioUsoCupon($conexion, $usuario_id, $cupon_id)
{
    $sql = "SELECT * FROM cupones_usuarios 
            WHERE id_usuario = $usuario_id AND id_cupon = $cupon_id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_num_rows($res) > 0;
}

function guardarUsoCupon($conexion, $usuario_id, $cupon_id)
{
    $sql = "INSERT INTO cupones_usuarios (id_usuario, id_cupon)
            VALUES ($usuario_id, $cupon_id)";
    mysqli_query($conexion, $sql);
}


function obtenerCupones($conexion)
{
    $sql = "SELECT * FROM cupones ORDER BY id_cupon DESC";
    return mysqli_query($conexion, $sql);
}


// Obtener cupón por ID
function obtenerCuponPorId($conexion, $id)
{
    $id = intval($id);
    $sql = "SELECT * FROM cupones WHERE id_cupon = $id";
    $res = mysqli_query($conexion, $sql);
    return mysqli_fetch_assoc($res);
}

// Insertar cupón
function insertarCupon($conexion, $codigo, $descuento, $fecha, $activo)
{
    $sql = "INSERT INTO cupones (codigo, descuento_porcentaje, fecha_caducidad, activo)
            VALUES ('$codigo', $descuento, '$fecha', $activo)";
    return mysqli_query($conexion, $sql);
}

// Actualizar cupón
function actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo)
{
    $id = intval($id);

    $sql = "UPDATE cupones SET
            codigo = '$codigo',
            descuento_porcentaje = $descuento,
            fecha_caducidad = '$fecha',
            activo = $activo
            WHERE id_cupon = $id";

    return mysqli_query($conexion, $sql);
}

// Eliminar cupón
function eliminarCupon($conexion, $id)
{
    $id = intval($id);
    $sql = "DELETE FROM cupones WHERE id_cupon = $id";
    return mysqli_query($conexion, $sql);
}
function desactivarCuponesCaducados($conexion)
{
    $sql = "UPDATE cupones 
            SET activo = 0 
            WHERE fecha_caducidad < CURDATE() 
            AND activo = 1";
    mysqli_query($conexion, $sql);
}

function obtenerStockProducto($conexion, $id_producto)
{
    $sql = "SELECT stock FROM productos WHERE id_producto = $id_producto";
    $res = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row['stock'];
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
function actualizarProducto($conexion, $id, $nombre, $precio, $stock, $plataforma, $img_url)
{
    $id = intval($id);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $plataforma = mysqli_real_escape_string($conexion, $plataforma);

    $precio = floatval(str_replace(',', '.', $precio));
    $stock = intval($stock);

    $sql = "UPDATE productos SET 
                nombre = '$nombre',
                precio = $precio,
                stock = $stock,
                plataforma = '$plataforma',
                img_url = '$img_url'
            WHERE id_producto = $id";

    return mysqli_query($conexion, $sql);
}

function actualizarUsuarioConPassword($conexion, $id, $nombre, $apellidos, $email, $rol, $password)
{
    $id = intval($id);

    $sql = "UPDATE usuarios SET 
            nombre = '$nombre', 
            apellidos = '$apellidos', 
            email = '$email', 
            rol = '$rol',
            contraseña = '$password'
            WHERE id_usuario = $id";

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


function obtenerProductos($conexion)
{
    $sql = "SELECT * FROM productos";
    return mysqli_query($conexion, $sql);
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


function obtenerRecomendadosAleatorios($conexion, $plataforma, $id_actual)
{
    // Buscamos 10 productos aleatorios de la misma plataforma, excluyendo el actual
    $sql = "SELECT * FROM productos 
            WHERE plataforma = '$plataforma' 
            AND id_producto != '$id_actual' 
            ORDER BY RAND() 
            LIMIT 10";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
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


// 🔥 JUEGOS FILTRADOS (GENÉRICO)
function obtenerJuegosPorPlataformaFiltrados($conexion, $plataforma, $categoria = null, $precio = null)
{
    $sql = "SELECT * FROM productos WHERE tipo = 'Juego' AND plataforma = ?";

    $params = [$plataforma];
    $types = "s";

    if ($categoria) {
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
        $types .= "s";
    }

    if ($precio) {

        if ($precio == "0-20") {
            $sql .= " AND precio < ?";
            $params[] = 20;
            $types .= "i";
        }

        if ($precio == "20-50") {
            $sql .= " AND precio BETWEEN ? AND ?";
            $params[] = 20;
            $params[] = 50;
            $types .= "ii";
        }

        if ($precio == "50+") {
            $sql .= " AND precio > ?";
            $params[] = 50;
            $types .= "i";
        }
    }

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}


function obtenerConsolasFiltradas($conexion, $plataforma, $precio = null, $tieneLector = null, $almacenamiento = null)
{
    $sql = "SELECT * FROM productos WHERE tipo = 'Consola' AND plataforma = ?";
    $params = [$plataforma];
    $types = "s";

    if (!empty($precio)) {
        if ($precio == "0-400") {
            $sql .= " AND precio < 400";
        } elseif ($precio == "400-600") {
            $sql .= " AND precio BETWEEN 400 AND 600";
        } elseif ($precio == "+600") {
            $sql .= " AND precio > 600";
        }
    }

    if ($tieneLector !== null) {
        $sql .= " AND tieneLector = ?";
        $params[] = $tieneLector;
        $types .= "i";
    }

    if (!empty($almacenamiento)) {
        $sql .= " AND almacenamiento = ?";
        $params[] = $almacenamiento;
        $types .= "s";
    }

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}




// 🔥 ACCESORIOS FILTRADOS
function obtenerAccesoriosPorPlataformaFiltrados($conexion, $plataforma, $categoria = null, $precio = null)
{
    $sql = "SELECT * FROM productos WHERE tipo = 'Accesorio' AND plataforma = ?";

    $params = [$plataforma];
    $types = "s";

    if ($categoria) {
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
        $types .= "s";
    }

    if ($precio) {

        if ($precio == "0-20") {
            $sql .= " AND precio < ?";
            $params[] = 20;
            $types .= "i";
        }

        if ($precio == "20-50") {
            $sql .= " AND precio BETWEEN ? AND ?";
            $params[] = 20;
            $params[] = 50;
            $types .= "ii";
        }

        if ($precio == "50+") {
            $sql .= " AND precio > ?";
            $params[] = 50;
            $types .= "i";
        }
    }

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
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
            if (count($listaFinal) >= 18)
                break 2;
        }
    }

    return $listaFinal;
}

function obtenerUltimosAccesoriosIntercalados($conexion)
{
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    $estantes = [];
    $listaFinal = [];

    // 1. Buscamos los últimos 20 accesorios de cada marca
    foreach ($plataformas as $p) {
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Accesorio' AND plataforma = '$p' 
                ORDER BY id_producto DESC 
                LIMIT 20";

        $resultado = mysqli_query($conexion, $sql);
        $estantes[$p] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // 2. Mezclamos 1 de cada una hasta completar 18 para el slider
    for ($i = 0; $i < 20; $i++) {
        foreach ($plataformas as $p) {
            if (isset($estantes[$p][$i])) {
                $listaFinal[] = $estantes[$p][$i];
            }
            if (count($listaFinal) >= 18)
                break 2;
        }
    }

    return $listaFinal;
}


function obtenerUltimasConsolasIntercaladas($conexion)
{
    // Mapeamos tus categorías a los valores de la columna 'plataforma'
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    $estantes = [];
    $listaFinal = [];

    // 1. Obtenemos las consolas de cada marca
    foreach ($plataformas as $p) {
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Consola' AND plataforma = '$p' 
                ORDER BY id_producto DESC";

        $resultado = mysqli_query($conexion, $sql);
        $estantes[$p] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // 2. Intercalamos: Una de Sony (PS5), una de Microsoft (Xbox), una de Nintendo (Switch)
    // Suponiendo que tienes un máximo de 10 modelos de consolas
    for ($i = 0; $i < 10; $i++) {
        foreach ($plataformas as $p) {
            if (isset($estantes[$p][$i])) {
                $listaFinal[] = $estantes[$p][$i];
            }
        }
    }

    return $listaFinal;
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



function buscarProductos($conexion, $busqueda) {

    $busqueda = strtolower(trim($busqueda));

    // NORMALIZACIÓN DE SINÓNIMOS
    $mapa = [
        // tipos
        'juegos' => 'juego',
        'juego' => 'juego',
        'consolas' => 'consola',
        'consola' => 'consola',
        'accesorios' => 'accesorio',
        'accesorio' => 'accesorio',

        // plataformas
        'playstation' => 'ps5',
        'play' => 'ps5',
        'ps5' => 'ps5',
        'xbox' => 'xbox',
        'nintendo switch' => 'switch',
        'nintendo' => 'switch'
    ];

    // aplicar mapa
    foreach ($mapa as $key => $value) {
        $busqueda = str_replace($key, $value, $busqueda);
    }

    // dividir palabras
    $palabras = array_filter(explode(" ", $busqueda));

    // detectar intención
    $tipo = null;
    $plataforma = null;

    foreach ($palabras as $p) {
        if (in_array($p, ['juego', 'consola', 'accesorio'])) {
            $tipo = $p;
        }
        if (in_array($p, ['ps5', 'xbox', 'switch'])) {
            $plataforma = $p;
        }
    }

    // QUERY BASE
    $sql = "SELECT * FROM productos WHERE 1=1";

    // FILTRO POR TIPO (MUY IMPORTANTE)
    if ($tipo) {
        $sql .= " AND LOWER(tipo) LIKE '%$tipo%'";
    }

    // FILTRO POR PLATAFORMA
    if ($plataforma) {
        $sql .= " AND LOWER(plataforma) LIKE '%$plataforma%'";
    }

    // BÚSQUEDA GENERAL POR PALABRAS RESTANTES
    $condiciones = [];

    foreach ($palabras as $p) {

        // evitar repetir filtros ya usados
        if ($p == $tipo || $p == $plataforma) continue;

        $condiciones[] = "
            LOWER(nombre) LIKE '%$p%' OR
            LOWER(categoria) LIKE '%$p%'
        ";
    }

    if (!empty($condiciones)) {
        $sql .= " AND (" . implode(" OR ", $condiciones) . ")";
    }

    return mysqli_query($conexion, $sql);
}
?>