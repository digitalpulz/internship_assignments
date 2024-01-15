<?php
function fetchProducts() {
    // cURL setup
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8092/BASE_API/rest/Product');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Basic ' . base64_encode('his:his12345'),
        'X-tenantID: D0001'
    ));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return [];
    } else {
        return json_decode($response, true);
    }

    curl_close($ch);
}

$products = fetchProducts();
?>
