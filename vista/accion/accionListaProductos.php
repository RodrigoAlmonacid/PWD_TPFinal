<?php
// Incluir el ABM. El ABMUsuario ya se encarga de incluir Usuario.php
// IMPORTANTE: Ajusta estas rutas si tu estructura de carpetas es diferente.
require_once('../../control/ABMProducto.php');
require_once('../../modelo/Producto.php');

// 1. Instanciar el ABM
$abmProducto = new ABMProducto();

// 2. Llamar al método de listado de la clase ABM
// El método 'buscar' de ABMUsuario, si se le pasa NULL, devuelve todos los usuarios.
// El resultado es un ARREGLO de OBJETOS Usuario.
$arregloProductos = $abmProducto->buscar(null); 

// 3. Preparar el formato JSON que el datagrid de EasyUI espera
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

// Estructura final para EasyUI: {total: N, rows: [...]}
$respuesta = array(
    'total' => count($datosParaGrid),
    'rows' => $datosParaGrid
);

// 4. Enviar la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>