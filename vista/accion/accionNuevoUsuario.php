<?php
include_once(__DIR__.'/../../control/ABMusuario.php'); 
include_once(__DIR__.'/../../vendor/autoload.php');
include_once(__DIR__.'/../../utils/funciones.php');//funcion de envío de mails
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData();
$respuesta = "";

//Valida que la contraseña sea la misma
if ($datos['uspass'] !== $datos['uspass2']) {
    header("Location: ../registro.php?error=" . urlencode("Las contraseñas no coinciden."));
    exit;
}

$objAbmUsuario = new AbmUsuario();
//verifico que el mail no esté en la base usado por otro usuario (el mail es clave)
$checkEmail = $objAbmUsuario->buscar(['usmail' => $datos['usmail']]);
if (count($checkEmail) > 0) {
    header("Location: ../registro.php?error=" . urlencode("El email ya está registrado."));
    exit;
}

//armo los datos para el nuevo usuario
$datosRegistro = [
    'usnombre' => $datos['usnombre'],
    'usmail'   => $datos['usmail'],
    'uspass'   => $datos['uspass']
];

//inserto el nuevo usuario con el ABM
$inserta=$objAbmUsuario->alta($datosRegistro);
if ($inserta) {
    //doy aviso al administrador del nuevo usuario por email, el admin debe habilitar al usuario que se crea deshabilitado por defecto
    $adminEmail = "rodrigo.almonacid@est.fi.uncoma.edu.ar"; //acá va el destinatario, podría pensar en una lista de difusión con todos los que tienen el rol de administrador
    $asunto = "Nueva solicitud de registro: " . $datos['usnombre'];
    $cuerpo = "
        <h2>Nuevo usuario pendiente de aprobación</h2>
        <p>Un nuevo usuario se ha registrado en el sistema 'Ponete las pilas' y espera ser habilitado.</p>
        <ul>
            <li><strong>Nombre:</strong> {$datos['usnombre']}</li>
            <li><strong>Email:</strong> {$datos['usmail']}</li>
        </ul>
        <p>Puedes habilitarlo desde el panel de administración de usuarios.</p>
    ";

    //uso la función de mail que usa la librería phpmailer
    try {
        enviarMail($adminEmail, $asunto, $cuerpo); //esta es la función que se encarga del envío
    } catch (Exception $e) {
        header("Location: ../registro.php?error=" . urlencode("Error inesperado. Contactese con adminponetelaspilas@gmail.com"));
    }

    // Redirigir con éxito
    $mensajeExito = "Registro solicitado con éxito. El administrador revisará tu cuenta.";
    header("Location: ../login.php?mensaje=" . urlencode($mensajeExito));
    exit;

} else {
    header("Location: ../registro.php?error=" . urlencode("Error al procesar el registro en la base de datos."));
    exit;
}