<?php
// Incluir el ABM. El ABMUsuario ya se encarga de incluir Usuario.php
// IMPORTANTE: Ajusta estas rutas si tu estructura de carpetas es diferente.
require_once('../../control/ABMCompra.php');
require_once('../../control/ABMCompraEstado.php');
require_once('../../modelo/CompraEstado.php');

//Instancio los abm
$objAbmCompra = new ABMCompra();
$objAbmCompraEstado=new ABMCompraEstado();

// busco las compras según estado
$compraPendiente=$objAbmCompraEstado->buscarCompraEstado("Pendiente");
$compraPagada=$objAbmCompraEstado->buscarCompraEstado("Pagada");
$compraCancelada=$objAbmCompraEstado->buscarCompraEstado("Cancelada");
$arregloCompras=[];
array_push($arregloCompras, $compraPendiente); //me queda en $arregloCompras[0] todas las pendiente
array_push($arregloCompras, $compraPagada);//me queda en $arregloCompras[1] todas las pagadas
array_push($arregloCompras, $compraCancelada);//me queda en $arregloCompras[2] todas las canceladas
$usuario=$_GET['usuario'];
if($usuario=="cliente"){
    $idUsuario=$_GET['idusuario'];
}
// 3. Preparar el formato JSON que el datagrid de EasyUI espera
$datosParaGrid = array();

// El datagrid espera una lista de arrays asociativos, no de objetos.
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
                    'estado'=> $objCompraEstadoTipo->getCetDescripcion()
                );
            }
            else if($usuario=="admin"){
                $datosParaGrid[] = array(
                    'idcompra' => $objCompra->getIdCompra(),
                    'usuario' => $objUsuario->getEmail_usuario(),
                    'cefechaini' => $objCompraEstado->getFechaIni(),
                    'estado'=> $objCompraEstadoTipo->getCetDescripcion()
                );
            }
            
        }
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