<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once('../../control/ABMCompra.php');
require_once('../../control/ABMCompraItem.php');
require_once('../../control/ABMCompraEstado.php');
require_once('../../modelo/Usuario.php'); 
require_once('../../control/Session.php');
$objSession=new Session();
$exito=false;//esta variable la uso por si hay errores al agregar
//Obtengo datos del usuario y producto
$idUsuario = $_SESSION['idusuario'];
$idProducto = $_POST['idproducto']; // Viene por POST
$cantidad = $_POST['cantidad'];

$objAbmCompra = new AbmCompra();
$objAbmCompraItem = new AbmCompraItem();
$objAbmCompraEstado = new AbmCompraEstado();
    
//busco compra iniciada para añador a su carrito
$objCompra = $objAbmCompra->obtenerCarritoActivo($idUsuario);
if ($objCompra == null) {
    
    // Si no tiene, creamos la compra
    $objAbmCompra->alta($idUsuario);
    // Obtenemos el objeto que acabamos de crear (podes buscar la última del usuario)
    $compras = $objAbmCompra->buscar(['idusuario' => $idUsuario]);
    $objCompra = end($compras);

    // Y le creamos su estado inicial: 'iniciada' (ID 1)
    $objAbmCompraEstado->alta([
        'idcompra' => $objCompra->getIdcompra(),
        'idcompraestadotipo' => 1,
        'cefechaini' => date('Y-m-d H:i:s')
    ]);
}

// 3. Ahora manejamos el producto en compraitem
$items = $objAbmCompraItem->buscar([
    'idcompra' => $objCompra->getIdcompra(),
    'idproducto' => $idProducto
]);

if (count($items) > 0) {
    // Si ya existe, le sumamos la cantidad
    $objCompraItem = $items[0];
    $exito=$objAbmCompraItem->modificar([
        'idcompraitem' => $objCompraItem->getIdcompraitem(),
        'idproducto' => $idProducto,
        'idcompra' => $objCompra->getIdcompra(),
        'cicantidad' => $objCompraItem->getCantidad() + $cantidad
    ]);
} else {
    // Si es nuevo en el carrito, lo insertamos
    $exito=$objAbmCompraItem->alta([
        'idproducto' => $idProducto,
        'idcompra' => $objCompra->getIdcompra(),
        'cicantidad' => $cantidad
    ]);
}

if ($exito) {
    // Redirigimos al carrito con código de éxito
    header('Location: ../carrito.php?va=1');
} else {
    // Redirigimos al detalle con código de error
    header('Location: ../detalleProducto.php?id='.$idProducto.'&va=0');
}
exit;
?>