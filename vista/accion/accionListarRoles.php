<?php
require_once('../../control/ABMRol.php');
require_once('../../modelo/Rol.php');
$objAbmRol = new AbmRol();
$lista = $objAbmRol->buscar(null);
$salida = [];
foreach ($lista as $obj) {
    $salida[] = ['idrol' => $obj->getId_rol(), 'rodescripcion' => $obj->getDescripcion_rol()];
}
echo json_encode($salida);
?>