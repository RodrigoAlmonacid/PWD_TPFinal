<?php
require_once __DIR__.'/../../vendor/autoload.php';
require_once '../../control/ABMCompraItem.php'; 

use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;

// Establecer cabecera JSON desde el inicio
header('Content-Type: application/json');

try {
    // 1. Configuración del SDK  
    SDK::setAccessToken("token");

    $idcompra = $_POST['idcompra'] ?? null;
    if (!$idcompra) {
        throw new Exception("ID de compra no recibido.");
    }

    // 2. Obtener items
    $objAbmItems = new ABMCompraItem();
    $listaItems = $objAbmItems->buscar(['idcompra' => $idcompra]);

    if (empty($listaItems)) {
        throw new Exception("La compra no tiene items.");
    }
 
    // 3. Configurar la Preferencia
    $preference = new Preference();
    $items_para_mp = [];

    foreach ($listaItems as $item) {
        $nuevoItem = new Item();
        $nuevoItem->title = (string)$item->getObjProducto()->getNomProducto();
        $nuevoItem->quantity = (int)$item->getCantidad();
        $nuevoItem->unit_price = (float)$item->getObjProducto()->getProPrecio();
        $nuevoItem->currency_id = "ARS";
        $items_para_mp[] = $nuevoItem;
    }

    $preference->items = $items_para_mp;
    $preference->external_reference = $idcompra;
    // 4. Configurar URLs de retorno ANTES de guardar
    $preference->back_urls = [
        "success" => "http://localhost/PWD_TPFinal/vista/accion/pagoExitoso.php",
        "failure" => "http://localhost/PWD_TPFinal/vista/misCompras.php",
        "pending" => "http://localhost/PWD_TPFinal/vista/misCompras.php"
    ];
    //$preference->auto_return = "approved";

    // 5. Guardar la preferencia una SOLA vez
    if (!$preference->save()) {
        $errorMsg = $preference->error->message ?? "Error desconocido al guardar en MP";
        throw new Exception($errorMsg);
    }

    // 6. Enviar respuesta única
    echo json_encode(['url' => $preference->sandbox_init_point]);
    exit; // Asegura que nada más se imprima

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'errorMsg' => "Error: " . $e->getMessage(),
        'url' => null
    ]);
    exit;
}