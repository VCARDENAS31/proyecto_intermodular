<?php
// Inicia el archivo PHP y habilita el manejo de sesiones
session_start();

// Verifica si se ha recibido el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    // Elimina el producto del carrito de la sesión usando el ID proporcionado
    unset($_SESSION['carrito'][$_GET['id']]);
}

// Prepara una respuesta JSON con el estado de éxito y el contenido actual del carrito
echo json_encode([
    // Indica que la operación fue exitosa
    "ok" => true,
    // Incluye el contenido actualizado del carrito en la respuesta
    "carrito" => $_SESSION['carrito']
]);