<?php 
    require_once('../../control/ABMCompra.php');
    require_once('../../control/ABMCompraItem.php');
    require_once('../../control/ABMCompraEstado.php');
    require_once('../../modelo/Usuario.php'); 
    require_once('../../control/Session.php');
    $idCompra=$_POST['idcompra'];
    $objABMCompraEstado=new ABMCompraEstado();
    $objCompraEstado=$objABMCompraEstado->buscar(['idcompra'=>$idCompra, 'idcompraestadotipo'=>1]);
    $idCompraEstado=$objCompraEstado[0]->getIdCompraEstado();
    $modifica=$objABMCompraEstado->modificar(['idcompraestado'=>$idCompraEstado, 'idcompraestadotipo'=>2]);
    if($modifica){
        header('Location: ../carrito.php');
    }
    else{
        header('Location: ../index.php');
    }
?>