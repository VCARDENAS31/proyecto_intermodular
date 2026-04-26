<?php
session_start();

// Conexión a la BD (ruta correcta desde acciones/login/)
require_once __DIR__ . '/../../dao/conexion-bd.php';


// Mostrar errores de MySQL (opcional, útil en desarrollo)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ==============================
    // RECOGER DATOS
    // ==============================
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password_plana = $_POST['password'];

    // ==============================
    // VALIDACIÓN CONTRASEÑA
    // ==============================
    if (
        strlen($password_plana) < 5 ||
        !preg_match('/[A-Z]/', $password_plana) ||
        !preg_match('/[\W_]/', $password_plana)
    ) {
        $_SESSION['error_registro'] = "La contraseña debe tener mínimo 5 caracteres, una mayúscula y un carácter especial.";
        header("Location: /registro");
        exit();
    }

    // ==============================
    // VALIDAR EMAIL
    // ==============================
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_registro'] = "Email no válido.";
        header("Location: /registro");
        exit();
    }

    // ==============================
    // ENCRIPTAR CONTRASEÑA
    // ==============================
    $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

    // ==============================
    // INSERTAR USUARIO
    // ==============================
    $sql = "INSERT INTO usuarios (email, contrasena, nombre, apellidos, rol) 
            VALUES (?, ?, ?, ?, 'user')";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_segura, $nombre, $apellidos);

    try {
        mysqli_stmt_execute($stmt);

        // MENSAJE DE ÉXITO
        $_SESSION['exito_registro'] = "Usuario creado correctamente. Ya puedes iniciar sesión.";

        // Redirigir al login (URL limpia)
        header("Location: /login");
        exit();

    } catch (mysqli_sql_exception $e) {

        // ==============================
        // CONTROL DE ERRORES
        // ==============================
        if ($e->getCode() == 1062) {
            $_SESSION['error_registro'] = "El correo ya está registrado.";
        } else {
            $_SESSION['error_registro'] = "Error al registrar usuario.";
        }

        header("Location: /registro");
        exit();
    }
}