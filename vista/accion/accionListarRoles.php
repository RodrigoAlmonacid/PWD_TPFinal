<?php
require_once(__DIR__.'/../../control/ABMRol.php');
require_once(__DIR__.'/../../modelo/Rol.php');
//instacio el abm para traer los roles
$objAbmRol = new AbmRol();
$listaRoles = $objAbmRol->buscar(null); //busco todos los roles
$salida = []; //array vacío
foreach ($listaRoles as $objRol) {
    $salida[] = ['idrol' => $objRol->getId_rol(), 'rodescripcion' => $objRol->getDescripcion_rol()];
}
//mando la respuesta en formato json
echo json_encode($salida);
?>