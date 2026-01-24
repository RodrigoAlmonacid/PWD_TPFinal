<?php
require_once "../../control/ABMCompraItem.php";
require_once "../../control/ABMCompraEstado.php";

$idItem = $_POST['idcompraitem'];
$idCompra = $_POST['idcompra'];

$objABMItem = new ABMCompraItem();

// 1. Borramos el item
if ($objABMItem->baja(['idcompraitem' => $idItem])) {
    
    // 2. Verificamos si quedan más items en esa compra
    $restantes = $objABMItem->buscar(['idcompra' => $idCompra]);
    
    if (count($restantes) == 0) {
        // 3. Si no queda nada, pasamos la compra a "Cancelada"
        $objABMEstado = new ABMCompraEstado();
        // Usamos tu función mágica cambiarEstado
        $objABMEstado->cambiarEstado($idCompra, 4); // Suponiendo que 4 = Cancelada
    }
    
    echo json_encode(['exito' => true]);
}