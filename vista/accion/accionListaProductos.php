<?php
// resolver el error del archivo de configuración que no trae los ABM
require_once('../../control/ABMProducto.php');
require_once('../../modelo/Producto.php');

//Instancio el ABM
$abmProducto = new ABMProducto();

// El método 'buscar' si se le pasa NULL, devuelve todos los productos, un arreglo de objetos
$arregloProductos = $abmProducto->buscar(null); 

//Preparo el formato JSON que el datagrid de EasyUI espera
$datosParaGrid = array();

// El datagrid espera una lista de arrays asociativos, no de objetos.
if (count($arregloProductos) > 0) {
    foreach ($arregloProductos as $objProducto) {
        $estado = $objProducto->getProDeshabilitado();
        if($estado==null){
            $estado="Habilitado";
        }
        else{
            $estado="Deshabilitado";
        }
        $datosParaGrid[] = array(
            'idproducto' => $objProducto->getIdProducto(),
            'pronombre' => $objProducto->getNomProducto(),
            'prodetalle' => $objProducto->getDetallesProd(),
            'procantstock'=> $objProducto->getStockProducto(),
            'proprecio'=> $objProducto->getProPrecio(),
            'proimagen'=>$objProducto->getImgProd(),
            'prodeshabilitado' => $estado
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