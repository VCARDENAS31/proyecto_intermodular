<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Configuración básica -->
    <meta charset="UTF-8">
    <title>Panel de Administración - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <!-- ================= NAVBAR ADMIN ================= -->
    <nav class="navbar-admin navbar-dark fixed-top d-flex justify-content-between p-3">

        <!-- Botón menú lateral -->
        <button class="btn btn-outline-light" id="botonMenu">
            <i class="bi bi-list"></i>
        </button>

        <!-- Logo -->
        <div class="logo">
            <img class="img-fluid" src="assets/imagenes/logo_tienda.png" alt="Viciogames">
        </div>

        <!-- Menú usuario -->
        <div class="dropdown">
            <a href="#" class="text-white" id="userMenu" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-4"></i>
            </a>

            <!-- Dropdown cerrar sesión -->
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item btn-cerrar-sesion" href="#">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ================= FIN NAVBAR ================= -->


    <div class="d-flex">

        <!-- ================= SIDEBAR ================= -->
        <div id="sidebarMovil">

            <!-- Botón cerrar sidebar -->
            <button id="cerrarSidebar"
                class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                aria-label="Cerrar">
            </button>

            <!-- Información del usuario -->
            <div class="user-section">
                <i class="bi bi-person-circle"></i>
                <p class="mt-2 mb-0">BIENVENIDO</p>
                <strong>NOMBRE</strong>
            </div>

            <!-- Opciones del menú -->
            <div class="menu-item">GESTIONAR USUARIOS</div>
            <div class="menu-item">GESTIONAR PRODUCTOS</div>
            <div class="menu-item">GESTIONAR CUPONES</div>
            <div class="menu-item">ACTUALIZAR PEDIDOS</div>

            <!-- Botón cerrar sesión -->
            <button class="btn btn-danger logout-btn btn-cerrar-sesion">
                CERRAR SESIÓN
            </button>
        </div>
        <!-- ================= FIN SIDEBAR ================= -->


        <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="contenido p-4 flex-grow-1 d-flex justify-content-center align-items-center" style="min-height: 90vh">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestionar Usuarios</h1>
                <button class="btn btn-success shadow-sm">
                    <i class="bi bi-person-plus-fill me-2"></i>Añadir Usuario
                </button>
            </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                    <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre completo</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan.perez@ejemplo.com</td>
                                <td><span class="badge bg-secondary">User</span></td>
                                <td>
                                    <button class="btn btn-warning btn-sm text-white">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>
        <!-- ================= FIN CONTENIDO ================= -->

    </div>

    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="efectos.js"></script>

</body>

</html>
