<?php
//include_once(__DIR__.'/../../modelo/conector/conector.php');
include_once(__DIR__.'/../../control/ABMusuario.php');
include_once(__DIR__.'/../../modelo/Usuario.php');
include_once(__DIR__.'/../../control/ABMPassReset.php');
$datos = $_POST;
$token = $datos['token'] ?? '';
$pass1 = $datos['uspass'] ?? '';
$pass2 = $datos['uspass2'] ?? '';

//Validación básica de contraseñas
if ($pass1 !== $pass2) {
    header("Location: ../vista/actualizarPass.php?token=$token&error=" . urlencode("Las contraseñas no coinciden."));
    exit;
}

//$db = new BaseDatos();

//Verificamos que el token siga siendo válido
/*
$sqlToken = "SELECT usmail FROM pass_reset WHERE token = '$token' AND usado = 0 LIMIT 1";
$cant = $db->ejecutar($sqlToken);
*/
$abmPass=new ABMPassReset();
$objPass=$abmPass->buscar(['token'=>$token, 'usado'=>0]);
if ($objPass) {
    /*
    $registroToken = $db->registro();
    $emailUsuario = $registroToken['usmail'];
     */
    //Buscamos al usuario para obtener su ID y sus otros datos (necesarios para el ABM)
    $objAbmUsuario = new AbmUsuario();
    $objUsuario=$objPass->getObjUsuario();
    $deshabilit=$objUsuario->getDesHabilitado_usuario();
    if($deshabilit==null || $deshabilit==""){
        $deshabilit="null";
    }
    $datosUpdate = [
        'idusuario' => $objUsuario->getId_usuario(),
        'usnombre'  => $objUsuario->getNom_usuario(),
        'usmail'    => $objUsuario->getEmail_usuario(),
        'uspass'    => $pass1,
        'usdeshabilitado' => $deshabilit 
    ];
    $modifica=$objAbmUsuario->modificar($datosUpdate);
    if ($modifica) {
        /*
        $sqlInvalidar = "UPDATE pass_reset SET usado = 1 WHERE token = '$token'";
        $db->ejecutar($sqlInvalidar);
        */
        $id=$objPass->getIdPass();
        $modificaPass=$abmPass->modificacion(['id'=>$id, 'usado'=>1]);

        $msj = "Contraseña actualizada correctamente. Ya puedes iniciar sesión.";
        header("Location: ../login.php?mensaje=" . urlencode($msj));
        exit;

    } else {
        $error = "Error al intentar actualizar la base de datos.";
    } 
} else {
    $error = "El token ya no es válido o ha expirado.";
}

// Si hubo algún error en el proceso:
header("Location: ../login.php?error=" . urlencode($error));