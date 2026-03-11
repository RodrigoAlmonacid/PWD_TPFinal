<?php
require_once(__DIR__.'/../../control/ABMusuario.php');
require_once(__DIR__.'/../../modelo/Usuario.php'); 
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData();
$abmUsuario = new ABMUsuario();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');

// Obtener la operación a realizar
$operacion = isset($datos['operacion']) ? $datos['operacion'] : '';

if ($operacion == 'guardar') {
    $param_abm = array(
        'usnombre' => $datos['usnombre'], 
        'uspass' => $datos['uspass'], 
        'usmail' => $datos['usmail'],
    );
    
    if ($abmUsuario->alta($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la inserción (revisar alta() en ABMUsuario).';
    }

} elseif ($operacion == 'actualizar') {
    // Para actualizar, necesitamos el 'idusuario' y los nuevos datos.
    $datos['idusuario'] = $datos['id'];

    $param_abm = array(
        'idusuario' => $datos['idusuario'],
        'usnombre' => $datos['usnombre'],
        'usmail' => $datos['usmail'],
        'usdeshabilitado' => $datos['usdeshabilitado']
    );
    if ($abmUsuario->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (Revisar modificar() en  ABMUsuario). id:'.$param_abm['idusuario'];
    }
    
} elseif ($operacion == 'eliminar') { 

    $param_abm = array(
        'idusuario' => $datos['id']);

    if ($abmUsuario->baja($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la baja (Revisar baja() en ABMUsuario).';
    }
}

//Enviar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>