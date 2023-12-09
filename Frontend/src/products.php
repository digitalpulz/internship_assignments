<!DOCTYPE html>
<html>

<head>

    <title>All Products</title>
    <style>
        body {
            background-color: #bcced7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            border-spacing: 0;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            cursor: pointer;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
        }

        .update-button {
            background-color: #3498db;
            color: #fff;
            margin-right: 5px;
        }

        .delete-button {
            background-color: #e74c3c;
            color: #fff;
        }
        
    </style>
</head>

<body>
<button class="btn" onclick="navigateToAddProduct()"  text-align="right">Add Product</button>
    <div class="container">
        <h1>Product List</h1>

        <table>
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Danger Level</th>
                    <th>Reorder Level</th>
                    <th>Active</th>
                    <th>User</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
            </tbody>
        </table>
    </div>


    <script>
        var selectedProductId;

        function getProductList() {
            fetch('http://localhost:8092/BASE_API/rest/Product', {
                    headers: {
                        'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                        'X-tenantID': 'D0001'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update the product table with the latest data
                    var productTableBody = document.getElementById('productTableBody');
                    productTableBody.innerHTML = '';

                    data.forEach(product => {
                        var row = productTableBody.insertRow();
                        row.insertCell(0).innerText = product.productCode;
                        row.insertCell(1).innerText = product.productName;
                        row.insertCell(2).innerText = product.dangerLevel;
                        row.insertCell(3).innerText = product.reorderLevel;
                        row.insertCell(4).innerText = product.active ? 'Yes' : 'No';
                        row.insertCell(5).innerText = product.createdBy;

                        
                        var actionsCell = row.insertCell(6);
                        var updateButton = document.createElement('button');
                        updateButton.innerText = 'Update';
                        updateButton.className = 'btn ';
                        updateButton.onclick = function() {
                           
                            selectedProductId = product.id;
                            showUpdateForm(product);
                        };
                        actionsCell.appendChild(updateButton);

                        var deleteButton = document.createElement('button');
                        deleteButton.innerText = 'Delete';
                        deleteButton.className = 'btn btn-danger btn-sm';
                        deleteButton.onclick = function() {
                            deleteProduct(product.id);
                        };
                        actionsCell.appendChild(deleteButton);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function showUpdateForm(product) {

            window.location.href = `updateProduct.php?id=${product.id}`;
        }

        function deleteProduct(productId, user) {

            var isConfirmed = confirm('Are you sure you want to delete this product?');

            if (isConfirmed) {

                var deleteData = {
                    "product": {
                        "user": user
                    }
                };

                fetch(`http://localhost:8092/BASE_API/rest/Product/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                            'X-tenantID': 'D0001'
                        },
                        body: JSON.stringify(deleteData)
                    })
                    .then(response => {
                        if (response.ok) {
                            getProductList();
                        } else {
                            alert('Failed');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }


        getProductList();

        function navigateToAddProduct() {
            window.location.href = 'addProduct.php';
        }
    </script>
</body>

</html>