<?php
// Ajusta el namespace según tu estructura, por ejemplo:
// namespace Util; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Asegúrate de que este path apunte correctamente a tu autoload
require_once __DIR__ . '/../vendor/autoload.php'; 

class MailSender {
    
    public function enviarConfirmacionCompra($emailCliente, $nombreCliente, $datosCompra) {
        $mail = new PHPMailer(true);

        try {
            // --- Configuración del Servidor (Gmail ejemplo) ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'suplementosdundermifflin@gmail.com'; // TU GMAIL
            $mail->Password   = 'nkja axwg ldty uekl'; // OJO: Ver Paso 4
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // --- Remitente y Destinatario ---
            $mail->setFrom('suplementosdundermifflin@gmail.com', 'TP Final PWD');
            $mail->addAddress($emailCliente, $nombreCliente);

            // --- Contenido del Mail ---
            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Compra - Pedido #' . $datosCompra['id_pedido'];
            
            // Aquí armas el cuerpo del mail usando los datos
            $cuerpo = "<h1>Hola, {$nombreCliente}!</h1>";
            $cuerpo .= "<p>Recibimos tu compra con éxito.</p>";
            $cuerpo .= "<h3>Detalle:</h3>";
            $cuerpo .= "<ul>";
            foreach ($datosCompra['items'] as $producto) {
                $cuerpo .= "<li>{$producto['nombre']} - ${$producto['precio']}</li>";
            }
            $cuerpo .= "</ul>";
            $cuerpo .= "<p>Total: $<strong>{$datosCompra['total']}</strong></p>";

            $mail->Body = $cuerpo;

            $mail->send();
            return ['exito' => true, 'msg' => 'Correo enviado'];

        } catch (Exception $e) {
            return ['exito' => false, 'msg' => "Error al enviar: {$mail->ErrorInfo}"];
        }
    }
}