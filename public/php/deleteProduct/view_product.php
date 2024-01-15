<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>
<h1>Product List</h1>

<?php include '/Users/Nelaka Gunawardhana/Documents/GitHub/internship_assignments/public/php/viewProduct/fetch_product.php';?>

<table id="productsTable">
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Product Code</th>
        <th>Danger Level</th>
        <th>Reorder Level</th>
        <th>Active</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if (!empty($products))
    {
        foreach ($products as $product) {
            echo '<tr>
                            <td>' . htmlspecialchars($product['productName']) . '</td>
                            <td>' . htmlspecialchars($product['productCode']) . '</td>
                            <td>' . htmlspecialchars($product['dangerLevel']) . '</td>
                            <td>' . htmlspecialchars($product['reorderLevel']) . '</td>
                            <td>' . ($product['active'] ? 'Yes' : 'No') . '</td>
                            <td>
                                <form action="view_product.php" method="post">
                                    <input type="hidden" name="productId" value="' . $product['id'] . '">
                                    <button 
                                    style="
                                    padding: 0;
                                    background-color: #fff;
                                    color: #333333" 
                                    type="submit">Delete</button>
                          </form>
                      </td>
                          </tr>';
        }
    } else
    {
        echo '<tr><td colspan="5">No products found.</td></tr>';
    }
    ?>
    </tbody>
</table>

<a href="../../index.html">Back to Home</a>
</body>
</html>
