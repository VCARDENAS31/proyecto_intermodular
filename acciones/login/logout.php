<?php
// Inicia el bloque de código PHP para el script de logout

// Inicia la sesión para poder acceder a ella
// Comentario explicando que se inicia la sesión para manipularla
session_start();

// Limpia todas las variables de sesión
// Vacía el array de sesión para eliminar todos los datos almacenados
$_SESSION = array();

// Destruir la sesión completamente (borra también la cookie de sesión)
// Comentario indicando que se destruye la sesión y la cookie asociada
if (ini_get("session.use_cookies")) {
    // Verifica si el sistema usa cookies para sesiones
    $params = session_get_cookie_params();
    // Obtiene los parámetros de la cookie de sesión
    setcookie(session_name(), '', time() - 42000,
        // Establece una cookie expirada (tiempo pasado) para eliminarla
        $params["path"], $params["domain"],
        // Usa los mismos parámetros de path y domain
        $params["secure"], $params["httponly"]
        // Mantiene secure y httponly para consistencia
    );
}

// Destruimos la sesión
// Llama a session_destroy para finalizar la sesión del lado del servidor
session_destroy();

// Redirige al usuario a la página principal después del logout
header("Location: /");
// Envía la cabecera de redirección
exit();
// Termina la ejecución del script para evitar procesamiento adicional
?>