<?php
session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once ROOT_PATH . 'dao/conexion-bd.php';
require_once ROOT_PATH . 'dao/cuponDAO.php';


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin' || !isset($_GET['id'])) {
    header("Location: gestionar-cupones");
    exit();
}

$cupon = obtenerCuponPorId($conexion, $_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8">
    <title>Editar Cupón</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <?php include ROOT_PATH . 'includes/header-admin.php'; ?>

    <div class="contenido-gestion p-4 flex-grow-1 mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="bg-white shadow">
                    <div class="p-3 bg-dark text-white">
                        <h4 class="mb-0">Editar Cupón</h4>
                    </div>

                    <div class="p-3">

                        <form action="actualizar-cupon" method="POST">

                            <input type="hidden" name="id" value="<?php echo $cupon['id_cupon']; ?>">

                            <div class="mb-3">
                                <label>Código</label>
                                <input type="text" name="codigo" class="form-control"
                                    value="<?php echo $cupon['codigo']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Descuento (%)</label>
                                <input type="number" name="descuento" class="form-control"
                                    value="<?php echo $cupon['descuento_porcentaje']; ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Fecha caducidad</label>
                                <input type="date" name="fecha" class="form-control" required
                                    min="<?php echo date('Y-m-d'); ?>" value="<?php echo $cupon['fecha_caducidad']; ?>">
                            </div>

                            <div class="mb-3">
                                <label>Activo</label>
                                <select name="activo" class="form-select">
                                    <option value="1" <?php echo $cupon['activo'] ? 'selected' : ''; ?>>Sí</option>
                                    <option value="0" <?php echo !$cupon['activo'] ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="gestionar-cupones" class="btn btn-secondary">Cancelar</a>
                                <button class="btn btn-success">Guardar cambios</button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="js/ui/sidebar.js"></script>
</body>

</html>