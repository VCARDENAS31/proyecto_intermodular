<?php
include 'conexion-bd.php';
session_start();

// Seguridad básica de rol
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // 1. Eliminar al usuario (y sus datos relacionados en carrito para evitar errores)
    mysqli_query($conexion, "DELETE FROM carrito WHERE usuario_id = $id");
    
    if (mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario = $id")) {
        
        // --- INICIO DEL REORDENAMIENTO ---
        
        // 2. Reiniciar una variable de contador en MySQL
        mysqli_query($conexion, "SET @count = 0");
        
        // 3. Actualizar todos los IDs para que sean correlativos (1, 2, 3...)
        mysqli_query($conexion, "UPDATE usuarios SET id_usuario = (@count := @count + 1)");
        
        // 4. Ajustar el valor de AUTO_INCREMENT al siguiente número disponible
        $resultado = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM usuarios");
        $fila = mysqli_fetch_array($resultado);
        $proximo_id = $fila[0] + 1;
        mysqli_query($conexion, "ALTER TABLE usuarios AUTO_INCREMENT = $proximo_id");
        
        // --- FIN DEL REORDENAMIENTO ---

        header("Location: gestionarUsuarios.php?msj=Usuario++eliminado+correctamente");
    } else {
        echo "Error al eliminar. Es posible que el usuario tenga pedidos activos.";
    }
}
?>