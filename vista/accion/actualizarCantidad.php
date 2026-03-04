<?php
require_once(__DIR__.'../../control/ABMCompraItem.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos=getSubmittedData();

$idItem = $datos['idcompraitem'];
$delta = (int)$datos['delta'];

$objABM = new ABMCompraItem();
$lista = $objABM->buscar(['idcompraitem' => $idItem]);

if (count($lista) > 0) {
    $objItem = $lista[0];
    $nuevaCant = $objItem->getCantidad() + $delta;

    if ($nuevaCant > 0) {
        $objItem->setCantidad($nuevaCant);
        if ($objItem->modificar()) {
            echo json_encode(['exito' => true]);
        }
    } else {
        echo json_encode(['exito' => false, 'msg' => 'La cantidad mínima es 1. Usa la X para eliminar.']);
    }
}