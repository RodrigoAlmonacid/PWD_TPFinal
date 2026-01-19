<?php 
    require_once('../../control/ABMCompraEstado.php');
    $idCompra=$_POST['idcompra'];
    $idCompraEstadoTipo=$_POST['idcompraestadotipo'];
    $objABMCompraEstado=new ABMCompraEstado();
    $respuesta = false;
    $errorMsg = "";
    //El nuevo estado viene por post
    $modifica=$objABMCompraEstado->cambiarEstado($idCompra, $idCompraEstadoTipo);
    /*
    $objCompraEstado=$objABMCompraEstado->buscar(['idcompra'=>$idCompra, 'idcompraestadotipo'=>1]);
    $idCompraEstado=$objCompraEstado[0]->getIdCompraEstado();
    $modifica=$objABMCompraEstado->modificar(['idcompraestado'=>$idCompraEstado, 'cefechaini'=>$fecha, 'idcompraestadotipo'=>2]);
    */
    if($modifica){
        $respuesta=true;
    }
    else{
        $errorMsg="Error al intentar cambiar el estado de la compra.";
    }
    // Devolvemos la respuesta en formato JSON para el JS
    echo json_encode(['respuesta' => $respuesta, 'errorMsg' => $errorMsg]);
?>