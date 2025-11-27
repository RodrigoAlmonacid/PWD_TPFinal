<?php
require_once('../../control/ABMMenu.php');
require_once('../../modelo/Menu.php');
$objMenu = new ABMMenu();

// Buscamos todos los menús
$listaMenus = $objMenu->buscar(null);
$arregloSalida = array();

foreach ($listaMenus as $elem) {
    $nuevoElem = array();
    $nuevoElem["idmenu"] = $elem->getIdMenu();
    $nuevoElem["menombre"] = $elem->getMeNombre();
    $nuevoElem["medescripcion"] = $elem->getMeDescripcion();
    $nuevoElem["idpadre"] = $elem->getIdPadre();
    $estado = $elem->getMeDeshabilitado();
        if($estado==null){
            $estado="Habilitado";
        }
        else{
            $estado="Deshabilitado";
        }
    $nuevoElem["medeshabilitado"] = $estado;
    
    // --- ESTO ES LO IMPORTANTE PARA EASYUI TREEGRID ---
    // Si tiene padre, le agregamos la propiedad _parentId
    if ($elem->getIdPadre() != null && $elem->getIdPadre() != "") {
        $nuevoElem["_parentId"] = $elem->getIdPadre();
    }
    // -------------------------------------------------

    array_push($arregloSalida, $nuevoElem);
}

echo json_encode($arregloSalida);
?>