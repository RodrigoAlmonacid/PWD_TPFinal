<?php
// IMPORTANTE: Ajusta estas rutas
require_once('../../control/ABMusuario.php');
require_once('../../modelo/Usuario.php'); 

$abmUsuario = new ABMUsuario();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');

// Obtener la operación a realizar
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$datos = $_POST; // Los datos del formulario o del post se envían aquí

if ($operacion == 'guardar') {
    // La función 'cargar' en ABMUsuario espera ciertos nombres de campos.
    // El formulario de EasyUI envía 'firstname', 'lastname', 'email', etc.
    // Debes mapear los datos del formulario a los nombres que tu ABM espera:
    $param_abm = array(
        'usnombre' => $datos['usnombre'], 
        'uspass' => $datos['uspass'], 
        'usmail' => $datos['usmail'],
    );
    
    if ($abmUsuario->alta($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        // En un escenario real, aquí se usaría $abmUsuario->getMensajeError()
        $respuesta['errorMsg'] = 'Fallo en la inserción (Revisar logs o clase ABM/Usuario).';
    }

} elseif ($operacion == 'actualizar') {
    // Para actualizar, necesitamos el 'idusuario' y los nuevos datos.
    $datos['idusuario'] = $_GET['id']; // Obtenido del parámetro &id=...
    
    // Mapear los datos del formulario (igual que en 'guardar')
    $param_abm = array(
        'idusuario' => $datos['idusuario'],
        'usnombre' => $datos['unnombre'],
        'usmail' => $datos['usmail'],
        // Para la contraseña, debes manejar la lógica de si se envía o no.
    );

    if ($abmUsuario->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (Revisar logs o clase ABM/Usuario).';
    }
    
} elseif ($operacion == 'eliminar') { 
    // Para deshabilitar/baja lógica, que en tu ABM es el método 'estado' dentro de 'baja'.
    $param_abm = array(
        'idusuario' => $datos['id'] // Obtenido del $.post
    );
    
    if ($abmUsuario->baja($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la baja (Revisar logs o clase ABM/Usuario).';
    }
}

// 4. Enviar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>