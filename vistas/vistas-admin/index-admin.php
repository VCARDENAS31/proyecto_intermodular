<?php
// ================= CONFIGURACIÓN E INCLUDES =================
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

// ================= CONTROL DE ACCESO =================
// Verificamos que el usuario sea administrador antes de mostrar el panel
if (!esAdmin()) {
    accesoDenegado();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ================= METADATOS Y CONFIGURACIÓN DEL HEAD ================= -->
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Panel de Administración</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    
    <!-- ================= FUENTES Y ESTILOS EXTERNOS ================= -->
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- ================= HEADER DEL PANEL DE ADMINISTRACIÓN ================= -->
    <?php include ROOT_PATH . "includes/header-admin.php"; ?>

    <!-- ================= CONTENIDO PRINCIPAL - DASHBOARD ================= -->
    <div id="content" class="p-4 p-md-5" style="margin-top: 100px;">
        
        <!-- Título del dashboard -->
        <h3 class="text-center mb-5 fw-bold">SELECCIONA UNA ACCIÓN</h3>
        
        <div class="container">
            <!-- ================= GRID DE ACCIONES DISPONIBLES ================= -->
            <!-- Sistema de cards responsive para las diferentes secciones del admin -->
            <div class="row g-4 justify-content-center">
                
                <!-- ================= CARD: GESTIONAR USUARIOS ================= -->
                <div class="col-6 col-md-4">
                    <a href="gestionar-usuarios.php">
                        <div class="card-action">
                            <i class="bi bi-people"></i>
                            <h6>GESTIONAR USUARIOS</h6>
                        </div>
                    </a>
                </div>
                
                <!-- ================= CARD: GESTIONAR PRODUCTOS ================= -->
                <div class="col-6 col-md-4">
                    <a href="gestionar-productos.php">
                        <div class="card-action">
                            <i class="bi bi-box-seam"></i>
                            <h6>GESTIONAR PRODUCTOS</h6>
                        </div>
                    </a>
                </div>
                
                <!-- ================= CARD: GESTIONAR CUPONES ================= -->
                <div class="col-6 col-md-4">
                    <a href="gestionar-cupones.php">
                        <div class="card-action">
                            <i class="bi bi-percent"></i>
                            <h6>GESTIONAR CUPONES</h6>
                        </div>
                    </a>
                </div>
                
                <!-- ================= CARD: ACTUALIZAR PEDIDOS ================= -->
                <div class="col-6 col-md-4">
                    <a href="gestionar-pedidos.php">
                        <div class="card-action">
                            <i class="bi bi-truck"></i>
                            <h6>ACTUALIZAR PEDIDOS</h6>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- ================= SCRIPTS ================= -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>
