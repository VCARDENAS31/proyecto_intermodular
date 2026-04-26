<?php

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