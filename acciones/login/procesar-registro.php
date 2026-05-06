<?php
// Inicia el bloque de código PHP para el script de procesamiento de registro

session_start();
// Inicia la sesión para almacenar mensajes de error o éxito en $_SESSION

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

// Configura mysqli para lanzar excepciones en caso de error
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// Permite usar try-catch para capturar excepciones de mysqli

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si la solicitud HTTP es de tipo POST, asegurando que se procese solo envíos de formularios

    // ==============================
    // RECOGER DATOS
    // ==============================
    // Sección de recopilación de datos del formulario de registro

    $nombre = trim($_POST['nombre']);
    // Obtiene el nombre del usuario y elimina espacios en blanco al inicio y final

    $apellidos = trim($_POST['apellidos']);
    // Obtiene los apellidos del usuario y elimina espacios en blanco

    $email = trim($_POST['email']);
    // Obtiene el email del usuario y elimina espacios en blanco

    $password_plana = $_POST['password'];
    // Obtiene la contraseña sin encriptar (se encriptará después)

    // ==============================
    // VALIDACIÓN CONTRASEÑA
    // ==============================
    // Sección de validación de la contraseña según criterios de seguridad

    if (
        // Inicia la validación de contraseña con múltiples condiciones
        strlen($password_plana) < 5 ||
        // Verifica que la contraseña tenga mínimo 5 caracteres
        !preg_match('/[A-Z]/', $password_plana) ||
        // Verifica que la contraseña contenga al menos una mayúscula
        !preg_match('/[\W_]/', $password_plana)
        // Verifica que la contraseña contenga al menos un carácter especial
    ) {
        $_SESSION['error_registro'] = "La contraseña debe tener mínimo 5 caracteres, una mayúscula y un carácter especial.";
        // Almacena el mensaje de error en la sesión para mostrarlo en la página de registro

        header("Location: registro");
        // Redirige de vuelta a la página de registro

        exit();
        // Termina la ejecución del script
    }

    // ==============================
    // VALIDAR EMAIL
    // ==============================
    // Sección de validación del formato del email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Verifica si el email tiene un formato válido usando filter_var

        $_SESSION['error_registro'] = "Email no válido.";
        // Almacena el mensaje de error en la sesión

        header("Location: registro");
        // Redirige de vuelta a la página de registro

        exit();
        // Termina la ejecución del script
    }

    // ==============================
    // ENCRIPTAR CONTRASEÑA
    // ==============================
    // Sección de cifrado seguro de la contraseña

    $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);
    // Encripta la contraseña usando bcrypt (PASSWORD_DEFAULT) para almacenamiento seguro

    // ==============================
    // INSERTAR USUARIO
    // ==============================
    // Sección de inserción del nuevo usuario en la base de datos

    $sql = "INSERT INTO usuarios (email, contrasena, nombre, apellidos, rol) 
            VALUES (?, ?, ?, ?, 'user')";
    // Define la consulta SQL preparada para insertar un nuevo usuario con rol 'user' por defecto

    $stmt = mysqli_prepare($conexion, $sql);
    // Prepara la declaración SQL usando la conexión a la base de datos

    mysqli_stmt_bind_param($stmt, "ssss", $email, $password_segura, $nombre, $apellidos);
    // Vincula los parámetros a la consulta preparada: email, password, nombre, apellidos (todos strings)

    try {
        // Inicia un bloque try para capturar excepciones durante la ejecución

        mysqli_stmt_execute($stmt);
        // Ejecuta la consulta preparada para insertar el usuario en la base de datos

        // MENSAJE DE ÉXITO
        // Sección de procesamiento después de un registro exitoso

        $_SESSION['exito_registro'] = "Usuario creado correctamente. Ya puedes iniciar sesión.";
        // Almacena el mensaje de éxito en la sesión para mostrarlo en la página de login

        // redirige a la página de login con URL limpia

        header("Location: login");
        // Envía la cabecera de redirección a la página de login

        exit();
        // Termina la ejecución del script después de la redirección

    } catch (mysqli_sql_exception $e) {
        // Captura cualquier excepción de mysqli (errores de base de datos)


        // Sección de manejo específico de errores

        if ($e->getCode() == 1062) {
            // Verifica si el código de error es 1062 (violación de restricción única - email duplicado)

            $_SESSION['error_registro'] = "El correo ya está registrado.";
            // Almacena mensaje de error específico para email duplicado

        } else {
            // Si es otro tipo de error

            $_SESSION['error_registro'] = "Error al registrar usuario.";
            // Almacena un mensaje de error genérico

        }

        header("Location: registro");
        // Redirige de vuelta a la página de registro para mostrar el error

        exit();
        // Termina la ejecución del script
    }
}