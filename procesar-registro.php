<?php
session_start();

include('conexion-bd.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recoger datos
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
        header("Location: registro.php");
        exit();
    }

    // ==============================
    // VALIDAR EMAIL
    // ==============================
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_registro'] = "Email no válido.";
        header("Location: registro.php");
        exit();
    }

    // ==============================
    // ENCRIPTAR CONTRASEÑA
    // ==============================
    $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

    // ==============================
    // INSERTAR USUARIO
    // ==============================
    $sql = "INSERT INTO usuarios (email, contraseña, nombre, apellidos, rol) 
            VALUES (?, ?, ?, ?, 'user')";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_segura, $nombre, $apellidos);

    try {
        mysqli_stmt_execute($stmt);

        // Registro correcto
        header("Location: login.php?registro=exito");
        exit();

    } catch (mysqli_sql_exception $e) {

        // EMAIL DUPLICADO
        if ($e->getCode() == 1062) {
            $_SESSION['error_registro'] = "El correo ya está registrado.";
        } else {
            $_SESSION['error_registro'] = "Error al registrar usuario.";
        }

        header("Location: registro.php");
        exit();
    }
}