<?php
// Inicia el bloque de código PHP para el script de procesamiento de pedidos

session_start();
// Inicia la sesión para acceder a variables del usuario, carrito y cupones

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/pedidoDAO.php';
// Incluye el DAO de pedidos con funciones para crear y gestionar pedidos

require_once ROOT_PATH . 'dao/cuponDAO.php';
// Incluye el DAO de cupones para validar y guardar uso de cupones

require_once ROOT_PATH . 'dao/productoDAO.php';
// Incluye el DAO de productos para verificar stock disponible

header('Content-Type: application/json');
// Establece el tipo de contenido de la respuesta como JSON

ini_set('display_errors', 0);
// Desactiva la visualización de errores en la salida

error_reporting(0);
// Desactiva el reporte de errores para mantener la salida limpia

function respuesta($ok, $msg = "", $extra = [])
// Define una función para devolver respuestas JSON estructuradas
{
    echo json_encode(array_merge([
        // Codifica en JSON un array con los parámetros de respuesta
        "ok" => $ok,
        // Indica si la operación fue exitosa (true/false)
        "msg" => $msg
        // Mensaje descriptivo de la respuesta
    ], $extra));
    // Fusiona con parámetros adicionales ($extra) si los hay
    exit();
    // Termina la ejecución del script después de enviar la respuesta
}

if (!isset($_SESSION['usuario_id'])) {
    // Verifica si el usuario está logueado verificando el ID en la sesión

    respuesta(false, "No logueado");
    // Si no está logueado, devuelve respuesta de error
}

if (empty($_SESSION['carrito'])) {
    // Verifica si el carrito de compras tiene productos

    respuesta(false, "Carrito vacío");
    // Si el carrito está vacío, devuelve respuesta de error
}

$usuario_id = $_SESSION['usuario_id'];
// Obtiene el ID del usuario de la sesión

$carrito = $_SESSION['carrito'];
// Obtiene el array de productos del carrito de la sesión

$nombre = $_POST['nombre'] ?? '';
// Obtiene el nombre del formulario o valor vacío si no existe

$apellidos = $_POST['apellidos'] ?? '';
// Obtiene los apellidos del formulario o valor vacío si no existe

$direccion = $_POST['direccion'] ?? '';
// Obtiene la dirección del formulario o valor vacío si no existe

$ciudad = $_POST['ciudad'] ?? '';
// Obtiene la ciudad del formulario o valor vacío si no existe

$cp = $_POST['cp'] ?? '';
// Obtiene el código postal del formulario o valor vacío si no existe

$telefono = $_POST['telefono'] ?? '';
// Obtiene el teléfono del formulario o valor vacío si no existe

$pago = $_POST['pago'] ?? '';
// Obtiene el método de pago del formulario o valor vacío si no existe

if ($nombre == '' || $apellidos == '' || $direccion == '' || $ciudad == '' || $cp == '' || $telefono == '' || $pago == '') {
    // Verifica que todos los campos requeridos hayan sido completados

    respuesta(false, "Datos incompletos");
    // Si faltan datos, devuelve respuesta de error
}

//Se concatenan datos para crear campos completos

$nombre_completo = $nombre . " " . $apellidos;
// Crea el nombre completo combinando nombre y apellidos

$direccion_completa = $direccion . ", " . $ciudad . " (" . $cp . ")";
// Crea la dirección completa combinando dirección, ciudad y código postal

// Se valida el método de pago
if (!in_array($pago, ['tarjeta', 'contra'])) {
    // Verifica si el método de pago está en la lista de opciones permitidas

    respuesta(false, "Método de pago inválido");
    // Si el método no es válido, devuelve respuesta de error
}

// Se calcula el total del pedido
$total = 0;
// Inicializa variable para acumular el total de la compra

foreach ($carrito as $producto) {
    // Itera sobre cada producto en el carrito

    $id_producto = $producto['id'] ?? $producto['id_producto'] ?? null;
    // Obtiene el ID del producto (soporta ambas claves posibles: 'id' o 'id_producto')

    if (!$id_producto) {
        // Verifica que el producto tenga un ID válido

        respuesta(false, "Producto inválido");
        // Si no hay ID válido, devuelve respuesta de error
    }

    $stockBD = obtenerStockProducto($conexion, $id_producto);
    // Obtiene del DAO el stock disponible del producto en la base de datos

    if ($producto['cantidad'] > $stockBD) {
        // Verifica si la cantidad solicitada no excede el stock disponible

        respuesta(false, "Sin stock de " . $producto['nombre']);
        // Si no hay suficiente stock, devuelve respuesta de error con el nombre del producto
    }

    $total += $producto['precio'] * $producto['cantidad'];
    // Suma al total el precio del producto multiplicado por la cantidad
}

// Procesamos y validamos el cupón de descuento

$cupon = $_SESSION['cupon'] ?? null;
// Obtiene el cupón aplicado de la sesión (si existe)

$descuento = 0;
// Inicializa variable para almacenar el descuento en dinero

$cupon_id = null;
// Inicializa variable para almacenar el ID del cupón

if ($cupon) {
    // Si hay un cupón aplicado, procesa su validación y descuento

    if (usuarioUsoCupon($conexion, $usuario_id, $cupon['id_cupon'])) {
        // Verifica si el usuario ya ha utilizado este cupón anteriormente

        respuesta(false, "Ya usaste este cupón");
        // Si ya lo utilizó, devuelve respuesta de error
    }

    $descuento = ($total * $cupon['descuento_porcentaje']) / 100;
    // Calcula el descuento en dinero basado en el porcentaje del cupón

    $cupon_id = $cupon['id_cupon'];
    // Almacena el ID del cupón para guardarlo en el pedido
}

$totalFinal = $total - $descuento + 2.99;
// Calcula el total final: total menos descuento más gastos de envío (2.99)

// Crea el pedido en la base de datos usando la función del DAO y obtiene su ID
$id_pedido = crearPedido(
    // Llama a la función del DAO para crear un nuevo pedido
    $conexion,
    // Pasa la conexión a la base de datos
    $usuario_id,
    // Pasa el ID del usuario propietario del pedido
    $carrito,
    // Pasa el array de productos del carrito
    $direccion_completa,
    // Pasa la dirección completa de envío
    $telefono,
    // Pasa el teléfono de contacto
    $totalFinal,
    // Pasa el total final a cobrar
    $cupon_id,
    // Pasa el ID del cupón aplicado (puede ser null)
    $nombre_completo,
    // Pasa el nombre completo del cliente
    $pago
    // Pasa el método de pago elegido
);

if (!$id_pedido) {
    // Verifica si la creación del pedido fue exitosa

    respuesta(false, "Error al crear pedido");
    // Si hay error, devuelve respuesta de error
}

if ($cupon_id) {
    // Si hay un cupón aplicado, registra su uso

    guardarUsoCupon($conexion, $usuario_id, $cupon_id);
    // Llama a la función del DAO para guardar que el usuario usó este cupón
}

$_SESSION['carrito'] = [];
// Vacía el carrito después de procesar el pedido

unset($_SESSION['cupon']);
// Elimina el cupón de la sesión después de usar

respuesta(true, "Pedido creado", [
    // Devuelve respuesta exitosa con el ID del pedido creado
    "pedido_id" => $id_pedido
    // Incluye el ID del pedido en la respuesta para confirmar su creación
]);