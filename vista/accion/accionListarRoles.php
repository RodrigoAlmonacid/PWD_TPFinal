<?php
require_once('../../control/ABMRol.php');
require_once('../../modelo/Rol.php');
$objAbmRol = new AbmRol();
$listaRoles = $objAbmRol->buscar(null); //busco todos los roles
$salida = [];
foreach ($listaRoles as $objRol) {
    $salida[] = ['idrol' => $objRol->getId_rol(), 'rodescripcion' => $objRol->getDescripcion_rol()];
}
echo json_encode($salida);
?>