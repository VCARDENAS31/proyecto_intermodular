<?php

// Inicia la sesión para acceder a los datos temporales del registro y al código de verificación
session_start();

// ================= CONFIGURACIÓN GENERAL =================
// Incluye el archivo de configuración principal
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// ================= CONEXIÓN A LA BASE DE DATOS =================
// Incluye la conexión MySQL
require_once ROOT_PATH . 'dao/conexion-bd.php';

// ================= VALIDAR MÉTODO POST =================
// Verifica que el formulario haya sido enviado correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ================= OBTENER CÓDIGO =================
    // Obtiene el código introducido por el usuario
    // y elimina espacios al inicio y final
    $codigoUsuario = trim($_POST['codigo']);

    // ================= VALIDAR SESIONES =================
    // Comprueba que existan los datos temporales
    // y el código de verificación en sesión
    if (
        !isset($_SESSION['codigo_verificacion']) ||
        !isset($_SESSION['registro_temp'])
    ) {

        // Si no existen, redirige al registro
        header("Location: registro");

        // Finaliza el script
        exit();
    }

    // ================= VALIDAR CÓDIGO =================
    // Comprueba si el código introducido coincide
    // con el código almacenado en sesión
    if ($codigoUsuario != $_SESSION['codigo_verificacion']) {

        // Guarda mensaje de error
        $_SESSION['error_codigo'] = "Código incorrecto.";

        // Redirige a la página de verificación
        header("Location: verificar-codigo");

        // Finaliza el script
        exit();
    }

    // ================= OBTENER DATOS TEMPORALES =================
    // Recupera los datos del usuario guardados en sesión
    $datos = $_SESSION['registro_temp'];

    // ================= INSERTAR USUARIO =================
    // Consulta SQL para insertar el nuevo usuario
    $sql = "INSERT INTO usuarios
    (email, contrasena, nombre, apellidos, rol)
    VALUES (?, ?, ?, ?, 'user')";

    // Preparar consulta
    $stmt = mysqli_prepare($conexion, $sql);

    // Vincular parámetros
    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $datos['email'],
        $datos['password'],
        $datos['nombre'],
        $datos['apellidos']
    );

    // Ejecutar consulta
    mysqli_stmt_execute($stmt);

    // ================= LIMPIAR SESIONES =================
    // Elimina los datos temporales y el código
    // después de completar el registro
    unset($_SESSION['registro_temp']);
    unset($_SESSION['codigo_verificacion']);

    // ================= MENSAJE DE ÉXITO =================
    // Guarda mensaje para mostrar en login
    $_SESSION['exito_registro'] =
        "Cuenta verificada correctamente.";

    // ================= REDIRECCIÓN FINAL =================
    // Envía al usuario al login
    header("Location: login");

    // Finaliza el script
    exit();
}
?>