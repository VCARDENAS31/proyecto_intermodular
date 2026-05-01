<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/usuarioDAO.php';

session_start();

//  SOLO ADMIN
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //  DATOS
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    //  VALIDACIÓN PASSWORD
    if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{5,}$/', $password)) {
        header("Location: anadir-usuario.php?error=pass");
        exit();
    }

    //  HASH SEGURO
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    //  USAR DAO
    try {

        $resultado = insertarUsuario(
            $conexion,
            $nombre,
            $apellidos,
            $email,
            $password_hash,
            $rol
        );

        header("Location: gestionar-usuarios.php?res=ok");
        exit();

    } catch (mysqli_sql_exception $e) {

        //  ERROR EMAIL DUPLICADO
        if ($e->getCode() == 1062) {
            header("Location: anadir-usuario.php?error=email");
            exit();
        }

        //  OTRO ERROR
        header("Location: anadir-usuario.php?error=general");
        exit();
    }
}
?>