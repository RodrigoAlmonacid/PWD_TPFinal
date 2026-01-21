<?php
require __DIR__.'/../../vendor/autoload.php';
require_once '../../control/ABMCompraItem.php'; 
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

$idcompra = $_POST['idcompra'] ?? null;

try {
    if (!$idcompra) throw new Exception("ID de compra no recibido.");

    $objAbmItems = new ABMCompraItem();
    $listaItems = $objAbmItems->buscar(['idcompra' => $idcompra]);
    if (empty($listaItems)) throw new Exception("La compra no tiene items.");

    $total = 0;
    foreach ($listaItems as $item) {
        $total += ($item->getCantidad() * $item->getObjProducto()->getProPrecio());
    }

    // --- CONFIGURACIÓN PAYPAL ---
    $clientId = "...";
    $clientSecret = "...";
    $environment = new SandboxEnvironment($clientId, $clientSecret);
    $client = new PayPalHttpClient($environment);

    $request = new OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = [
        "intent" => "CAPTURE",
        "purchase_units" => [[
            "amount" => [
                "value" => number_format($total, 2, '.', ''), // Formato 10.00
                "currency_code" => "USD" // IMPORTANTE: PayPal Sandbox no acepta ARS
            ]
        ]],
        "application_context" => [
            // Pasamos el idcompra en la URL para recuperarlo en pagoExitoso.php
            "cancel_url" => "http://localhost/PWD_TPFinal/vista/misCompras.php",
            "return_url" => "http://localhost/PWD_TPFinal/vista/accion/pagoExitoso.php?idcompra=".$idcompra
        ]
    ];

    $response = $client->execute($request);

    // --- EL TRUCO PARA TU JS ---
    // Buscamos el link que tiene rel="approve"
    $approveUrl = "";
    foreach ($response->result->links as $link) {
        if ($link->rel == "approve") {
            $approveUrl = $link->href;
        }
    }

    // Devolvemos la URL para que tu window.location.href funcione
    echo json_encode(['url' => $approveUrl]);

} catch (Exception $ex) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $ex->getMessage()]);
}
?>