<?php
// Define la constante ROOT_PATH para usar rutas absolutas en el proyecto
// Usa $_SERVER['DOCUMENT_ROOT'] y agrega la barra final para asegurar rutas correctas
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/'); 

// Incluye helpers globales compartidos en todo el proyecto
// Contiene funciones de validación, permisos, y utilidades comunes
require_once ROOT_PATH . 'includes/helpers.php';
?>