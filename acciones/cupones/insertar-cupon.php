<?php
// Inicia el archivo PHP para insertar un nuevo cupón en el sistema

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
// Incluye el archivo de configuración con rutas y constantes

require_once ROOT_PATH . 'dao/conexion-bd.php';
// Incluye la conexión a la base de datos MySQL

require_once ROOT_PATH . 'dao/cuponDAO.php';
// Incluye el DAO para operaciones con cupones

session_start();
// Inicia la sesión para verificar permisos de admin

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] === 'admin') {
    // Verifica que la solicitud sea POST y que el usuario sea admin

    $codigo = $_POST['codigo'];
    // Obtiene el código del cupón desde el formulario

    $descuento = $_POST['descuento'];
    // Obtiene el porcentaje de descuento

    $fecha = $_POST['fecha'];
    // Obtiene la fecha de expiración del cupón

    $activo = $_POST['activo'];
    // Obtiene el estado activo/inactivo del cupón

    $hoy = date('Y-m-d');
    // Obtiene la fecha actual para validaciones

    // CUPÓN CADUCADO
    if ($fecha < $hoy && $activo == 1) {
        // Valida si el cupón ya está caducado y activo; redirige con error
        header("Location: gestionar-cupones.php?error=cupon_caducado");
        exit();
    }

    //  COMPROBAR DUPLICADO
    $sqlCheck = "SELECT id_cupon FROM cupones WHERE codigo = ?";
    // Consulta SQL para verificar si el código ya existe

    $stmt = mysqli_prepare($conexion, $sqlCheck);
    // Prepara la consulta para evitar inyección SQL

    mysqli_stmt_bind_param($stmt, "s", $codigo);
    // Vincula el parámetro del código a la consulta

    mysqli_stmt_execute($stmt);
    // Ejecuta la consulta

    mysqli_stmt_store_result($stmt);
    // Almacena el resultado

    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Si ya existe un cupón con ese código, redirige con error
        header("Location: anadir-cupon.php?error=codigo_duplicado");
        exit();
    }

    //  INSERTAR
    $res = insertarCupon($conexion, $codigo, $descuento, $fecha, $activo);
    // Llama a la función para insertar el cupón en la BD

    if ($res) {
        // Si la inserción fue exitosa, redirige con éxito
        header("Location: gestionar-cupones.php?res=ok");
    } else {
        // Si falló, redirige con error
        header("Location: gestionar-cupones.php?res=error");
    }

    exit();
    // Termina la ejecución del script
}