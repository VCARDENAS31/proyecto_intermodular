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
    <title>Añadir Producto - Viciogames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 700px;">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Registrar Nuevo Producto</h4>
            </div>
            <div class="card-body">
                <form action="insertar-producto.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nombre del Videojuego</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Elden Ring" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" class="form-control" placeholder="29.99" required>
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
                        <label class="form-label">Categoría</label>
                        <input type="text" name="categoria" class="form-control" placeholder="Acción, RPG, Deporte...">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Breve descripción del producto..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Imagen del producto</label>
                        <input type="text" name="imagen" class="form-control" placeholder="https://i.ibb.co/mpNhL70/juego-astro-bot.jpg" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="gestionarProductos.php" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-success">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>