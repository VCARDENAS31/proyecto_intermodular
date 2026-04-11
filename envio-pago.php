<?php
session_start();

if (empty($_SESSION['carrito'])) {
    echo "Carrito vacío";
    exit();
}

$total = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

$totalFinal = $total + 2.99;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Envío y Pago</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* MODAL */
        .modal-compra {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-compra.active {
            display: flex;
        }

        .modal-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            animation: aparecer 0.4s ease;
        }

        @keyframes aparecer {
            from {
                transform: scale(0.7);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .check {
            font-size: 60px;
            color: green;
            animation: pop 0.5s ease;
        }

        @keyframes pop {
            0% {
                transform: scale(0);
            }

            80% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .botones {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <div class="checkout-nav py-3 px-4 d-flex justify-content-between align-items-center">

        <div class="logo-checkout">
            <img src="assets/imagenes/logo_tienda.png" height="40">
        </div>

        <div class="checkout-steps d-flex align-items-center gap-3">

            <div class="step">
                <span>1</span>
                <p>Cesta</p>
            </div>

            <div class="line"></div>

            <div class="step active">
                <span>2</span>
                <p>Envío y Pago</p>
            </div>

        </div>

    </div>

    <div class="container my-5">
        <div class="row">

            <!-- FORMULARIO -->
            <div class="col-lg-8">

                <div class="p-4 bg-white shadow-sm rounded mb-4">
                    <h4 class="fw-bold mb-3">Datos de envío</h4>

                    <form id="formCompra">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Apellidos" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Dirección" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Ciudad" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="text" class="form-control" placeholder="Código Postal" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <input type="text" class="form-control" placeholder="Teléfono" required>
                        </div>

                        <!-- PAGO -->
                        <h4 class="fw-bold mb-3">Método de pago</h4>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="pago" value="tarjeta" checked>
                            <label class="form-check-label">
                                <i class="bi bi-credit-card"></i> Tarjeta
                            </label>
                        </div>

                        <div id="camposTarjeta">

                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="Número de tarjeta">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="MM/AA">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <input type="text" class="form-control" placeholder="CVV">
                                </div>
                            </div>

                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="pago" value="contra">
                            <label class="form-check-label">
                                <i class="bi bi-cash"></i> Contra reembolso
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Confirmar pedido
                        </button>

                    </form>
                </div>

            </div>

            <!-- RESUMEN -->
            <div class="col-lg-4">

                <div class="p-4 shadow-sm bg-white rounded">

                    <h4 class="fw-bold mb-3">Resumen</h4>

                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?php echo $producto['nombre']; ?> x<?php echo $producto['cantidad']; ?></span>
                            <span><?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?>€</span>
                        </div>
                    <?php endforeach; ?>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span>Subtotal</span>
                        <span><?php echo number_format($total, 2); ?>€</span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span>Envío</span>
                        <span>2,99€</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?php echo number_format($totalFinal, 2); ?>€</strong>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- MODAL -->
    <div id="modalCompra" class="modal-compra">

        <div class="modal-box">

            <div class="check">✔</div>

            <h3>Compra realizada</h3>
            <p>Tu pedido se ha procesado correctamente</p>

            <div class="botones">
                <a href="historial.php" class="btn btn-primary">Ver mis pedidos</a>
                <a href="index-user.php" class="btn btn-secondary">Ir al inicio</a>
            </div>

        </div>

    </div>

    <!-- JS -->
<script>
const form = document.getElementById('formCompra');
const modal = document.getElementById('modalCompra');
let enviando = false;

form.addEventListener('submit', function (e) {
    e.preventDefault();

    if (enviando) return;
    enviando = true;

    const boton = form.querySelector('button');
    boton.disabled = true;
    boton.innerText = "Procesando...";

    const direccion = document.querySelector('input[placeholder="Dirección"]').value;

    fetch('procesar-pedido.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'direccion=' + encodeURIComponent(direccion)
    })
    .then(res => res.json())
    .then(data => {
        if (data.ok) {
            modal.classList.add('active');
        } else {
            alert("Error al procesar pedido");
            enviando = false;
            boton.disabled = false;
        }
    })
    .catch(() => {
        alert("Error de conexión");
        enviando = false;
        boton.disabled = false;
    });
});
</script>
</body>

</html>