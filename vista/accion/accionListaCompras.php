<?php
// resolver el error del archivo de configuración que no trae los ABM
//require_once(__DIR__.'/../../utils/incluyeABM.php');
//agrego el __DIR__ para resolver errores de ruteo
require_once(__DIR__.'/../../control/ABMCompra.php');
require_once(__DIR__.'/../../control/ABMCompraEstado.php');
require_once(__DIR__.'/../../modelo/CompraEstado.php');
require_once(__DIR__.'/../../utils/tipoMetodo.php');

$datos = getSubmittedData();
//Instancio los abm
$objAbmCompra = new ABMCompra();
$objAbmCompraEstado=new ABMCompraEstado();

// busco las compras según estado
$compraPendiente=$objAbmCompraEstado->buscarCompraEstado("Pendiente");
$compraAprobada=$objAbmCompraEstado->buscarCompraEstado("Aprobada");
$compraPagada=$objAbmCompraEstado->buscarCompraEstado("Pagada");
$compraCancelada=$objAbmCompraEstado->buscarCompraEstado("Cancelada");
$arregloCompras=[];
array_push($arregloCompras, $compraAprobada);//me queda en $arregloCompras[0] todas las aprobadas
array_push($arregloCompras, $compraPendiente); //me queda en $arregloCompras[1] todas las pendiente
array_push($arregloCompras, $compraPagada);//me queda en $arregloCompras[2] todas las pagadas
array_push($arregloCompras, $compraCancelada);//me queda en $arregloCompras[3] todas las canceladas
$usuario=$datos['usuario'];
if($usuario=="cliente"){
    $idUsuario=$datos['idusuario'];
}
//Preparar el formato JSON que el datagrid de EasyUI espera
$datosParaGrid = array();

//El datagrid espera una lista de arrays asociativos, no de objetos.
foreach($arregloCompras as $compraTipo) {
    if(count($compraTipo)>0){
        foreach ($compraTipo as $objCompraEstado) {
            $objCompra=$objCompraEstado->getObjCompra();
            $objUsuario=$objCompra->getObjUsuario();
            $objCompraEstadoTipo=$objCompraEstado->getobjCompraEstadoTipo();
            if($usuario=="cliente" && $objUsuario->getId_usuario()==$idUsuario){
                $datosParaGrid[] = array(
                    'idcompra' => $objCompra->getIdCompra(),
                    'cefechaini' => $objCompraEstado->getFechaIni(),
                    'cefechafin'=> $objCompraEstado->getFechaFin(),
                    'estado'=> $objCompraEstadoTipo->getCetDescripcion()
                );
            }
            else if($usuario=="admin" && $objCompraEstadoTipo->getCetDescripcion()!="Aprobada"){
                $datosParaGrid[] = array(
                    'idcompra' => $objCompra->getIdCompra(),
                    'usuario' => $objUsuario->getEmail_usuario(),
                    'cefechaini' => $objCompraEstado->getFechaIni(),
                    'cefechafin'=> $objCompraEstado->getFechaFin(),
                    'estado'=> $objCompraEstadoTipo->getCetDescripcion()
                );
            }
            
        }
    }
}

// Estructura final para EasyUI: {total: N, rows: [...]}
//mando la cantidad de lineas en 'total' y el contenido en 'rows'
$respuesta = array(
    'total' => count($datosParaGrid),
    'rows' => $datosParaGrid
);

//Envio la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($respuesta);
?>