<?php
require_once(__DIR__.'/../../control/ABMMenu.php');
require_once(__DIR__.'/../../modelo/Menu.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

//capturo los datos 
$datos = getSubmittedData();

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

    //operaciones que vienen por get

    // agregar menu
    if ($datos['operacion'] == 'alta') {
        if ($objAbmMenu->alta($datos)) {
            $respuesta = true;
        } else {
            $mensaje = "No se pudo crear el menu.";
        }
    }

    // modifica rol
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
    $mensajeError = "No se especificó la operación.";
}

// Retorno JSON para EasyUI, si respuesta es true
if ($respuesta) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('errorMsg' => $mensajeError));
}
?>