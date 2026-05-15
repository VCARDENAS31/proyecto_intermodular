<?php

// Configuración general y conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';

// Iniciar sesión y comprobar permisos de administrador
session_start();

if (!esAdmin()) {
    accesoDenegado();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Añadir Producto</title>

    <!-- Icono y estilos -->
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- HEADER ADMIN -->
    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <!-- ================= CONTENIDO PRINCIPAL ================= -->
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-8 mt-5">

                <div class="bg-white shadow mt-5">

                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Registrar Nuevo Producto</h4>
                    </div>

                    <div class="p-3 card-body">

                        <!-- FORMULARIO -->
                        <form action="insertar-producto" method="POST" enctype="multipart/form-data">

                            <div class="row">

                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio (€)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control"
                                        placeholder="Ej: 29.99" required>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" class="form-control" required>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipo</label>

                                    <select name="tipo" class="form-select">
                                        <option value="Juego">Juego</option>
                                        <option value="Accesorio">Accesorio</option>
                                        <option value="Consola">Consola</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Plataforma</label>

                                    <select name="plataforma" class="form-select">
                                        <option value="PS5">PS5</option>
                                        <option value="Xbox">Xbox</option>
                                        <option value="Switch">Switch</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Categoría (para filtros)</label>

                                <select name="categoria" class="form-select" required>

                                    <option value="">Seleccionar categoría</option>

                                    <!-- VIDEOJUEGOS -->
                                    <optgroup label="Videojuegos">
                                        <option value="Acción">Acción</option>
                                        <option value="Aventura">Aventura</option>
                                        <option value="Deportes">Deportes</option>
                                        <option value="RPG">RPG</option>
                                        <option value="Terror">Terror</option>
                                    </optgroup>

                                    <!-- ACCESORIOS -->
                                    <optgroup label="Accesorios">
                                        <option value="DualSense">DualSense</option>
                                        <option value="Cargadores">Cargadores</option>
                                        <option value="Ventiladores">Ventiladores</option>
                                        <option value="Cables">Cables</option>
                                        <option value="Fundas y estuches">Fundas y estuches</option>
                                        <option value="Memorias">Memorias</option>
                                        <option value="Cámaras">Cámaras</option>
                                        <option value="Mandos">Mandos</option>
                                        <option value="Baterías">Baterías</option>
                                        <option value="Grips">Grips</option>
                                        <option value="Auriculares">Auriculares</option>
                                        <option value="Simuladores">Simuladores</option>
                                        <option value="Figuras">Figuras</option>
                                        <option value="Fundas y protectores">Fundas y protectores</option>
                                        <option value="Soportes">Soportes</option>
                                        <option value="Controles">Controles</option>
                                    </optgroup>

                                    <!-- CONSOLAS -->
                                    <optgroup label="Consolas">
                                        <option value="Sony">Sony</option>
                                        <option value="Microsoft">Microsoft</option>
                                        <option value="Nintendo">Nintendo</option>
                                    </optgroup>

                                </select>
                            </div>

                            <!-- OPCIONES SOLO PARA CONSOLAS -->
                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">¿Tiene lector?</label>

                                    <select name="tieneLector" class="form-select">

                                        <option value="">No aplica</option>
                                        <option value="1">Sí</option>
                                        <option value="0">No</option>

                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">Almacenamiento</label>

                                    <select name="almacenamiento" class="form-select">

                                        <option value="">No aplica</option>

                                        <!-- PLAYSTATION / XBOX -->
                                        <option value="512GB">512GB</option>
                                        <option value="825GB">825GB</option>
                                        <option value="1TB">1TB</option>
                                        <option value="2TB">2TB</option>

                                        <!-- NINTENDO -->
                                        <option value="32GB">32GB</option>
                                        <option value="64GB">64GB</option>

                                    </select>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Descripción</label>

                                <textarea name="descripcion" class="form-control" rows="3" minlength="10"
                                    maxlength="1100" required
                                    placeholder="Breve descripción del producto..."></textarea>

                            </div>

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">Tipo carpeta</label>

                                    <select id="tipoCarpeta" name="tipoCarpeta" class="form-select" required>
                                        <option value="">Seleccionar</option>
                                        <option value="videojuegos">Videojuegos</option>
                                        <option value="accesorios">Accesorios</option>
                                        <option value="consolas">Consolas</option>
                                    </select>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">Subcarpeta</label>

                                    <select id="subcarpeta" name="subcarpeta" class="form-select" required>
                                        <option value="">Primero elige tipo</option>
                                    </select>

                                </div>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">Imagen del producto si quieres subir una nueva (Solo
                                    webp)</label>

                                <input type="file" name="imagen" class="form-control" accept=".webp">

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Usar imagen existente</label>

                                <select name="imagen_existente" class="form-select">
                                    <option value="">-- Subir nueva imagen --</option>

                                    <?php
                                    // Obtener imágenes ya existentes en la base de datos
                                    $query = "SELECT DISTINCT img_url FROM productos ORDER BY img_url ASC";
                                    $result = mysqli_query($conexion, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='{$row['img_url']}'>{$row['img_url']}</option>";
                                    }
                                    ?>
                                </select>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">Slug (URL amigable)</label>

                                <input type="text" name="slug" class="form-control" required
                                    placeholder="ej: god-of-war-ragnarok-ps5">

                            </div>

                            <!-- MENSAJES DE ERROR -->
                            <?php if (isset($_GET['error'])): ?>

                                <?php if ($_GET['error'] == 'slug'): ?>
                                    <div class="alert alert-danger">
                                        Ese slug ya existe, usa otro diferente
                                    </div>
                                <?php endif; ?>

                                <?php if ($_GET['error'] == 'img-existe'): ?>
                                    <div class="alert alert-danger">
                                        Ya existe una imagen igual, selecciona la imagen existente o sube una nueva con un
                                        nombre diferente
                                    </div>
                                <?php endif; ?>

                                <?php if ($_GET['error'] == 'img'): ?>
                                    <div class="alert alert-danger">
                                        Debes subir una imagen o seleccionar una existente (solo WEBP)
                                    </div>
                                <?php endif; ?>

                                <?php if ($_GET['error'] == 'upload'): ?>
                                    <div class="alert alert-danger">
                                        Error al subir la imagen
                                    </div>
                                <?php endif; ?>

                                <?php if ($_GET['error'] == 'doble-img'): ?>
                                    <div class="alert alert-danger">
                                        Solo puedes subir una imagen nueva o seleccionar una existente, no ambas
                                    </div>
                                <?php endif; ?>

                            <?php endif; ?>

                            <!-- BOTONES -->
                            <div class="d-flex justify-content-between">
                                <a href="gestionar-productos" class="btn btn-secondary">Volver</a>

                                <button type="submit" class="btn btn-success">
                                    Guardar Producto
                                </button>
                            </div>

                        </form>
                        <!-- ================= FIN FORMULARIO ================= -->

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- Scripts -->
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin/producto-form.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>

</body>

</html>