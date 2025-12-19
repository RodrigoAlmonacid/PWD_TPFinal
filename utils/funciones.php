<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarMail($destinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);

    try {
        // --- Configuración del Servidor ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // O el de tu proveedor
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rodrigo.almonacid@est.fi.uncoma.edu.ar';
        $mail->Password   = 'lvmn nnlr fkhw tycy'; //contra de app mailPHP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // --- Configuración del Correo ---
        $mail->setFrom('rodrigo.almonacid@est.fi.uncoma.edu.ar', 'Sistema Ponete las Pilas');
        $mail->addAddress($destinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        $mail->CharSet = 'UTF-8'; // Para que las tildes se vean bien

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Aquí podrías guardar el error en un log
        error_log("Error al enviar mail: {$mail->ErrorInfo}");
        return false;
    }
}
?>