<?php

function usuarioLogueado() {
    return isset($_SESSION['usuario_id']);
}
function redirigir($ruta) {
    header("Location: " . $ruta);
    exit;
}

function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

function accesoDenegado() {
    header("Location: error-404");
    exit;
}

?>