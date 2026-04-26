<?php
include 'conexion-bd.php';
include 'consultas.php';
session_start();

if (isset($_GET['id']) && $_SESSION['rol'] === 'admin') {

    $id = $_GET['id'];

    $res = eliminarCupon($conexion, $id);

    if ($res) {
        header("Location: gestionarCupones.php?res=del_ok");
    } else {
        header("Location: gestionarCupones.php?res=error");
    }
}