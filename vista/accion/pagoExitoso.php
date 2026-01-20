<?php
require_once('../../control/ABMCompraEstado.php');
$idcompra = $_GET['external_reference'];

$objABMCompraEstado=new ABMCompraEstado();
$modifica=$objABMCompraEstado->cambiarEstado($idCompra, 5);
// Aquí llamas a tu lógica para pasar la compra a estado "Pagada" (ID 5 por ejemplo)
if($modifica){
    echo "<h1>¡Gracias por tu compra! El pago fue acreditado.</h1>";
    echo "<a href='../misCompras.php'>Volver a mis compras</a>";
}

?>