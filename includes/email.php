<?php

// Importa las clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Carga automáticamente las librerías instaladas con Composer
require ROOT_PATH . 'vendor/autoload.php';


// Envía un código de verificación al correo indicado
 
function enviarCodigo($destinatario, $codigo)
{
    // Crear nueva instancia de PHPMailer
    $mail = new PHPMailer(true);

    // ==============================
    // CONFIGURACIÓN SMTP
    // ==============================

    // Usar SMTP
    $mail->isSMTP();

    // Servidor SMTP de Gmail
    $mail->Host = 'smtp.gmail.com';

    // Activar autenticación SMTP
    $mail->SMTPAuth = true;

    // Correo de Gmail desde el que se enviarán los mensajes
    $mail->Username = 'infoviciogames@gmail.com';

    // Contraseña de aplicación generada por Google
    $mail->Password = 'mqgnlhbkpxjktnzm';

    // Tipo de cifrado TLS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    // Puerto SMTP de Gmail
    $mail->Port = 587;

    // ==============================
    // CONFIGURACIÓN DEL REMITENTE
    // ==============================

    // Correo y nombre del remitente
    $mail->setFrom('infoviciogames@gmail.com', 'Viciogames');

    // ==============================
    // DESTINATARIO
    // ==============================

    // Añadir destinatario
    $mail->addAddress($destinatario);

    // ==============================
    // CONFIGURACIÓN DEL EMAIL
    // ==============================

    // Permitir HTML
    $mail->isHTML(true);

    // Codificación UTF-8 para caracteres especiales
    $mail->CharSet = 'UTF-8';

    // Asunto del correo
    $mail->Subject = 'Código de verificación';

    // Contenido HTML del mensaje
    $mail->Body = "
        <h2>Verificación de cuenta</h2>

        <p>Tu código de verificación es:</p>

        <h1>$codigo</h1>

        <p>Si no has solicitado este registro, ignora este mensaje.</p>
    ";

    // ==============================
    // ENVIAR CORREO
    // ==============================

    return $mail->send();
}