<?php
// Configurar headers para respuesta JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Solo permitir método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Cargar configuración
$config = require_once 'config/smtp-config.php';

// Función para limpiar datos de entrada
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Función para validar email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Obtener y validar datos del formulario
$nombre = sanitizeInput($_POST['nombre'] ?? '');
$correo = sanitizeInput($_POST['correo'] ?? '');
$consulta = sanitizeInput($_POST['consulta'] ?? '');

// Validaciones del servidor
$errors = [];

if (empty($nombre)) {
    $errors[] = 'El nombre es requerido';
} elseif (strlen($nombre) < 2) {
    $errors[] = 'El nombre debe tener al menos 2 caracteres';
}

if (empty($correo)) {
    $errors[] = 'El correo electrónico es requerido';
} elseif (!validateEmail($correo)) {
    $errors[] = 'El correo electrónico no es válido';
}

if (empty($consulta)) {
    $errors[] = 'La consulta es requerida';
} elseif (strlen($consulta) < 10) {
    $errors[] = 'La consulta debe tener al menos 10 caracteres';
} elseif (strlen($consulta) > 500) {
    $errors[] = 'La consulta no puede exceder 500 caracteres';
}

// Si hay errores, devolver respuesta de error
if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Cargar PHPMailer
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

try {
    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    // Configuración del servidor SMTP
    if ($config['debug_mode']) {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    }

    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_username'];
    $mail->Password = $config['smtp_password'];
    $mail->SMTPSecure = $config['smtp_encryption'];
    $mail->Port = $config['smtp_port'];
    $mail->CharSet = 'UTF-8';

    // Configurar remitente
    $mail->setFrom($config['from_email'], $config['from_name']);

    // Configurar destinatario (administrador)
    $mail->addAddress($config['admin_email'], $config['admin_name']);

    // Configurar respuesta al usuario
    if ($config['reply_to_user']) {
        $mail->addReplyTo($correo, $nombre);
    }

    // Configurar asunto
    $mail->Subject = 'Nueva consulta desde Webpsico.com - ' . $nombre;

    // Crear contenido HTML del email
    $htmlContent = createEmailTemplate($nombre, $correo, $consulta);

    // Configurar contenido del email
    $mail->isHTML(true);
    $mail->Body = $htmlContent;
    $mail->AltBody = "Nueva consulta de: $nombre\nEmail: $correo\nConsulta: $consulta";

    // Enviar email
    $mail->send();

    // Si se configuró enviar copia al usuario
    if ($config['send_copy_to_user']) {
        $mail->clearAddresses();
        $mail->addAddress($correo, $nombre);
        $mail->Subject = 'Confirmación de consulta - Webpsico.com';
        $mail->Body = createUserConfirmationTemplate($nombre);
        $mail->send();
    }

    // Respuesta exitosa
    echo json_encode([
        'success' => true,
        'message' => '¡Consulta enviada exitosamente! Te contactaremos pronto.'
    ]);

} catch (Exception $e) {
    // Log del error (en producción, usar un sistema de logs apropiado)
    error_log("Error enviando email: " . $mail->ErrorInfo);

    // Respuesta de error
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar la consulta. Por favor, intenta nuevamente.'
    ]);
}

// Función para crear template HTML del email
function createEmailTemplate($nombre, $correo, $consulta) {
    $fecha = date('d/m/Y H:i:s');

    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #3D65AA; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #3D65AA; }
            .value { margin-top: 5px; padding: 10px; background-color: white; border-left: 4px solid #3D65AA; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nueva Consulta - Webpsico.com</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <div class='label'>Fecha y hora:</div>
                    <div class='value'>$fecha</div>
                </div>
                <div class='field'>
                    <div class='label'>Nombre:</div>
                    <div class='value'>$nombre</div>
                </div>
                <div class='field'>
                    <div class='label'>Correo electrónico:</div>
                    <div class='value'>$correo</div>
                </div>
                <div class='field'>
                    <div class='label'>Consulta:</div>
                    <div class='value'>" . nl2br(htmlspecialchars($consulta)) . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>Este email fue enviado desde el formulario de contacto de Webpsico.com</p>
            </div>
        </div>
    </body>
    </html>";
}

// Función para crear template de confirmación para el usuario
function createUserConfirmationTemplate($nombre) {
    return "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #3D65AA; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Confirmación de Consulta - Webpsico.com</h2>
            </div>
            <div class='content'>
                <p>Hola $nombre,</p>
                <p>Hemos recibido tu consulta correctamente. Nuestro equipo la revisará y te contactaremos pronto.</p>
                <p>Gracias por confiar en Webpsico.com para tu bienestar mental.</p>
                <p>Saludos cordiales,<br>Equipo Webpsico.com</p>
            </div>
        </div>
    </body>
    </html>";
}
?>
