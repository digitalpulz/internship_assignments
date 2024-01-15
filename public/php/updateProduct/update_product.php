<?php
include '../updateProduct/fetch_product.php';

$products = fetchProducts();
$message = '';

$selectedProduct = null;

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['productId']) && $_POST['productId'] != '') {
        // Fetch selected product details for form pre-population
        $selectedProductId = $_POST['productId'];
        $selectedProduct = fetchProductById($selectedProductId);
    }

    $productCode = isset($_POST['productCode']) ? $_POST['productCode'] : null;
    $productName = isset($_POST['productName']) ? $_POST['productName'] : null;

    if ($productCode && $productName) {
        $updatedProduct = json_encode([
            'product' => [
                'productCode' => $productCode,
                'productName' => $productName,
                'dangerLevel' => $_POST['dangerLevel'],
                'reorderLevel' => $_POST['reorderLevel'],
                'active' => isset($_POST['isActive']) ? true : false,
                'user' =>1 // Hardcoded for now
            ]
        ]);

        // cURL setup for updating product
        $ch = curl_init("http://localhost:8092/BASE_API/rest/Product/{$selectedProductId}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode('his:his12345'),
            'X-tenantID: D0001'
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $updatedProduct);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $message = 'Product updated successfully.';
        } else {
            $message = 'Failed to update the product.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
</head>
<body>
<h1>Update Product</h1>

<?php if (!empty($message)) { echo "<p>$message</p>"; } ?>

<form id="updateProductForm" method="post" action="update_product.php">
    <div>
        <label for="productSelect">Select Product:</label>
        <select id="productSelect" name="productId" onchange="this.form.submit()">
            <option value="">Select a Product</option>
            <?php
            foreach ($products as $product) {
                $isSelected = $selectedProduct && $product['id'] == $selectedProduct['id'];
                echo '<option value="' . $product['id'] . '"' . ($isSelected ? ' selected' : '') . '>' . $product['productName'] . '</option>';
            } ?>

        </select>
    </div>

    <?php if ($selectedProduct): ?>
    <input type="hidden" id="updateProductId" name="productId" value="<?php echo $selectedProduct['id']; ?>">

    <div>
        <label for="updateProductCode">Product Code:</label>
        <input type="text" id="updateProductCode" name="productCode" value="<?php echo htmlspecialchars($selectedProduct['productCode']); ?>" required>
    </div>
    <div>
        <label for="updateProductName">Product Name:</label>
        <input type="text" id="updateProductName" name="productName" value="<?php echo htmlspecialchars($selectedProduct['productName']); ?>" required>
    </div>
        <div>
            <label for="updateDangerLevel">Danger Level:</label>
            <input type="number" id="updateDangerLevel" name="dangerLevel" value="<?php echo htmlspecialchars($selectedProduct['dangerLevel']); ?>" required>
        </div>
        <div>
            <label for="updateReorderLevel">Reorder Level:</label>
            <input type="number" id="updateReorderLevel" name="reorderLevel" value="<?php echo htmlspecialchars($selectedProduct['reorderLevel']); ?>" required>
        </div>
        <div>
            <label for="updateIsActive">Active:</label>
            <input type="checkbox" id="updateIsActive" name="isActive" <?php echo $selectedProduct['active'] ? 'checked' : ''; ?>>
        </div>
        <div>
            <button type="submit">Update Product</button>
        </div>
    <?php endif; ?>

</form>
<a href="/internship_assignments/public/index.html">Back to Home</a>

<script src="/public/js/update_product.js"></script>
</body>
</html>
