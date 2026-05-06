<?php
// Inicia el bloque de código PHP para el script de cambio de estado de pedidos

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/pedidoDAO.php';
// Incluye el DAO (Data Access Object) de pedidos que contiene funciones como actualizarEstadoPedido

if (isset($_POST['id_pedido']) && isset($_POST['estado'])) {
    // Verifica si ambos parámetros POST están presentes: id_pedido y estado

    $id = $_POST['id_pedido'];
    // Obtiene el ID del pedido del formulario POST

    $estado = $_POST['estado'];
    // Obtiene el nuevo estado del pedido del formulario POST

    actualizarEstadoPedido($conexion, $id, $estado);
    // Llama a la función del DAO para actualizar el estado del pedido en la base de datos
}

header("Location: gestionar-pedidos.php");
// Redirige a la página de gestión de pedidos después de procesar el cambio de estado

exit();
// Termina la ejecución del script después de la redirección
?>