<?php
session_start();

// ADMIN → panel admin
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    include 'vistas/vistas-admin/index-admin.php';
    exit();
}

// TODOS LOS DEMÁS (logueados o no)
include 'vistas/vistas-user/index-user.php';
?>