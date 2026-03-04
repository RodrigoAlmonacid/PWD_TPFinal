<?php
//include_once(__DIR__.'/../../modelo/conector/conector.php');
include_once(__DIR__.'/../../control/ABMusuario.php');
include_once(__DIR__.'/../../control/ABMPassReset.php');
include_once(__DIR__.'/../../utils/funciones.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos=getSubmittedData();

$objAbmUsuario = new AbmUsuario();
$listaUsuarios = $objAbmUsuario->buscar(['usmail' => $datos['usmail']]);

if (count($listaUsuarios) > 0) {
    //Generar un Token seguro e irrepetible
    $token = bin2hex(random_bytes(32)); //el rand genera 32 byts (256 bits), el bin2 lo pasa a hexadecimal
    $datos['idusuario']=$listaUsuarios[0]->getId_usuario();
    //Definir vencimiento (Ahora + 1 hora)
    $vencimiento = date("Y-m-d H:i:s", strtotime('+1 hour'));
    $abmPass=new ABMPassReset();
    $param=[
        'token'=>$token,
        'vencimiento'=>$vencimiento,
        'usmail'=>$datos['usmail']
    ];
    $alta=$abmPass->alta($param); //inserto el passReset
    if ($alta) {
        //si puedo dar el alta mando el email
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

        enviarMail($datos['usmail'], $asunto, $cuerpo); //mi función de envio de mails
    }
}

// Por seguridad, siempre mostramos el mismo mensaje: (esto es para que no me adivinen el email de un usuario)
$mensaje = "Si el correo coincide con una cuenta activa, recibirás un enlace en breve.";
header("Location: ../login.php?mensaje=" . urlencode($mensaje));