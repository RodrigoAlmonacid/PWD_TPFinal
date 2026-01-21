
<?php
require_once('../../control/ABMCompraEstado.php');

// Recuperamos el idcompra que mandamos en el return_url
$idcompra = $_GET['idcompra'] ?? null;
// PayPal también manda un 'token' que es su ID de orden
$orderID_paypal = $_GET['token'] ?? null;

if ($idcompra) {
    $objABMCompraEstado = new ABMCompraEstado();
    
    // Cambiamos el estado a 2 (Aceptada/Pagada) según tu lógica de estados
    // OJO: Verifica si tu método es cambiarEstado($idcompra, $idestado)
    $modifica = $objABMCompraEstado->cambiarEstado($idcompra, 5); 

// Redirigimos inmediatamente agregando un parámetro de éxito
header("Location: ../misCompras.php?pago=exito&id=" . $idcompra);
exit();
}
/*
    if ($modifica) {
        echo "<h1>¡Gracias por tu compra!</h1>";
        echo "<p>El pago de la compra #$idcompra fue acreditado con PayPal.</p>";
        echo "<p>Referencia PayPal: $orderID_paypal</p>";
        echo "<a href='../misCompras.php'>Volver a mis compras</a>";
    } else {
        echo "Error al actualizar el estado de la compra.";
    }
} else {
    echo "No se recibió el ID de la compra.";
} */
?>

