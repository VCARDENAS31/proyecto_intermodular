<?php

// Inicia la sesión para acceder a variables temporales
session_start();

// ==============================
// IMPORTAR CONFIGURACIÓN GENERAL
// ==============================
// Carga constantes globales como ROOT_PATH
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// Incluye la conexión MySQL
require_once ROOT_PATH . 'dao/conexion-bd.php';

// Incluye la función enviarCodigo()
require_once ROOT_PATH . 'includes/email.php';


// Hace que MySQLi lance excepciones automáticamente
// para poder usar try/catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// ==============================
// VERIFICAR MÉTODO POST
// ==============================
// Solo permitir acceso mediante envío de formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ==============================
    // RECOGER DATOS DEL FORMULARIO
    // ==============================

    // Obtener nombre
    $nombre = trim($_POST['nombre']);

    // Obtener apellidos
    $apellidos = trim($_POST['apellidos']);

    // Obtener email
    $email = trim($_POST['email']);

    // Obtener contraseña sin encriptar
    $password_plana = $_POST['password'];

    // ==============================
    // VALIDAR CONTRASEÑA
    // ==============================
    // Debe:
    // - Tener mínimo 5 caracteres
    // - Contener una mayúscula
    // - Contener un carácter especial

    if (
        strlen($password_plana) < 5 ||
        !preg_match('/[A-Z]/', $password_plana) ||
        !preg_match('/[\W_]/', $password_plana)
    ) {

        // Guardar mensaje de error
        $_SESSION['error_registro'] = "La contraseña debe tener mínimo 5 caracteres, una mayúscula y un carácter especial.";

        // Redirigir al formulario
        header("Location: registro");

        // Detener ejecución
        exit();
    }

    // ==============================
    // VALIDAR FORMATO EMAIL
    // ==============================

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Guardar mensaje de error
        $_SESSION['error_registro'] = "Email no válido.";

        // Redirigir al formulario
        header("Location: registro");

        // Detener ejecución
        exit();
    }

    // ==============================
    // VERIFICAR SI EL EMAIL EXISTE
    // ==============================
    // Evita registros duplicados

    $sqlCheck = "SELECT id_usuario FROM usuarios WHERE email = ?";

    // Preparar consulta
    $stmtCheck = mysqli_prepare($conexion, $sqlCheck);

    // Vincular email
    mysqli_stmt_bind_param($stmtCheck, "s", $email);

    // Ejecutar consulta
    mysqli_stmt_execute($stmtCheck);

    // Guardar resultado
    mysqli_stmt_store_result($stmtCheck);

    // Verificar si existe un usuario con ese email
    if (mysqli_stmt_num_rows($stmtCheck) > 0) {

        // Guardar mensaje de error
        $_SESSION['error_registro'] = "El correo ya está registrado.";

        // Redirigir al formulario
        header("Location: registro");

        // Detener ejecución
        exit();
    }

    // ==============================
    // GENERAR CÓDIGO DE VERIFICACIÓN
    // ==============================
    // Genera un código aleatorio de 6 cifras

    $codigo = rand(100000, 999999);

    // ==============================
    // GUARDAR DATOS TEMPORALES
    // ==============================
    // El usuario NO se registra todavía
    // Se almacenan temporalmente en sesión
    // hasta verificar el código

    $_SESSION['registro_temp'] = [

        'nombre' => $nombre,

        'apellidos' => $apellidos,

        'email' => $email,

        // Guardar contraseña encriptada
        'password' => password_hash($password_plana, PASSWORD_DEFAULT)
    ];

    // Guardar código en sesión
    $_SESSION['codigo_verificacion'] = $codigo;

    // ==============================
    // ENVIAR EMAIL DE VERIFICACIÓN
    // ==============================

    try {

        // Enviar código al correo
        enviarCodigo($email, $codigo);

        // Redirigir a verificar código
        header("Location: verificar-codigo");

        // Detener ejecución
        exit();

    } catch (Exception $e) {

        // Si falla el envío del correo

        $_SESSION['error_registro'] = "Error al enviar el correo.";

        // Volver al registro
        header("Location: registro");

        // Detener ejecución
        exit();
    }
}