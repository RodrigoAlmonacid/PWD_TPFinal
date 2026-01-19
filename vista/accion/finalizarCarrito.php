<?php 
    require_once('../../control/ABMCompra.php');
    require_once('../../control/ABMCompraItem.php');
    require_once('../../control/ABMCompraEstado.php');
    require_once('../../modelo/Usuario.php'); 
    require_once('../../control/Session.php');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $idCompra=$_POST['idcompra'];
    $objABMCompraEstado=new ABMCompraEstado();
    $fecha=date('Y-m-d H:i:s');
    $objCompraEstado=$objABMCompraEstado->buscar(['idcompra'=>$idCompra, 'idcompraestadotipo'=>1]);
    $idCompraEstado=$objCompraEstado[0]->getIdCompraEstado();
    $modifica=$objABMCompraEstado->modificar(['idcompraestado'=>$idCompraEstado, 'cefechaini'=>$fecha, 'idcompraestadotipo'=>2]);
    if($modifica){
        header('Location: ../carrito.php');
    }
    else{
        header('Location: ../index.php');
    }
?>