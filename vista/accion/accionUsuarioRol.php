<?php
require_once('../../control/ABMUsuarioRol.php');
require_once('../../control/ABMRol.php'); 

$datos = $_REQUEST;
$objAbmUsuarioRol = new ABMUsuarioRol();
$objAbmRol = new AbmRol(); 
$respuesta = false;
$mensaje = "";

if (isset($datos['operacion'])) {
    
    //Roles de usuarios
    if ($datos['operacion'] == 'listar') {
        if (isset($datos['idusuario'])) {
            $lista = $objAbmUsuarioRol->buscar(['idusuario' => $datos['idusuario']]);
            $arregloSalida = array();
            foreach ($lista as $elem) {
                $nuevoElem = array();
                $nuevoElem["idrol"] = $elem->getobjRol()->getId_rol();
                $nuevoElem["idusuario"] = $elem->getObjUsuario()->getId_usuario();
                $nuevoElem["rodescripcion"] = $elem->getobjRol()->getDescripcion_rol();
                array_push($arregloSalida, $nuevoElem);
            }
            echo json_encode($arregloSalida);
            exit; // Salimos para no imprimir el JSON de abajo
        }
    }

    // agregar rol
    if ($datos['operacion'] == 'alta') {
        if ($objAbmUsuarioRol->alta($datos)) {
            $respuesta = true;
        } else {
            $mensaje = "No se pudo asignar el rol (posiblemente ya lo tenga).";
        }
    }

    // eliminar rol
    if ($datos['operacion'] == 'baja') {
        if ($objAbmUsuarioRol->baja($datos)) {
            $respuesta = true;
        } else {
            $mensaje = "No se pudo quitar el rol.";
        }
    }
}

$retorno['success'] = $respuesta;
$retorno['errorMsg'] = $mensaje;
echo json_encode($retorno);
?>