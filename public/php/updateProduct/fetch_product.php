<?php
function fetchProducts() {
    // cURL setup for fetching products
    $ch = curl_init('http://localhost:8092/BASE_API/rest/Product');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode('his:his12345'),
        'X-tenantID: D0001'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return [];
    }

    return json_decode($response, true);
}

//fetch product by Id
function fetchProductById($productId) {
    // cURL setup for fetching products
    $ch = curl_init("http://localhost:8092/BASE_API/rest/Product/{$productId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Basic ' . base64_encode('his:his12345'),
        'X-tenantID: D0001'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response === false) {
        return [];
    }

    return json_decode($response, true);
}
?>
