<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <base href="http://viciogames.test">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - VicioGames</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/prueba.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<?php include ROOT_PATH . 'includes/header-user.php'; ?>

<main class="container mt-5 mb-5">

    <h2 class="mb-4 fw-bold">CONTACTO</h2>
    <hr>

    <div class="row g-4">

        <!-- FORMULARIO -->
        <div class="col-md-6">
            <div class="bg-white p-4 h-100">
                <h5 class="mb-3">Envíanos un mensaje</h5>

                <form action="procesar-contacto" method="POST">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Mensaje</label>
                        <textarea name="mensaje" class="form-control" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Enviar mensaje
                    </button>
                </form>
            </div>
        </div>

        <!-- INFO + MAPA -->
        <div class="col-md-6">
            <div class="bg-white p-4 h-100">

                <h5 class="mb-3">Información de contacto</h5>

                <p class="footer-contact">
                    <i class="bi bi-telephone-fill"></i>
                    +34 626 45 33 43
                </p>

                <p class="footer-contact">
                    <i class="bi bi-envelope-fill"></i>
                    viciogames@gmail.com
                </p>

                <hr>

                <h6 class="mb-3">Dónde estamos</h6>

                <!-- IFRAME MAPA -->
                <div style="border-radius: 12px; overflow: hidden;">
                    <iframe 
                        src="https://www.google.com/maps?q=Pamplona&output=embed"
                        width="100%" 
                        height="300" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>

            </div>
        </div>

    </div>

    <!-- REDES -->
    <div class="row mt-5">
        <div class="col-md-12 text-center">

            <h4 class="mb-4">REDES SOCIALES</h4>

            <ul class="list-unstyled footer-social">
                <li><a href="#" class="text-black"><i class="bi bi-instagram"></i> Instagram</a></li>
                <li><a href="#" class="text-black"><i class="bi bi-facebook"></i> Facebook</a></li>
                <li><a href="#" class="text-black"><i class="bi bi-twitter-x"></i> Twitter</a></li>
            </ul>

        </div>
    </div>

</main>

<?php include ROOT_PATH . 'includes/footer.php'; ?>

</body>
</html>