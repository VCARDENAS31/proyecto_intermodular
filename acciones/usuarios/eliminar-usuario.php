<?php
//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

//Comprobar si el usuario tiene permiso (debe ser admin)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo mandamos al login o mostramos error
    die("Acceso denegado: No tienes permisos para realizar esta acción.");
}

include 'conexion-bd.php';
include 'consultas.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Llamamos a la función de consultas.php
    if (eliminarUsuario($conexion, $id)) {
        header("Location: gestionarUsuarios.php?msj=Eliminado");
        exit(); // Siempre usa exit después de un header Location
    } else {
        echo "No se pudo eliminar: El usuario tiene historial de pedidos.";
        echo "<br><a href='gestionarUsuarios.php'>Volver</a>";
    }
}
?>