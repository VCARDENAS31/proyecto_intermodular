<?php
// ==========================================
// INDEX PRINCIPAL - ENRUTADOR DE VISTAS
// ==========================================

// ====== INICIO DE SESIÓN ======
session_start();

// ====== LÓGICA DE REDIRECCIÓN SEGÚN ROL ======

// Si el usuario es administrador, muestra el panel de administración
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    include 'vistas/vistas-admin/index-admin.php';
    exit();
}

// Para usuarios normales (logueados o no), muestra la vista de usuario
include 'vistas/vistas-user/index-user.php';
?>
