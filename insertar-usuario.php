<?php
include 'conexion-bd.php';

//Iniciar sesión para poder leer los datos del usuario logueado
session_start();

//Comprobar si el usuario tiene permiso (debe ser admin)
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin, lo mandamos al login o mostramos error
    die("Acceso denegado: No tienes permisos para realizar esta acción.");
}

// Recoger datos del formulario
$nombre    = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$email     = $_POST['email'];
$pass      = $_POST['password']; // En un entorno real, usa password_hash()
$rol       = $_POST['rol'];

// Consulta SQL para insertar en la tabla 'usuarios'
$sql = "INSERT INTO usuarios (nombre, apellidos, email, contraseña, rol) 
        VALUES ('$nombre', '$apellidos', '$email', '$pass', '$rol')";

if (mysqli_query($conexion, $sql)) {
    // Redirigir a la gestión de usuarios si tiene éxito
    header("Location: gestionarUsuarios.php?res=success");
} else {
    // Mostrar error si el email ya existe (es UNIQUE en tu BD)
    echo "Error: " . mysqli_error($conexion);
    echo "<br><a href='insertar-usuario.html'>Intentar de nuevo</a>";
}

mysqli_close($conexion);
?>