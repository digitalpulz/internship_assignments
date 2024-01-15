<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productCode = $_POST['productCode'];
    $productName = $_POST['productName'];
    $dangerLevel = $_POST['dangerLevel'];
    $reorderLevel = $_POST['reorderLevel'];
    $isActive = isset($_POST['isActive']) ? true : false;

    $payload = json_encode([
        'product' => [
            'productCode' => $productCode,
            'productName' => $productName,
            'dangerLevel' => $dangerLevel,
            'reorderLevel' => $reorderLevel,
            'active' => $isActive,
            'user' => 1 // Hardcoded for now
        ]
    ]);

    // cURL setup for adding product
    $ch = curl_init('http://localhost:8092/BASE_API/rest/Product');

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode('his:his12345'),
        'X-tenantID: D0001'
    ]);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        $responseData = json_decode($response, true);
        if (isset($responseData) && is_array($responseData)) {
            echo 'Success: Product added.';
        } else {
            echo 'Error: Failed to add the product.';
        }
    }
    curl_close($ch);
} else {
    echo 'Invalid request method.';
}
?>
