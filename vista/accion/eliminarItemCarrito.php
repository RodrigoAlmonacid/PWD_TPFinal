<?php
require_once (__DIR__.'/../../control/ABMCompraItem.php');
require_once (__DIR__.'/../../control/ABMCompraEstado.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos=getSubmittedData();
$idItem = $datos['idcompraitem'];
$idCompra = $datos['idcompra'];

$objABMItem = new ABMCompraItem();

//Borramos el item
if ($objABMItem->baja(['idcompraitem' => $idItem])) {
    
    //Verificamos si quedan más items en esa compra
    $restantes = $objABMItem->buscar(['idcompra' => $idCompra]);
    
    if (count($restantes) == 0) {
        //Si no queda nada, pasamos la compra a "Cancelada"
        $objABMEstado = new ABMCompraEstado();
        //Usamos tu función cambiarEstado
        $objABMEstado->cambiarEstado($idCompra, 4); //4 = Cancelada
    }
    
    echo json_encode(['exito' => true]);
}