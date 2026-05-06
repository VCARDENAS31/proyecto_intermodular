<?php
// Define la función buscarProductos para realizar búsquedas de productos en la tienda
function buscarProductos($conexion, $busqueda) {

    // Normaliza la búsqueda: elimina espacios al principio/final y convierte todo a minúsculas
    $busqueda = strtolower(trim($busqueda));

    // Mapa de términos relacionados para unificar búsquedas
    // Ejemplo: 'juegos' y 'juego' se tratan como el mismo tipo
    $mapa = [
        'juegos' => 'juego',
        'juego' => 'juego',
        'consolas' => 'consola',
        'consola' => 'consola',
        'accesorios' => 'accesorio',
        'accesorio' => 'accesorio',

        'playstation' => 'ps5',
        'play' => 'ps5',
        'ps5' => 'ps5',
        'xbox' => 'xbox',
        'nintendo switch' => 'switch',
        'nintendo' => 'switch'
    ];

    // Aplica el mapa de sinónimos a la cadena de búsqueda
    foreach ($mapa as $key => $value) {
        $busqueda = str_replace($key, $value, $busqueda);
    }

    // Separa la búsqueda en palabras y elimina entradas vacías
    $palabras = array_filter(explode(" ", $busqueda));

    // Variables para almacenar tipo de producto y plataforma detectados
    $tipo = null;
    $plataforma = null;

    // Recorre cada palabra para encontrar coincidencias de tipo y plataforma
    foreach ($palabras as $p) {
        if (in_array($p, ['juego', 'consola', 'accesorio'])) {
            // Si la palabra corresponde a un tipo de producto, la guarda en $tipo
            $tipo = $p;
        }
        if (in_array($p, ['ps5', 'xbox', 'switch'])) {
            // Si la palabra corresponde a una plataforma, la guarda en $plataforma
            $plataforma = $p;
        }
    }

    // Inicia la consulta SQL básica
    $sql = "SELECT * FROM productos WHERE 1=1";

    if ($tipo) {
        // Si se detectó tipo, añade esa condición a la consulta
        $sql .= " AND LOWER(tipo) LIKE '%$tipo%'";
    }

    if ($plataforma) {
        // Si se detectó plataforma, añade esa condición a la consulta
        $sql .= " AND LOWER(plataforma) LIKE '%$plataforma%'";
    }

    // Lista de condiciones adicionales basadas en el resto de palabras de búsqueda
    $condiciones = [];

    foreach ($palabras as $p) {
        // Omite palabras que ya se usaron como tipo o plataforma
        if ($p == $tipo || $p == $plataforma) continue;

        // Agrega condiciones para buscar por nombre o categoría del producto
        $condiciones[] = "
            LOWER(nombre) LIKE '%$p%' OR
            LOWER(categoria) LIKE '%$p%'
        ";
    }

    if (!empty($condiciones)) {
        // Si hay condiciones adicionales, las concatena con OR en una cláusula AND
        $sql .= " AND (" . implode(" OR ", $condiciones) . ")";
    }

    // Ejecuta la consulta y devuelve el resultado de la búsqueda
    return mysqli_query($conexion, $sql);
}

?>