<!DOCTYPE html>
<html>
<head>
    <title>Add New Product</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>
<h1>Add New Product</h1>

<form id="addProductForm" action="submit_product.php" method="post">

    <div>
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>
    </div>

    <div>
        <label for="productCode">Product Code:</label>
        <input type="text" id="productCode" name="productCode" required>
    </div>

    <div>
        <label for="dangerLevel">Danger Level:</label>
        <input type="number" id="dangerLevel" name="dangerLevel" required>
    </div>

    <div>
        <label for="reorderLevel">Reorder Level:</label>
        <input type="number" id="reorderLevel" name="reorderLevel" required>
    </div>

    <div>
        <label for="isActive">Active:</label>
        <input type="checkbox" id="isActive" name="isActive">
    </div>

    <div>
        <button type="submit">Add Product</button>
    </div>

</form>

<a href="../../index.html">Back to Home</a>

</body>
</html>
