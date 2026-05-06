<?php

// FUNCIONES AUXILIARES PARA LA TIENDA VICIOGAMES

/**
 * Verifica si hay un usuario logueado en la sesión
 */
function usuarioLogueado() {
    return isset($_SESSION['usuario_id']);
}

/**
 * Redirige al usuario a una ruta específica */
function redirigir($ruta) {
    header("Location: " . $ruta);
    exit;
}

/**
 * Verifica si el usuario actual tiene rol de administrador
 * retorna True si el rol en sesión es 'admin'
 */
function esAdmin() {
    return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
}

/**
 * Maneja el acceso denegado redirigiendo a página de error 404
 * Usado cuando un usuario intenta acceder a recursos sin permisos
 */
function accesoDenegado() {
    header("Location: error-404");
    exit;
}

?>