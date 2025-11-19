<?php

$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/PWD_TPFinal/";

include_once($ROOT . 'modelo/conector/conector.php');
include_once($ROOT . 'modelo/Usuario.php');
include_once($ROOT . 'modelo/Rol.php');
include_once($ROOT . 'modelo/UsuarioRol.php');
include_once($ROOT . 'modelo/Producto.php');
include_once($ROOT . 'utils/funciones.php');
include_once($ROOT . 'control/ABMUsuario.php');
include_once($ROOT . 'control/ABMRol.php');
include_once($ROOT . 'control/ABMUsuarioRol.php');
include_once($ROOT . 'control/ABMProducto.php');
include_once($ROOT . 'control/Session.php');
?>