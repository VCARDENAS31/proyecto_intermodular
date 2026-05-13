<?php
// Inicia el bloque de código PHP para el script de autenticación de login

session_start();
// Inicia la sesión para manejar variables de sesión del usuario

// forma PRO
// Comentario indicando que se usa una forma profesional de estructurar el código

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración principal que define constantes como ROOT_PATH

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye el archivo de conexión a la base de datos para establecer la conexión MySQL

require_once ROOT_PATH . 'dao/productoDAO.php';
// Incluye el DAO de productos (aunque no se usa en este script, posiblemente un include innecesario o para futuras extensiones)


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si la solicitud HTTP es de tipo POST, asegurando que se procese solo envíos de formularios

    $email = trim($_POST['email']);
    // Obtiene y limpia el email del formulario, eliminando espacios en blanco al inicio y final

    $password = $_POST['password'];
    // Obtiene la contraseña del formulario sin modificaciones adicionales

    $sql = "SELECT id_usuario, nombre, rol, contrasena FROM usuarios WHERE email = ?";
    // Define la consulta SQL preparada para seleccionar datos del usuario por email, usando placeholders para seguridad

    $stmt = mysqli_prepare($conexion, $sql);
    // Prepara la declaración SQL usando la conexión a la base de datos

    mysqli_stmt_bind_param($stmt, "s", $email);
    // Vincula el parámetro email a la consulta preparada como string

    mysqli_stmt_execute($stmt);
    // Ejecuta la consulta preparada en la base de datos

    $resultado = mysqli_stmt_get_result($stmt);
    // Obtiene el resultado de la ejecución de la consulta

    if ($usuario = mysqli_fetch_assoc($resultado)) {
        // Si se encuentra un usuario con el email proporcionado, obtiene sus datos como array asociativo

        if (password_verify($password, $usuario['contrasena'])) {
            // Verifica si la contraseña proporcionada coincide con el hash almacenado en la base de datos

            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            // Almacena el ID del usuario en la sesión para identificarlo

            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            // Almacena el nombre del usuario en la sesión para mostrarlo en la interfaz

            $_SESSION['rol'] = $usuario['rol'];
            // Almacena el rol del usuario (admin o user) en la sesión para control de permisos

            header("Location: /");
            // Redirige al usuario a la página principal después de un login exitoso

            exit();
            // Termina la ejecución del script para evitar procesamiento adicional
        } else {
            // Si la contraseña no coincide, establece un mensaje de error en la sesión

            $_SESSION['error_login'] = "Datos incorrectos";
            // Mensaje de error para contraseña incorrecta
        }

    } else {
        // Si no se encuentra ningún usuario con el email, establece un mensaje de error en la sesión

        $_SESSION['error_login'] = "Datos incorrectos";
        // Mensaje de error para email no encontrado
    }

    header("Location: login");
    // Redirige de vuelta a la página de login si hay errores o fallos

    exit();
    // Termina la ejecución del script después de la redirección
}