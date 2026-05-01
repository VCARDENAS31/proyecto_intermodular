<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] === 'admin') {

    $codigo = $_POST['codigo'];
    $descuento = $_POST['descuento'];
    $fecha = $_POST['fecha'];
    $activo = $_POST['activo'];

    $hoy = date('Y-m-d');

    // CUPÓN CADUCADO
    if ($fecha < $hoy && $activo == 1) {
        header("Location: gestionar-cupones.php?error=cupon_caducado");
        exit();
    }

    //  COMPROBAR DUPLICADO
    $sqlCheck = "SELECT id_cupon FROM cupones WHERE codigo = ?";
    $stmt = mysqli_prepare($conexion, $sqlCheck);
    mysqli_stmt_bind_param($stmt, "s", $codigo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        header("Location: anadir-cupon.php?error=codigo_duplicado");
        exit();
    }

    //  INSERTAR
    $res = insertarCupon($conexion, $codigo, $descuento, $fecha, $activo);

    if ($res) {
        header("Location: gestionar-cupones.php?res=ok");
    } else {
        header("Location: gestionar-cupones.php?res=error");
    }

    exit();
}