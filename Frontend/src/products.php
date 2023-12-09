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
    <button class="btn" onclick="navigateToAddProduct()" text-align="right">Add Product</button>
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

        function getProducts() {
            fetch('http://localhost:8092/BASE_API/rest/Product', {
                    headers: {
                        'Authorization': 'Basic aGlzOmhpczEyMzQ1',
                        'X-tenantID': 'D0001'
                    }
                })
                .then(response => response.json())
                .then(data => {

                    var productTableBody = document.getElementById('productTableBody');
                    productTableBody.innerHTML = '';

                    data.forEach(product => {
                        var row = productTableBody.insertRow();
                        ['productCode', 'productName', 'dangerLevel', 'reorderLevel', 'active', 'createdBy'].forEach((field, index) => {
                            var cell = row.insertCell(index);
                            if (field === 'active') {
                                cell.innerText = product[field] ? 'Yes' : 'No';
                            } else {
                                cell.innerText = product[field];
                            }
                        });

                        var actionsCell = row.insertCell(6);
                        var updateButton = createButton('Update', function() {
                            selectedProductId = product.id;
                            UpdateForm(product);
                        });
                        actionsCell.appendChild(updateButton);

                        var deleteButton = createButton('Delete', function() {
                            deleteProduct(product.id);
                        }, );
                        actionsCell.appendChild(deleteButton);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Helper function to create a button with specified text, click handler, and classes
        function createButton(text, clickHandler, ...classes) {
            var button = document.createElement('button');
            button.innerText = text;
            button.className = 'btn ' + classes.join(' ');
            button.onclick = clickHandler;
            return button;
        }


        function UpdateForm(product) {

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
                            alert('Product Deleted...');

                            getProducts();
                        } else {
                            alert('Failed');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }


        getProducts();

        function navigateToAddProduct() {
            window.location.href = 'addProduct.php';
        }
    </script>
</body>

</html>