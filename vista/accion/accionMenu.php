<?php
require_once('../../control/ABMMenu.php');
require_once('../../modelo/Menu.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData();

//$datos = $_REQUEST;  Captura tanto $_GET como $_POST (mando idmenu y operacion por get)
$objAbmMenu = new ABMMenu();
$respuesta = false;
$mensajeError = "";

if (isset($datos['operacion'])) {

    
    //Tratamiento del Padre (Si viene vacío o dice "null", es raíz)
    if (isset($datos['idpadre'])) {
        if ($datos['idpadre'] == "" || $datos['idpadre'] == "null") {
            $datos['idpadre'] = null;
        }
    }

    if (isset($datos['medeshabilitado'])) {
        if ($datos['medeshabilitado'] == 'Habilitado') {
            $datos['medeshabilitado'] = null; 
        } elseif ($datos['medeshabilitado'] == 'Deshabilitado') {
            $datos['medeshabilitado'] = date('Y-m-d H:i:s'); 
        }
    }

    // --- OPERACIONES ---

        // agregar menu
    if ($datos['operacion'] == 'alta') {
        if ($objAbmMenu->alta($datos)) {
            $respuesta = true;
        } else {
            $mensaje = "No se pudo crear el menu.";
        }
    }

    // eliminar rol
    if ($datos['operacion'] == 'modificacion') {
        if ($objAbmMenu->modificacion($datos)) {
            $respuesta = true;
        } else {
            $mensaje = "No se pudo modificar el menu.";
        }
    }

    if ($datos['operacion'] == 'baja') {

        if ($objAbmMenu->baja($datos)) {
            $respuesta = true;
        } else {
            $mensajeError = "No se pudo eliminar el menú. Verifique que no tenga roles asignados o hijos.";
        }
    }

} else {
    $mensajeError = "No se especificó operación.";
}

// Retorno JSON para EasyUI
if ($respuesta) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('errorMsg' => $mensajeError));
}
?>