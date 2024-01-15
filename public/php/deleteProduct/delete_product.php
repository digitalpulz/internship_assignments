<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
    $productId = $_POST['productId'];


    $requestData = json_encode([
        'product' => [
            'user' => 1 // Hardcoded for now
        ]
    ]);

    // cURL setup for deleting the product
    $ch = curl_init("http://localhost:8092/BASE_API/rest/Product/{$productId}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode('his:his12345'),
        'X-tenantID: D0001'
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);

    $response = curl_exec($ch);
    curl_close($ch);

    header("Location: view_products.php");
    exit;
}
?>
