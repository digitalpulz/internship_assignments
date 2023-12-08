<?php


$apiUrl = "http://localhost:8092/BASE_API/rest/Product";
$username = "his";
$password = "his12345";
$authHeader = base64_encode("$username:$password");

$curlOptions = array(
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        "Authorization: Basic $authHeader",
        "X-tenantID: D0001",
        "Content-Type: application/json"
    )
);

$dbHost = "localhost";
$dbName = "dp_base_test";
$dbUser = "root";
$dbPass = "";

// DB
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//GET
function makeGetRequest($url, $authHeader, $curlOptions) {
    $curl = curl_init();
    curl_setopt_array($curl, $curlOptions);
    $response = curl_exec($curl);
    if ($response === false) {
        echo "Error making API request: " . curl_error($curl);
    }
    curl_close($curl);
    return $response;
}

// function makeRequest($url, $method, $data, $authHeader, $curlOptions) {
//     $curl = curl_init();
//     curl_setopt_array($curl, $curlOptions);
//     curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//     $response = curl_exec($curl);
//     curl_close($curl);
//     return $response;
// }

?>
