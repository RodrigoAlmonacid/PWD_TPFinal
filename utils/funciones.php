<?php
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer; //este se encarge de los mails
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf; //este arma los pdf

function enviarMail($destinatario, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);
    $manda=false;
    if(isset($cuerpo['pdf'])){
        $mail->addStringAttachment($cuerpo['pdf'], "Resumen_Compra.pdf");
        $cuerpo=$cuerpo['cuerpo'];
    }
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
        $manda=true;
    } catch (Exception $e) {
        // Aquí podrías guardar el error en un log
        error_log("Error al enviar mail: {$mail->ErrorInfo}");
    }
    return $manda;
}

/** le paso un array de compra y el usuario
 * @param array $compra arreglo con el detalle de la compra
 * @param string $usuario nombre del usuario
 * @param date $fecha en que se realiza el pago
 * @return 
 */
function preparaPdf($compra, $usuario, $fecha){
    //PROCESAR EL LOGO
    $rutaLogo =__DIR__."/../imagenes/logoCorreo.jpg";
    $tipoArchivo = pathinfo($rutaLogo, PATHINFO_EXTENSION);
    $datosLogo = file_get_contents($rutaLogo);
    $base64Logo = 'data:image/' . $tipoArchivo . ';base64,' . base64_encode($datosLogo);

    //TABLA DE PRODUCTOS
    $total = 0;
    $filasProductos = "";
    foreach ($compra as $producto){
        $filasProductos .= "
            <tr>
                <td>".$producto['nombre']."</td>
                <td style='text-align: center;'>".$producto['cantidad']."</td>
                <td style='text-align: right;'>$".number_format($producto['precio'], 2, ',', '.')."</td>
            </tr>";
            $total = $total + ($producto['cantidad'] * $producto['precio']);
    }

    //PLANTILLA HTML CON CSS INLINE
    $htmlFactura = "
    <html>
    <head>
        <style>
            body { font-family: sans-serif; color: #333; }
            .header { width: 100%; border-bottom: 2px solid #ffcc00; padding-bottom: 10px; }
            .logo { width: 150px; }
            .info-empresa { text-align: right; font-size: 12px; }
            .titulo-factura { text-align: center; margin: 20px 0; color: #444; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th { background-color: #ffcc00; color: #000; padding: 10px; text-align: left; }
            td { padding: 10px; border-bottom: 1px solid #eee; }
            .total { text-align: right; font-size: 18px; margin-top: 20px; font-weight: bold; }
            .footer { text-align: center; font-size: 10px; color: #888; margin-top: 50px; }
        </style>
    </head>
    <body>
        <table class='header'>
            <tr>
                <td><img src='$base64Logo' class='logo'></td>
                <td class='info-empresa'>
                    <strong>Ponete las Pilas S.A.</strong><br>
                    Calle Falsa 123, Neuquén<br>
                    contacto@ponetelas.com
                </td>
            </tr>
        </table>

        <h2 class='titulo-factura'>RESUMEN DE COMPRA</h2>

        <p><strong>Cliente:</strong> $usuario</p>
        <p><strong>Fecha de Pago:</strong> $fecha</p>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style='text-align: center;'>Cant.</th>
                    <th style='text-align: right;'>Precio Unit.</th>
                </tr>
            </thead>
            <tbody>
                $filasProductos
            </tbody>
        </table>

        <div class='total'>Total Pagado: $".number_format($total, 2, ',', '.')."</div>

        <div class='footer'>
            Este es un comprobante de pago generado automáticamente por el sistema.<br>
            Gracias por confiar en <strong>Ponete las Pilas</strong>.
        </div>
    </body>
    </html>";

    // --- 4. GENERACIÓN DEL PDF ---
    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($htmlFactura);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    return $dompdf->output();
}
?>