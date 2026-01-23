<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'fc46900b2e72ee';
        $mail->Password = '41b27dbec30d3e';

        $mail->setFrom('cuentas@uptask.com', 'UpTask');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu Cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Definir el contenido con estilos en línea (Inline Styles)
        $contenido = '<html>';
        $contenido .= '<style>';
        $contenido .= 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }';
        $contenido .= '</style>';

        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">';

        // Contenedor principal gris
        $contenido .= '<div style="width: 100%; background-color: #f4f4f4; padding: 40px 0;">';

        // Tarjeta blanca centrada
        $contenido .= '<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">';

        // Logo / Título
        $contenido .= '<h1 style="color: #DB2777; text-align: center; font-size: 32px; margin-bottom: 30px;">UpTask</h1>';

        // Texto Saludo
        $contenido .= '<p style="color: #4B5563; font-size: 18px; line-height: 1.6; margin-bottom: 20px;"><strong>Hola ' . $this->nombre . '</strong>,</p>';
        $contenido .= '<p style="color: #4B5563; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">Has creado tu cuenta en UpTask correctamente. Solo debes confirmarla presionando el siguiente botón:</p>';

        // Botón de Acción
        $contenido .= '<div style="text-align: center; margin-bottom: 30px;">';
        $contenido .= '<a href="http://uptask.test/confirmar?token=' . $this->token . '" style="background-color: #DB2777; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; display: inline-block;">Confirmar Cuenta</a>';
        $contenido .= '</div>';

        // Texto alternativo
        $contenido .= '<p style="color: #4B5563; font-size: 14px; line-height: 1.6; margin-bottom: 10px;">Si tú no solicitaste esta cuenta, puedes ignorar este mensaje.</p>';

        // Footer
        $contenido .= '<div style="border-top: 1px solid #e5e7eb; margin-top: 30px; padding-top: 20px; text-align: center;">';
        $contenido .= '<p style="color: #9CA3AF; font-size: 12px;">Este correo fue enviado automáticamente por UpTask.</p>';
        $contenido .= '</div>';

        $contenido .= '</div>'; // Fin tarjeta blanca
        $contenido .= '</div>'; // Fin contenedor gris
        $contenido .= '</body>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }

    public function enviarInstrucciones()
    {
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'fc46900b2e72ee';
        $mail->Password = '41b27dbec30d3e';

        $mail->setFrom('cuentas@uptask.com', 'UpTask');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu Password';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        // Definir el contenido con estilos en línea (Inline Styles)
        $contenido = '<html>';
        $contenido .= '<style>';
        $contenido .= 'body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }';
        $contenido .= '</style>';

        $contenido .= '<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">';

        // Contenedor principal gris
        $contenido .= '<div style="width: 100%; background-color: #f4f4f4; padding: 40px 0;">';

        // Tarjeta blanca centrada
        $contenido .= '<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">';

        // Logo / Título
        $contenido .= '<h1 style="color: #DB2777; text-align: center; font-size: 32px; margin-bottom: 30px;">UpTask</h1>';

        // Texto Saludo
        $contenido .= '<p style="color: #4B5563; font-size: 18px; line-height: 1.6; margin-bottom: 20px;"><strong>Hola ' . $this->nombre . '</strong>,</p>';
        $contenido .= '<p style="color: #4B5563; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">Parece que has olvidado tu password, sigue el siguiente enlace para recuperarlo</p>';

        // Botón de Acción
        $contenido .= '<div style="text-align: center; margin-bottom: 30px;">';
        $contenido .= '<a href="http://uptask.test/reestablecer?token=' . $this->token . '" style="background-color: #DB2777; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px; display: inline-block;">Reestablecer Password</a>';
        $contenido .= '</div>';

        // Texto alternativo
        $contenido .= '<p style="color: #4B5563; font-size: 14px; line-height: 1.6; margin-bottom: 10px;">Si tú no solicitaste esta cuenta, puedes ignorar este mensaje.</p>';

        // Footer
        $contenido .= '<div style="border-top: 1px solid #e5e7eb; margin-top: 30px; padding-top: 20px; text-align: center;">';
        $contenido .= '<p style="color: #9CA3AF; font-size: 12px;">Este correo fue enviado automáticamente por UpTask.</p>';
        $contenido .= '</div>';

        $contenido .= '</div>'; // Fin tarjeta blanca
        $contenido .= '</div>'; // Fin contenedor gris
        $contenido .= '</body>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar el email
        $mail->send();
    }
}
