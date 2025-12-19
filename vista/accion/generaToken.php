<?php
include_once(__DIR__.'/../../modelo/conector/conector.php');
include_once(__DIR__.'/../../control/ABMusuario.php');
include_once(__DIR__.'/../../utils/funciones.php');
$datos = $_POST;

$objAbmUsuario = new AbmUsuario();
$listaUsuarios = $objAbmUsuario->buscar(['usmail' => $datos['usmail']]);

if (count($listaUsuarios) > 0) {
    // 1. Generar un Token seguro e irrepetible
    $token = bin2hex(random_bytes(32)); 
    
    // 2. Definir vencimiento (Ahora + 1 hora)
    $vencimiento = date("Y-m-d H:i:s", strtotime('+1 hour'));

    // 3. Guardar en la tabla password_resets (necesitarás un ABM para esto o una consulta directa)
    // Supongamos una inserción directa para simplificar:
    $db = new BaseDatos();
    $sql = "INSERT INTO pass_reset (usmail, token, vencimiento) VALUES ('{$datos['usmail']}', '$token', '$vencimiento')";
    
    if ($db->ejecutar($sql)) {
        // 4. Enviar el Mail
        $enlace = "http://localhost/PWD_TPFinal/vista/actualizarPass.php?token=" . $token;
        
        $asunto = "Recuperación de Contraseña - Ponete las Pilas";
        $cuerpo = "
            <h2>¿Olvidaste tu contraseña?</h2>
            <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
            <p>Haz clic en el siguiente enlace para elegir una nueva:</p>
            <a href='$enlace' style='background-color: #ffc107; color: black; padding: 10px; text-decoration: none; font-weight: bold;'>
                Restablecer Contraseña
            </a>
            <p>Este enlace expirará en 1 hora.</p>
            <p>Si no solicitaste esto, ignora este correo.</p>
        ";

        enviarMail($datos['usmail'], $asunto, $cuerpo);
    }
}

// Por seguridad, siempre mostramos el mismo mensaje:
$mensaje = "Si el correo coincide con una cuenta activa, recibirás un enlace en breve.";
header("Location: ../login.php?mensaje=" . urlencode($mensaje));