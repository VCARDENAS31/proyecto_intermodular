<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';


session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viciogames | Añadir Cupón</title>
    <link rel="icon" href="assets/imagenes/logo/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Exo:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="bg-white shadow mt-5">

                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Añadir Cupón</h4>
                    </div>

                    <div class="p-3">
                        <form action="insertar-cupon" method="POST">

                            <div class="mb-3">
                                <label>Código</label>
                                <input type="text" name="codigo" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Descuento (%)</label>
                                <input type="number" name="descuento" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Fecha caducidad</label>
                                <input type="date" name="fecha" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>">
                            </div>

                            <div class="mb-3">
                                <label>Activo</label>
                                <select name="activo" class="form-select">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <?php if (isset($_GET['error']) && $_GET['error'] == 'codigo_duplicado'): ?>
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-triangle"></i> El código de cupón ya existe
                                </div>
                            <?php endif; ?>

                            <div class="d-flex justify-content-between">
                                <a href="gestionar-cupones" class="btn btn-secondary">Volver</a>
                                <button class="btn btn-success">Guardar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/utils/modal.js"></script>
    <script src="js/ui/sidebar.js"></script>
    <script src="js/usuario/logout.js"></script>
</body>

</html>