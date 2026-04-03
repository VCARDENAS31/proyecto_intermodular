<?php
session_start();

if (isset($_GET['id'])) {
    unset($_SESSION['carrito'][$_GET['id']]);
}

echo json_encode([
    "ok" => true,
    "carrito" => $_SESSION['carrito']
]);