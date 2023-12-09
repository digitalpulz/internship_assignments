<!DOCTYPE html>
<html lang="en">

<head>

    <title>Update Product</title>
    <style>
        body {
            background-color: #bcced7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
            margin-top: 50px;
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
            text-align: left;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        select {
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
        <form id="updateForm">
            <h2>Update Product</h2>
            <div class="form-group">
                <label >Product Code:</label>
                <input type="text" id="productCode" name="productCode" required>
            </div>
            <div class="form-group">
                <label >Product Name:</label>
                <input type="text" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label >Danger Level:</label>
                <input type="number" id="dangerLevel" name="dangerLevel" required>
            </div>
            <div class="form-group">
                <label >Reorder Level:</label>
                <input type="number" id="reorderLevel" name="reorderLevel" required>
            </div>
            <div class="form-group">
                <label>Active:</label>
                <select id="active" name="active" required>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
            </div>
            <div class="form-group">
                <label >User:</label>
                <input type="number" id="user" name="user" required>
            </div>
            <button type="button" onclick="submitUpdate()">Update</button>
        </form>
    </div>


    <script>
        var selectedProductId;

        function submitUpdate() {

            var updatedCode = document.getElementById('productCode').value;
            var updatedName = document.getElementById('productName').value;
            var updatedDangerLevel = document.getElementById('dangerLevel').value;
            var updatedReorderLevel = document.getElementById('reorderLevel').value;
            var updatedActive = document.getElementById('active').value === 'true';
            var updatedUser = document.getElementById('user').value;


            var updateData = {
                "product": {
                    "productCode": updatedCode,
                    "productName": updatedName,
                    "dangerLevel": updatedDangerLevel,
                    "reorderLevel": updatedReorderLevel,
                    "active": updatedActive,
                    "user": updatedUser
                }
            };

            fetch(`http://localhost:8092/BASE_API/rest/Product/${selectedProductId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                        'X-tenantID': 'D0001'
                    },
                    body: JSON.stringify(updateData)
                })
                .then(response => {
                    if (response.ok) {
                        alert('Product updated successfully!');
 
                        window.location.href = 'products.php';
                    } else {
                        alert('Failed to update product. Please try again.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        function getProductForUpdate() {
            
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');

            if (productId) {

                fetch(`http://localhost:8092/BASE_API/rest/Product/${productId}`, {
                        headers: {
                            'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                            'X-tenantID': 'D0001'
                        }
                    })
                    .then(response => response.json())
                    .then(product => {
 
                        document.getElementById('productCode').value = product.productCode;
                        document.getElementById('productName').value = product.productName;
                        document.getElementById('dangerLevel').value = product.dangerLevel;
                        document.getElementById('reorderLevel').value = product.reorderLevel;
                        document.getElementById('active').value = product.active.toString();
                        document.getElementById('user').value = product.user;

  
                        selectedProductId = product.id;
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                console.error('Product ID not found');
            }
        }

        getProductForUpdate();
    </script>
</body>

</html>