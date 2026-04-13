<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Añadir Usuario - Viciogames</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Estilos -->
    <link rel="stylesheet" href="css/prueba.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Iconos Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <?php include 'header-admin.php'; ?>
    <!-- ================= FIN SIDEBAR ================= -->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="bg-white shadow mt-5">
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Registrar Nuevo Producto</h4>
                    </div>
                    <div class="p-3 card-body">
                        <form action="insertar-producto.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Nombre del Videojuego</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Elden Ring"
                                        required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Precio (€)</label>
                                    <input type="number" step="0.01" name="precio" class="form-control"
                                        placeholder="29.99" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" class="form-control" value="10" required>
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
                                        <option value="accion">Acción</option>
                                        <option value="aventura">Aventura</option>
                                        <option value="deporte">Deporte</option>
                                        <option value="rpg">RPG</option>
                                        <option value="terror">Terror</option>
                                    </optgroup>

                                    <!-- ACCESORIOS -->
                                    <optgroup label="Accesorios">
                                        <option value="dualsense">DualSense</option>
                                        <option value="cargadores">Cargadores</option>
                                        <option value="ventiladores">Ventiladores</option>
                                        <option value="cables">Cables</option>
                                        <option value="fundas-estuches">Fundas y estuches</option>
                                        <option value="memorias">Memorias</option>
                                        <option value="camaras">Cámaras</option>
                                        <option value="mando">Mando</option>
                                        <option value="baterias">Baterías</option>
                                        <option value="grips">Grips</option>
                                        <option value="auriculares">Auriculares</option>
                                        <option value="simuladores">Simuladores</option>
                                        <option value="figuras">Figuras</option>
                                        <option value="fundas-protectores">Fundas y protectores</option>
                                        <option value="soportes">Soportes</option>
                                        <option value="controles">Controles</option>
                                    </optgroup>

                                    <!-- CONSOLAS -->
                                    <optgroup label="Consolas">
                                        <option value="sony">Sony</option>
                                        <option value="microsoft">Microsoft</option>
                                        <option value="nintendo">Nintendo</option>
                                    </optgroup>

                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"
                                    placeholder="Breve descripción del producto..."></textarea>
                            </div>
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipo carpeta</label>
                                    <select id="tipoCarpeta" class="form-select">
                                        <option value="">Seleccionar</option>
                                        <option value="videojuegos">Videojuegos</option>
                                        <option value="accesorios">Accesorios</option>
                                        <option value="consolas">Consolas</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subcarpeta</label>
                                    <select id="subcarpeta" name="subcarpeta" class="form-select">
                                        <option value="">Primero elige tipo</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="form-label">Imagen del producto</label>
                                <input type="file" name="imagen" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="gestionarProductos.php" class="btn btn-secondary">Volver</a>
                                <button type="submit" class="btn btn-success">Guardar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================= FIN CONTENIDO PRINCIPAL ================= -->

    <!-- Overlay para cerrar sidebar -->
    <div id="overlaySidebar"></div>

    <script>
        const tipoCarpeta = document.getElementById("tipoCarpeta");
        const subcarpeta = document.getElementById("subcarpeta");

        tipoCarpeta.addEventListener("change", () => {

            let opciones = "";

            switch (tipoCarpeta.value) {

                case "videojuegos":
                    opciones = `
                <option value="accion">Acción</option>
                <option value="aventura">Aventura</option>
                <option value="deporte">Deporte</option>
                <option value="rpg">RPG</option>
                <option value="terror">Terror</option>
            `;
                    break;

                case "accesorios":
                    opciones = `
                <option value="ps5">PS5</option>
                <option value="xbox-series-sx">Xbox Series</option>
                <option value="nintendo-switch">Nintendo Switch</option>
            `;
                    break;

                case "consolas":
                    opciones = `
                <option value="ps5">PS5</option>
                <option value="xbox-series-sx">Xbox Series</option>
                <option value="nintendo-switch">Nintendo Switch</option>`;
                    break;

                default:
                    opciones = `<option value="">Selecciona primero tipo</option>`;
            }

            subcarpeta.innerHTML = opciones;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="funciones-crud.js"></script>
    <script src="efectos.js"></script>
</body>

</html>