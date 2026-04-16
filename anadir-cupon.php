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
    <title>Añadir Cupón</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
</head>

<body>

    <?php include 'header-admin.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="bg-white shadow mt-5">

                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Añadir Cupón</h4>
                    </div>

                    <div class="p-3">
                        <form action="insertar-cupon.php" method="POST">

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

                            <div class="d-flex justify-content-between">
                                <a href="gestionarCupones.php" class="btn btn-secondary">Volver</a>
                                <button class="btn btn-success">Guardar</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</body>

</html>