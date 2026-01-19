<?php
// Incluir el ABM. El ABMUsuario ya se encarga de incluir Usuario.php
// IMPORTANTE: Ajusta estas rutas si tu estructura de carpetas es diferente.
require_once('../../control/ABMCompra.php');
require_once('../../control/ABMCompraItem.php');
require_once('../../modelo/CompraItem.php');

//Instancio los abm
$objAbmCompra = new ABMCompra();
$objABMCompraItem=new ABMCompraItem();
//obtengo el idcompra
$idCompra=$_GET['idcompra'];
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


// Estructura final para EasyUI: {total: N, rows: [...]}
$respuesta = array(
    'total' => count($datosParaGrid),
    'rows' => $datosParaGrid
);

// 4. Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>