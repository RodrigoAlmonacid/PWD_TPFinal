<?php 
    require_once(__DIR__.'/../../control/ABMCompra.php');
    require_once(__DIR__.'/../../control/ABMCompraItem.php');
    require_once(__DIR__.'/../../control/ABMCompraEstado.php');
    require_once(__DIR__.'/../../modelo/Usuario.php'); 
    require_once(__DIR__.'/../../control/Session.php');
    require_once(__DIR__.'/../../utils/tipoMetodo.php');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $datos=getSubmittedData();
    
    $idCompra=$datos['idcompra'];
    $objABMCompraEstado=new ABMCompraEstado();
    $fecha=date('Y-m-d H:i:s');
    //El nuevo estado es Pendiente (id=2) ya que queda lista para aprobación por el administrador
    $modifica=$objABMCompraEstado->cambiarEstado($idCompra, 2);
    if($modifica){
        header('Location: ../carrito.php');
    }
    else{
        header('Location: ../index.php');
    }
?>