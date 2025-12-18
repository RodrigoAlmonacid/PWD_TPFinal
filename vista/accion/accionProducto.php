<?php
require_once('../../control/ABMProducto.php');
require_once('../../modelo/Producto.php'); 

$abmProducto = new ABMProducto();
$respuesta = array('success' => false, 'errorMsg' => 'Operación no reconocida.');

// Obtener la operación a realizar
$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : '';
$datos = $_POST; 

if ($operacion == 'guardar') {
    $param_abm = array(
        'pronombre' => $datos['pronombre'], 
        'prodetalle' => $datos['prodetalle'], 
        'procantstock' => $datos['procantstock'],
        'proprecio' => $datos['proprecio'],
        'proimagen' => $datos['proimagen'],
    );
    
    if ($abmProducto->alta($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la inserción (ABM/Producto).';
    }

} elseif ($operacion == 'actualizar') {
    // Para actualizar, necesitamos el 'idProducto' y los nuevos datos.
    $datos['idproducto'] = $_GET['id'];

    $param_abm = array(
        'idproducto' => $datos['idproducto'],
        'pronombre' => $datos['pronombre'], 
        'prodetalle' => $datos['prodetalle'], 
        'procantstock' => $datos['procantstock'],
        'proprecio' => $datos['proprecio'],
        'proimagen' => $datos['proimagen'],
        'prodeshabilitado' => $datos['prodeshabilitado']
    );
    if ($abmProducto->modificar($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la modificación (Revisar logs o clase ABM/Producto). id:'.$param_abm['idproducto'];
    }
    
} elseif ($operacion == 'eliminar') { 

    $param_abm = array(
        'idproducto' => $datos['id']);

    if ($abmProducto->baja($param_abm)) {
        $respuesta = array('success' => true);
    } else {
        $respuesta['errorMsg'] = 'Fallo en la baja (Revisar logs o clase ABM/Producto).';
    }
}

//Enviar la respuesta en JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>