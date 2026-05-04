<?php
function obtenerProductos($conexion)
{
    $sql = "SELECT * FROM productos";
    return mysqli_query($conexion, $sql);
}

function buscarProductoPorId($conexion, $id)
{
    $sql = "SELECT * FROM productos WHERE id_producto = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

/**
 * Obtener un producto específico por su ID
 *
 */
function obtenerProductoPorId($conexion, $id)
{
    $sql = "SELECT * FROM productos WHERE id_producto = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}


function insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $imagen, $slug)
{
    $sql = "INSERT INTO productos 
            (nombre, precio, stock, tipo, categoria, descripcion, plataforma, img_url, slug) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conexion, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sdissssss",
        $nombre,
        $precio,
        $stock,
        $tipo,
        $categoria,
        $descripcion,
        $plataforma,
        $imagen,
        $slug
    );

    return mysqli_stmt_execute($stmt);
}

function existeSlug($conexion, $slug)
{
    $sql = "SELECT COUNT(*) as total FROM productos WHERE slug = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);

    return $row['total'] > 0;
}


function eliminarProducto($conexion, $id)
{
    $sql = "DELETE FROM productos WHERE id_producto = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}



/**
 * Actualizar datos de un producto (URL de imagen como texto)
 */
function actualizarProducto($conexion, $id, $nombre, $precio, $stock, $descripcion)
{
    $id = intval($id);
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);

    $precio = floatval(str_replace(',', '.', $precio));
    $stock = intval($stock);

    $sql = "UPDATE productos SET 
                nombre = '$nombre',
                precio = $precio,
                stock = $stock,
                descripcion = '$descripcion'
            WHERE id_producto = $id";

    return mysqli_query($conexion, $sql);
}


/**
 * ************************************
 *
 * Funciones para obtener productos por plataforma y tipo (juegos o accesorios)
 * 
 * ************************************ 
 */


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


/**
 * ************************************
 *
 * Funciones para obtener productos por plataforma y tipo (juegos o accesorios) con filtros de categoría y precio
 * 
 * ************************************ 
 */


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


// 🔥 CONSOLAS FILTRADAS
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


/**
 * ************************************
 *
 * Recomendados
 * 
 * ************************************ 
 */


function obtenerRecomendadosAleatorios($conexion, $plataforma, $id_actual, $tipo)
{
    // Buscamos 10 productos aleatorios de la misma plataforma, excluyendo el actual
    $sql = "SELECT * FROM productos 
            WHERE plataforma = '$plataforma' 
            AND id_producto != '$id_actual' AND tipo = '$tipo' 
            ORDER BY RAND() 
            LIMIT 10";

    $resultado = mysqli_query($conexion, $sql);
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}

/**
 * ************************************
 *
 * INTERCALADOS
 * 
 * ************************************ 
 */

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


/**
 * ************************************
 *
 * OBTENER ÚLTIMOS PRODUCTOS (ACCESORIOS, JUEGOS Y CONSOLAS) DE CADA PLATAFORMA
 * 
 * ************************************ 
 */

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


/**
 * ************************************
 *
 * OBTENER PRODUCTOS POR SLUG (URL amigable)
 * 
 * ************************************ 
 */

function obtenerProductoPorSlug($conexion, $slug)
{
    $sql = "SELECT * FROM productos WHERE slug = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($resultado);
}



/**
 * ************************************
 *
 * OBTENER STOCK PRODUCTO
 * 
 * ************************************ 
 */



function obtenerStockProducto($conexion, $id_producto)
{
    $sql = "SELECT stock FROM productos WHERE id_producto = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_producto);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);

    return $row['stock'];
}
?>