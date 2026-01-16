<?php
// Inicia la sesión
session_start(); 

// Incluye la conexión a la base de datos
include('conexion-bd.php');

// Verifica que el formulario haya sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpia los datos recibidos desde el formulario
    $nombre = trim($_POST['nombre']);        
    $apellidos = trim($_POST['apellidos']);  
    $email = trim($_POST['email']);          
    $password_plana = $_POST['password'];    

    // Hashea la contraseña para almacenarla de manera segura en la base de datos
    $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

    // Consulta SQL para insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (email, contraseña, nombre, apellidos, rol) VALUES (?, ?, ?, ?, 'user')";
    
    // Prepara la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_segura, $nombre, $apellidos);

    try {
        mysqli_stmt_execute($stmt); // Inserta el usuario en la base de datos

        // Si todo sale bien, redirige al login con un mensaje de registro exitoso
        header("Location: login.php?registro=exito");
        exit();

    } catch (mysqli_sql_exception $e) {
        // Si ocurre un error, revisa si es por correo duplicado
        if ($e->getCode() == 1062) {
            $_SESSION['error_registro'] = "Error: El correo ya está registrado.";
        } else {
            // Para cualquier otro error, muestra el siguiente mensaje
            $_SESSION['error_registro'] = "Error al registrar usuario. Intente nuevamente.";
        }

        // Redirige al formulario de registro mostrando el mensaje de error
        header("Location: registro.php");
        exit();
    }
}
?>
