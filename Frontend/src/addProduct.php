<!DOCTYPE html>
<html lang="en">
<head>

    <title>Add Product</title>
    
    <style>
        body {
            background-color: #bcced7; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input, checkbox {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            background: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }
    </style>

</head>

<body>

    <div class="container">
        <h1>Add Product</h1>

        <form id="addProduct">
            <div class="form-group">
                <label for="productCode">Product Code:</label>
                <input type="text" id="productCode" name="productCode" required>
            </div>

            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>

            <div class="form-group">
                <label for="dangerLevel">Danger Level:</label>
                <input type="number" id="dangerLevel" name="dangerLevel" required>
            </div>

            <div class="form-group">
                <label for="reorderLevel">Reorder Level:</label>
                <input type="number" id="reorderLevel" name="reorderLevel" required>
            </div>

            <div class="form-group">
                <label for="active">Active:</label>
                <input type="checkbox" id="active" name="active">
            </div>

            <div class="form-group">
                <label for="user">User:</label>
                <input type="number" id="user" name="user" required>
            </div>

            <button type="button" onclick="addProduct()">Add Product</button>
        </form>
    </div>
<script> 
function addProduct() {
        if (document.getElementById("addProduct").checkValidity()) {

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

            if (data) {
                alert('Product added.........');
                window.location.href = `products.php`;
                getProductList();
            } else {
                alert('Failed to add...........');
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Fields cannot be empty.......');
    }
}

</script>
    
</body>
</html>
