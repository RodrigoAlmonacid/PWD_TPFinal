<?php
require __DIR__.'/../../vendor/autoload.php';
require_once __DIR__.'/../../control/ABMCompraEstado.php';
require_once __DIR__.'/../../control/ABMCompraItem.php';
require_once __DIR__.'/../../control/ABMCompra.php';
require_once __DIR__.'/../../utils/funciones.php';
$date=date('d-m-Y H:i:s');
//uso lo mismo que en paypal
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

//Recupero los datos de la URL
$idcompra = $_GET['idcompra'] ?? null;
$orderId = $_GET['token'] ?? null; // Este es el ID que genera PayPal

if (!$idcompra || !$orderId) {
    die("Error: Faltan datos para procesar el pago.");
}

try {
    //CONFIGURACIÓN PAYPAL (Igual que el archivo anterior)
    $clientId = "AdLIqQgSljenn6-r7RclIFA1IqzDEuK_g1ihPf2r4nogl0wg5tR_jPefzC94qKz-BiCm5gVSttsfm3a0";
    $clientSecret = "EDMtAjKpZqKhg4JqtRt9YlYdyzf5DxzzEp8NYsHvmtK1LVEafp8Dq86KbHsicdTthU-o5_k7llAp3shH";
    $environment = new SandboxEnvironment($clientId, $clientSecret);
    $client = new PayPalHttpClient($environment);

    //CAPTURAR EL PAGO
    //Aquí es donde PayPal realmente saca el dinero de la cuenta del cliente
    $request = new OrdersCaptureRequest($orderId);
    $request->prefer('return=representation');
    $response = $client->execute($request);

    //VERIFICAR EL ESTADO DEL PAGO
    // Si el estado es 'COMPLETED', el dinero ya es tuyo
    if ($response->result->status == 'COMPLETED') {
        
        $objABMCompraEstado = new ABMCompraEstado();
        
        //Cambiamos el estado a 5
        $modifica = $objABMCompraEstado->cambiarEstado($idcompra, 5); 

        
        $objAbmItems = new ABMCompraItem();
        $listaItems = $objAbmItems->buscar(['idcompra' => $idcompra]);
        $objAbmCompra = new ABMCompra();
        $objCompra = $objAbmCompra->buscar(['idcompra' => $idcompra])[0];
        $objUsuario = $objCompra->getObjUsuario();
        if (empty($listaItems)) throw new Exception("La compra no tiene items.");

            $total = 0;
            $compra=[];
            foreach ($listaItems as $item) {
                $objProducto=$item->getObjProducto();
                $prodCompra['nombre']=$objProducto->getNomProducto();
                $prodCompra['cantidad']=$item->getCantidad();
                $prodCompra['precio']=$objProducto->getProPrecio();
                $total += ($prodCompra['cantidad'] * $prodCompra['precio']);
                array_push($compra, $prodCompra);
            }
        $pdf=preparaPdf($compra, $objUsuario->getNom_usuario(), $date);
        $cuerpo['pdf']=$pdf;
        $cuerpo['cuerpo']="Hola! Tu pago se acreditó correctamente. Te adjuntamos el resumen.";
        $mail=enviarMail($objUsuario->getEmail_usuario(), 'Factura - Ponete las Pilas', $cuerpo);

        if ($modifica) {
            header("Location: ../misCompras.php?pago=exito&id=" . $idcompra);
            exit();
        } else {
            echo "El pago fue exitoso pero hubo un error al actualizar la base de datos.";
        }
        
    } else {
        // El pago no se completó
        header("Location: ../misCompras.php?pago=error&detalle=no_completado");
        exit();
    }

} catch (Exception $ex) {
    // Error de comunicación con PayPal
    header("Location: ../misCompras.php?pago=error&detalle=api_error");
    exit();
}
