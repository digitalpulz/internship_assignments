<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #bcced7; 
        }
    </style>
</head>


<body class="container mt-5">

<h1>Add Product</h1>
<br>
<table>
<form id="addProductForm">
    
    <div class="group_one">
        <tr><td><label for="productCode">Product Code:</label></td>
        <td><input type="text" class="form-control" id="productCode" name="productCode" required></tr></td>
    </div>

    <div class="group_two">
        <tr><td><label for="productName">Product Name:</label></td>
        <td><input type="text" class="form-control" id="productName" name="productName" required></tr></td>
    </div>

    <div class="group_three">
        <tr><td><label for="dangerLevel">Danger Level:</label></td>
        <td><input type="number" class="form-control" id="dangerLevel" name="dangerLevel" required></tr></td>
    </div>

    <div class="group_four">
        <tr><td><label for="reorderLevel">Reorder Level:</label></td>
        <td><input type="number" class="form-control" id="reorderLevel" name="reorderLevel" required></tr></td>
    </div>

    <div class="group_five">
        <tr><td><label for="active">Active:</label></td>
        <td><input type="checkbox" id="active" name="active"></tr></td>
    </div>

    <div class="group_six">
        <tr><td><label for="user">User:</label></td>
        <td><input type="number" class="form-control" id="user" name="user" required></tr></td>
    </div>
    </table>
    <br>
    <button type="button" class="btn btn-primary" onclick="addProduct()">Add Product</button><br>

</form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    // Function to add a new product
    function addProduct() {
        if (document.getElementById("addProductForm").checkValidity()) {
        // Get form data
        var productData = {
            product: {
                productCode: document.getElementById("productCode").value,
                productName: document.getElementById("productName").value,
                dangerLevel: parseInt(document.getElementById("dangerLevel").value),
                reorderLevel: parseInt(document.getElementById("reorderLevel").value),
                active: document.getElementById("active").checked,
                user: parseInt(document.getElementById("user").value)
            }
        };

        // Make AJAX request to Spring Boot backend
        fetch('http://localhost:8092/BASE_API/rest/Product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                'X-tenantID': 'D0001'
            },
            body: JSON.stringify(productData)
        })
        .then(response => response.json())
        .then(data => {
            // After successful addition, refresh the product list
            if (data) {
                alert('Product added successfully!');
                getProductList();
            } else {
                alert('Failed to add product. Please check the inputs.');
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please fill all the details correctly.');
    }
}
</script>

</body>
</html>