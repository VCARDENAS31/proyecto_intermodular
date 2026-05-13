<?php
// ProductoDAO: funciones para gestionar productos en la base de datos

function obtenerProductos($conexion)
{
    // Construye la consulta SQL para seleccionar todos los productos
    $sql = "SELECT * FROM productos";
    // Ejecuta la consulta y retorna el resultado
    return mysqli_query($conexion, $sql);
}

function buscarProductoPorId($conexion, $id)
{
    // Construye la consulta preparada para buscar un producto por ID
    $sql = "SELECT * FROM productos WHERE id_producto = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID como entero
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}

function obtenerProductoPorId($conexion, $id)
{
    // Construye la consulta preparada para obtener un producto por ID
    $sql = "SELECT * FROM productos WHERE id_producto = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID como entero
    mysqli_stmt_bind_param($stmt, "i", $id);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado y lo convierte a array asociativo
    $res = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($res);
}


function insertarProducto($conexion, $nombre, $precio, $stock, $tipo, $categoria, $descripcion, $plataforma, $imagen, $slug, $tieneLector, $almacenamiento)
{
    // Construye la consulta preparada para insertar un nuevo producto
    $sql = "INSERT INTO productos 
            (nombre, precio, stock, tipo, categoria, descripcion, plataforma, img_url, slug, tieneLector, almacenamiento) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincula los parámetros con sus tipos: string, double, int, string, string, string, string, string, string
    mysqli_stmt_bind_param(
        $stmt,
        "sdissssssis",
        $nombre,
        $precio,
        $stock,
        $tipo,
        $categoria,
        $descripcion,
        $plataforma,
        $imagen,
        $slug,
        $tieneLector,
        $almacenamiento
    );

    // Ejecuta la inserción y retorna el resultado
    return mysqli_stmt_execute($stmt);
}

function existeSlug($conexion, $slug)
{
    // Construye la consulta preparada para verificar si un slug existe
    $sql = "SELECT COUNT(*) as total FROM productos WHERE slug = ?";
    
    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el slug como string
    mysqli_stmt_bind_param($stmt, "s", $slug);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado y lo convierte a array asociativo
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);

    // Retorna true si el total es mayor a 0, indicando que el slug existe
    return $row['total'] > 0;
}


function eliminarProducto($conexion, $id)
{
    // Construye la consulta preparada para eliminar un producto por ID
    $sql = "DELETE FROM productos WHERE id_producto = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID como entero
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Ejecuta la eliminación y retorna el resultado
    return mysqli_stmt_execute($stmt);
}

function actualizarProducto(
    $conexion,
    $id,
    $nombre,
    $precio,
    $stock,
    $descripcion,
    $tieneLector,
    $almacenamiento
) {

    // Convierte el ID a entero para mayor seguridad
    $id = intval($id);

    // Escapa el nombre para evitar inyección SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);

    // Escapa la descripción para evitar inyección SQL
    $descripcion = mysqli_real_escape_string($conexion, $descripcion);

    // Escapa el valor de tieneLector
    $tieneLector = mysqli_real_escape_string($conexion, $tieneLector);

    // Escapa el valor de almacenamiento
    $almacenamiento = mysqli_real_escape_string($conexion, $almacenamiento);

    // Convierte el precio a float, reemplazando comas por puntos si es necesario
    $precio = floatval(str_replace(',', '.', $precio));

    // Convierte el stock a entero
    $stock = intval($stock);

    // Construye la consulta SQL para actualizar el producto
    $sql = "UPDATE productos SET 
                nombre = '$nombre',
                precio = $precio,
                stock = $stock,
                descripcion = '$descripcion',
                tieneLector = '$tieneLector',
                almacenamiento = '$almacenamiento'
            WHERE id_producto = $id";

    // Ejecuta la actualización y retorna el resultado
    return mysqli_query($conexion, $sql);
}


function obtenerJuegosPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener juegos de una plataforma específica
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Juego'";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Retorna el resultado
    return $resultado;
}


function obtenerAccesoriosPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener accesorios de una plataforma específica
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Accesorio'";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Retorna el resultado
    return $resultado;
}



function obtenerConsolasPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener consolas de una plataforma específica
    $sql = "SELECT * FROM productos WHERE plataforma = ? AND tipo = 'Consola'";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);

    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Retorna el resultado
    return $resultado;
}


function obtenerJuegosPorPlataformaFiltrados($conexion, $plataforma, $categoria = null, $precio = null)
{
    // Construye la consulta base para juegos de una plataforma
    $sql = "SELECT * FROM productos WHERE tipo = 'Juego' AND plataforma = ?";

    // Inicializa arrays para parámetros y tipos
    $params = [$plataforma];
    $types = "s";

    if ($categoria) {
        // Si hay categoría, añade la condición a la consulta
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
        $types .= "s";
    }

    if ($precio) {
        // Si hay filtro de precio, añade la condición correspondiente
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

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros con sus tipos
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}

// ACCESORIOS FILTRADOS
function obtenerAccesoriosPorPlataformaFiltrados($conexion, $plataforma, $categoria = null, $precio = null)
{
    // Construye la consulta base para accesorios de una plataforma
    $sql = "SELECT * FROM productos WHERE tipo = 'Accesorio' AND plataforma = ?";

    // Inicializa arrays para parámetros y tipos
    $params = [$plataforma];
    $types = "s";

    if ($categoria) {
        // Si hay categoría, añade la condición a la consulta
        $sql .= " AND categoria = ?";
        $params[] = $categoria;
        $types .= "s";
    }

    if ($precio) {
        // Si hay filtro de precio, añade la condición correspondiente
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

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros con sus tipos
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}


// CONSOLAS FILTRADAS
function obtenerConsolasFiltradas($conexion, $plataforma, $precio = null, $tieneLector = null, $almacenamiento = null)
{
    // Construye la consulta base para consolas de una plataforma
    $sql = "SELECT * FROM productos WHERE tipo = 'Consola' AND plataforma = ?";
    // Inicializa arrays para parámetros y tipos
    $params = [$plataforma];
    $types = "s";

    if (!empty($precio)) {
        // Si hay filtro de precio, añade la condición correspondiente
        if ($precio == "0-400") {
            $sql .= " AND precio < 400";
        } elseif ($precio == "400-600") {
            $sql .= " AND precio BETWEEN 400 AND 600";
        } elseif ($precio == "+600") {
            $sql .= " AND precio > 600";
        }
    }

    if ($tieneLector !== null) {
        // Si hay filtro de lector, añade la condición
        $sql .= " AND tieneLector = ?";
        $params[] = $tieneLector;
        $types .= "i";
    }

    if (!empty($almacenamiento)) {
        // Si hay filtro de almacenamiento, añade la condición
        $sql .= " AND almacenamiento = ?";
        $params[] = $almacenamiento;
        $types .= "s";
    }

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula los parámetros con sus tipos
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Retorna el resultado de la consulta
    return mysqli_stmt_get_result($stmt);
}


function obtenerRecomendadosAleatorios($conexion, $plataforma, $id_actual, $tipo)
{
    // Construye la consulta para obtener productos recomendados aleatorios
    $sql = "SELECT * FROM productos 
            WHERE plataforma = '$plataforma' 
            AND id_producto != '$id_actual' AND tipo = '$tipo' 
            ORDER BY RAND() 
            LIMIT 10";

    // Ejecuta la consulta
    $resultado = mysqli_query($conexion, $sql);
    // Retorna todos los resultados como array asociativo
    return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
}


function obtenerUltimosJuegosIntercalados($conexion)
{
    // Define las plataformas a considerar
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    // Inicializa array para almacenar estantes por plataforma
    $estantes = [];
    // Inicializa array para nombres ya vistos
    $nombresVistos = [];
    // Inicializa array para la lista final
    $listaFinal = [];

    foreach ($plataformas as $plataforma) {
        // Construye la consulta para obtener los últimos juegos de cada plataforma
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Juego' AND plataforma = '$plataforma' 
                ORDER BY id_producto DESC 
                LIMIT 20"; 

        // Ejecuta la consulta
        $resultado = mysqli_query($conexion, $sql);
        // Almacena los resultados en el estante correspondiente
        $estantes[$plataforma] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }


    for ($i = 0; $i < 20; $i++) {
        // Itera sobre cada posición en los estantes
        foreach ($plataformas as $p) {
            // Para cada plataforma, verifica si hay un juego en esa posición
            if (isset($estantes[$p][$i])) {
                $juego = $estantes[$p][$i];
                // Limpia el nombre del juego para comparación
                $nombreLimpio = strtolower(trim($juego['nombre']));

                if (!in_array($nombreLimpio, $nombresVistos)) {
                    // Si el nombre no ha sido visto, lo añade a la lista final
                    $listaFinal[] = $juego;
                    $nombresVistos[] = $nombreLimpio;
                }
            }
            if (count($listaFinal) >= 18)
                // Si ya hay 18 juegos, rompe los bucles
                break 2;
        }
    }

    // Retorna la lista final de juegos intercalados
    return $listaFinal;
}

function obtenerUltimosAccesoriosIntercalados($conexion)
{
    // Define las plataformas a considerar
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    // Inicializa array para almacenar estantes por plataforma
    $estantes = [];
    // Inicializa array para la lista final
    $listaFinal = [];

    foreach ($plataformas as $p) {
        // Construye la consulta para obtener los últimos accesorios de cada plataforma
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Accesorio' AND plataforma = '$p' 
                ORDER BY id_producto DESC 
                LIMIT 20";

        // Ejecuta la consulta
        $resultado = mysqli_query($conexion, $sql);
        // Almacena los resultados en el estante correspondiente
        $estantes[$p] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    for ($i = 0; $i < 20; $i++) {
        // Itera sobre cada posición en los estantes
        foreach ($plataformas as $p) {
            // Para cada plataforma, verifica si hay un accesorio en esa posición
            if (isset($estantes[$p][$i])) {
                // Añade el accesorio a la lista final
                $listaFinal[] = $estantes[$p][$i];
            }
            if (count($listaFinal) >= 18)
                // Si ya hay 18 accesorios, rompe los bucles
                break 2;
        }
    }

    // Retorna la lista final de accesorios intercalados
    return $listaFinal;
}


function obtenerUltimasConsolasIntercaladas($conexion)
{
    // Define las plataformas a considerar
    $plataformas = ['PS5', 'Xbox', 'Switch'];
    // Inicializa array para almacenar estantes por plataforma
    $estantes = [];
    // Inicializa array para la lista final
    $listaFinal = [];

    foreach ($plataformas as $p) {
        // Construye la consulta para obtener las últimas consolas de cada plataforma
        $sql = "SELECT * FROM productos 
                WHERE tipo = 'Consola' AND plataforma = '$p' 
                ORDER BY id_producto DESC";

        // Ejecuta la consulta
        $resultado = mysqli_query($conexion, $sql);
        // Almacena los resultados en el estante correspondiente
        $estantes[$p] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    for ($i = 0; $i < 10; $i++) {
        // Itera sobre cada posición en los estantes
        foreach ($plataformas as $p) {
            // Para cada plataforma, verifica si hay una consola en esa posición
            if (isset($estantes[$p][$i])) {
                // Añade la consola a la lista final
                $listaFinal[] = $estantes[$p][$i];
            }
        }
    }

    // Retorna la lista final de consolas intercaladas
    return $listaFinal;
}


function obtenerUltimos18JuegosPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener los últimos 18 juegos de una plataforma
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Juego' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 18";
    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);
    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);
    // Retorna el resultado
    return $resultado;
}

function obtenerUltimas8consolasPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener las últimas 8 consolas de una plataforma
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Consola' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 8";
    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);
    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);
    // Retorna el resultado
    return $resultado;
}

function obtenerUltimos10AccesoriosPorPlataforma($conexion, $plataforma)
{
    // Construye la consulta preparada para obtener los últimos 10 accesorios de una plataforma
    $sql = "SELECT * FROM productos 
            WHERE tipo = 'Accesorio' AND plataforma = ?
            ORDER BY id_producto DESC
            LIMIT 10";
    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula la plataforma como string
    mysqli_stmt_bind_param($stmt, "s", $plataforma);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);
    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);
    // Retorna el resultado
    return $resultado;
}

function obtenerProductoPorSlug($conexion, $slug)
{
    // Construye la consulta preparada para obtener un producto por su slug
    $sql = "SELECT * FROM productos WHERE slug = ?";
    
    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el slug como string
    mysqli_stmt_bind_param($stmt, "s", $slug);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

    // Retorna el primer registro como array asociativo
    return mysqli_fetch_assoc($resultado);
}



function obtenerStockProducto($conexion, $id_producto)
{
    // Construye la consulta preparada para obtener el stock de un producto
    $sql = "SELECT stock FROM productos WHERE id_producto = ?";

    // Prepara la sentencia SQL
    $stmt = mysqli_prepare($conexion, $sql);
    // Vincula el ID del producto como entero
    mysqli_stmt_bind_param($stmt, "i", $id_producto);
    // Ejecuta la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtiene el resultado y lo convierte a array asociativo
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);

    // Retorna el valor del stock
    return $row['stock'];
}
?>