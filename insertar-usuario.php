<?php
include 'conexion-bd.php';

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