<?php
// Inicia la sesión para poder acceder a ella
session_start();

// Limpia todas las variables de sesión
$_SESSION = array();

// Destruir la sesión completamente (borra también la cookie de sesión)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruimos la sesión
session_destroy();

// Redirige al formulario de login
header("Location: login.php");
exit();
?>