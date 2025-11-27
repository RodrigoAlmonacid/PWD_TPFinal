<?php
// Incluye tu configuración principal
require_once('../../control/ABMMenu.php');
require_once('../../modelo/Menu.php');
// Asegúrate de que cargue la clase ABMMenu (si el config no lo hace, descomenta la siguiente línea)
// include_once '../../control/ABMMenu.php';

$datos = $_REQUEST; // Captura tanto $_GET como $_POST
$objAbmMenu = new ABMMenu();
$respuesta = false;
$mensajeError = "";

if (isset($datos['operacion'])) {

    // --- PROCESAMIENTO DE DATOS PREVIO ---
    
    // 1. Tratamiento del Padre (Si viene vacío o dice "null", es raíz)
    if (isset($datos['idpadre'])) {
        if ($datos['idpadre'] == "" || $datos['idpadre'] == "null") {
            $datos['idpadre'] = null;
        }
    }

    // 2. Tratamiento del Deshabilitado (Igual que en Usuario)
    // Si viene del combo de EasyUI como texto:
    if (isset($datos['medeshabilitado'])) {
        if ($datos['medeshabilitado'] == 'Habilitado') {
            $datos['medeshabilitado'] = null; // Se guardará como NULL
        } elseif ($datos['medeshabilitado'] == 'Deshabilitado') {
            $datos['medeshabilitado'] = date('Y-m-d H:i:s'); // Se guarda la fecha actual
        }
    }

    // --- OPERACIONES ---

    if ($datos['operacion'] == 'alta') {
        if ($objAbmMenu->alta($datos)) {
            $respuesta = true;
        } else {
            $mensajeError = "No se pudo crear el menú.";
        }
    }

    if ($datos['operacion'] == 'modificacion') {
        // Aseguramos que el ID venga en los datos
        if (!isset($datos['idmenu']) && isset($_GET['idmenu'])) {
            $datos['idmenu'] = $_GET['idmenu'];
        }

        if ($objAbmMenu->modificacion($datos)) {
            $respuesta = true;
        } else {
            $mensajeError = "No se pudo modificar el menú.";
        }
    }

    if ($datos['operacion'] == 'baja') {
        // En baja solo necesitamos el ID
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