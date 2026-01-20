<?php

// 1. Pon aquí tu token ACTUAL (el que te da problemas)
$tu_token_actual = "APP_USR-6938518976544621-011921-d69f270e40207cda73b87d46b42dbd26-3146019998";

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.mercadopago.com/users/test_user',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "site_id": "MLA", 
    "description": "Vendedor de Prueba TP Final"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $tu_token_actual
  ),
));

$response = curl_exec($curl);
curl_close($curl);

$json = json_decode($response, true);

echo "<h1>¡Usuario de Prueba Creado!</h1>";
echo "<p>Usa este Access Token en tu archivo pagarCompra.php:</p>";
echo "<h3>" . ($json['nickname'] ?? 'Error') . "</h3>";

// Aquí está el oro:
if (isset($json['site_status']) && $json['site_status'] == 'active') {
    echo "NO COPIES ESTO (ID): " . $json['id'] . "<br>";
}

// Dependiendo de la versión de la API, el token puede venir en distintos lugares
// Buscamos el token de prueba específico
echo "<div style='background:#efefef; padding:20px; border:2px dashed red;'>";
echo "<strong>COPIA ESTE TOKEN (ACCESS TOKEN):</strong><br><br>";
// A veces MP no devuelve el token directamente en la creación del test user en versiones nuevas,
// pero intentemos ver qué devuelve para capturarlo.
print_r($json); 
echo "</div>";
?>