<?php
require_once('../../control/ABMusuario.php');
require_once('../../modelo/Usuario.php'); 

$abmUsuario = new ABMUsuario();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');

// Obtener la operación a realizar
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$datos = $_POST; 

if ($operacion == 'guardar') {
    $param_abm = array(
        'usnombre' => $datos['usnombre'], 
        'uspass' => $datos['uspass'], 
        'usmail' => $datos['usmail'],
    );
    
    if ($abmUsuario->alta($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la inserción (ABM/Usuario).';
    }

} elseif ($operacion == 'actualizar') {
    // Para actualizar, necesitamos el 'idusuario' y los nuevos datos.
    $datos['idusuario'] = $_GET['id'];

    $param_abm = array(
        'idusuario' => $datos['idusuario'],
        'usnombre' => $datos['usnombre'],
        'usmail' => $datos['usmail'],
        'usdeshabilitado' => $datos['usdeshabilitado']
    );
    if ($abmUsuario->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (Revisar logs o clase ABM/Usuario). id:'.$param_abm['idusuario'];
    }
    
} elseif ($operacion == 'eliminar') { 

    $param_abm = array(
        'idusuario' => $datos['id']);

    if ($abmUsuario->baja($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la baja (Revisar logs o clase ABM/Usuario).';
    }
}

//Enviar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>