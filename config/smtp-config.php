<?php
// Configuración SMTP
// IMPORTANTE: Cambiar estas credenciales por las reales antes de usar en producción

function envv($k) { return $_ENV[$k] ?? $_SERVER[$k] ?? getenv($k); }

return [
    // Configuración del servidor SMTP
    'smtp_host' => envv('SMTP_HOST') ?: 'smtp.hostinger.com', // Cambiar por tu servidor SMTP
    'smtp_port' => envv('SMTP_PORT') ? (int) envv('SMTP_PORT') : 465, // Puerto SMTP (587 para TLS, 465 para SSL)
    'smtp_username' => envv('SMTP_USER') ?: 'tu-email@tudominio.com', // Tu email SMTP
    'smtp_password' => envv('SMTP_PASS') ?: 'tu-password-app', // Tu contraseña de aplicación
    'smtp_encryption' => envv('SMTP_ENCRYPTION') ?: 'ssl', // 'tls' o 'ssl'

    // Configuración del email
    'from_email' => envv('FROM_EMAIL') ?: 'tu-email@tudominio.com', // Email del remitente
    'from_name' => envv('FROM_NAME') ?: 'Webpsico.com - Formulario de Contacto',
    'admin_email' => envv('ADMIN_EMAIL') ?: 'admin@webpsico.com', // Email del administrador que recibirá las consultas
    'admin_name' => envv('ADMIN_NAME') ?: 'Administrador Webpsico',

    // Configuración adicional
    'reply_to_user' => envv('REPLY_TO_USER') ? filter_var(envv('REPLY_TO_USER'), FILTER_VALIDATE_BOOLEAN) : true, // Si responder al usuario que envió el formulario
    'send_copy_to_user' => envv('SEND_COPY_TO_USER') ? filter_var(envv('SEND_COPY_TO_USER'), FILTER_VALIDATE_BOOLEAN) : false, // Si enviar copia al usuario
    'debug_mode' => envv('MAIL_DEBUG') ? filter_var(envv('MAIL_DEBUG'), FILTER_VALIDATE_BOOLEAN) : false, // Activar para debugging (solo en desarrollo)
];
?>
