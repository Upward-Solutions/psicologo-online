<?php
// Configuración SMTP
// IMPORTANTE: Cambiar estas credenciales por las reales antes de usar en producción

return [
    // Configuración del servidor SMTP
    'smtp_host' => 'smtp.gmail.com', // Cambiar por tu servidor SMTP
    'smtp_port' => 587, // Puerto SMTP (587 para TLS, 465 para SSL)
    'smtp_username' => 'tu-email@gmail.com', // Tu email SMTP
    'smtp_password' => 'tu-password-app', // Tu contraseña de aplicación
    'smtp_encryption' => 'tls', // 'tls' o 'ssl'

    // Configuración del email
    'from_email' => 'tu-email@gmail.com', // Email del remitente
    'from_name' => 'Webpsico.com - Formulario de Contacto',
    'admin_email' => 'admin@webpsico.com', // Email del administrador que recibirá las consultas
    'admin_name' => 'Administrador Webpsico',

    // Configuración adicional
    'reply_to_user' => true, // Si responder al usuario que envió el formulario
    'send_copy_to_user' => false, // Si enviar copia al usuario
    'debug_mode' => false, // Activar para debugging (solo en desarrollo)
];
?>
