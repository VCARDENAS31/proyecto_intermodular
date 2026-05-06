<?php
// Configuración de la conexión MySQL para el proyecto viciogames
$host = "localhost:3306";
// Host y puerto donde corre el servidor de base de datos

$user = "root";
// Usuario de la base de datos

$pass = "";
// Contraseña de la base de datos (vacía en entorno local)

$db = "bdtiendavideojuegos";
// Nombre de la base de datos usada por la tienda de videojuegos

// Establece la conexión con la base de datos usando mysqli
$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    // Si falla la conexión, detiene el script con un mensaje de error
    die("Error de conexión: " . mysqli_connect_error());
}
?>