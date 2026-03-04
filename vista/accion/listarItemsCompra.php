<?php
require_once(__DIR__.'/../../control/ABMCompra.php');
require_once(__DIR__.'/../../control/ABMCompraItem.php');
require_once(__DIR__.'/../../modelo/CompraItem.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos=getSubmittedData();
//Instancio los abm
$objAbmCompra = new ABMCompra();
$objABMCompraItem=new ABMCompraItem();
//obtengo el idcompra
$idCompra=$datos['idcompra'];
$compraItem=$objABMCompraItem->buscar(['idcompra' => $idCompra]); //Aca ya logré obtener los items 
//Preparar el formato JSON que el datagrid de EasyUI espera
$datosParaGrid = array();

// El datagrid espera una lista de arrays asociativos, no de objetos.

if(count($compraItem)>0){
    foreach ($compraItem as $objCompraItem) {
        $objProducto=$objCompraItem->getobjProducto();
        $datosParaGrid[] = array(
            'producto' => $objProducto->getNomProducto(),
            'cantidad' => $objCompraItem->getCantidad(),
            'stock'=> $objProducto->getStockProducto()
        );
    }
}


//Estructura final para EasyUI: {total: N, rows: [...]}
$respuesta = array(
    'total' => count($datosParaGrid),
    'rows' => $datosParaGrid
);

//Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>