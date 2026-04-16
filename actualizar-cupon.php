<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['rol'] === 'admin') {

    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descuento = $_POST['descuento'];
    $fecha = $_POST['fecha'];
    $activo = $_POST['activo'];
    $hoy = date('Y-m-d');

    if ($fecha < $hoy && $activo == 1) {
        header("Location: gestionarCupones.php?error=cupon_caducado");
        exit();
    }

    $res = actualizarCupon($conexion, $id, $codigo, $descuento, $fecha, $activo);

    if ($res) {
        header("Location: gestionarCupones.php?res=edit_ok");
    } else {
        header("Location: gestionarCupones.php?res=error");
    }
}