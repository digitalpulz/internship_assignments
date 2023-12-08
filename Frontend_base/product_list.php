<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #bcced7; 
        }
    </style>
</head>
<body class="container mt-5">

<h1>Product List</h1>

<table class="table">
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
        <!-- Product rows will be dynamically added here -->
    </tbody>
</table>

<!-- Form for updating a product -->
<form id="updateForm" style="display: none;">
    <h2>Update Product</h2>
    <div class="form-group">
        <label for="productCode">Product Code:</label>
        <input type="text" class="form-control" id="productCode" required>
    </div>
    <div class="form-group">
        <label for="productName">Product Name:</label>
        <input type="text" class="form-control" id="productName" required>
    </div>
    <div class="form-group">
        <label for="dangerLevel">Danger Level:</label>
        <input type="number" class="form-control" id="dangerLevel" required>
    </div>
    <div class="form-group">
        <label for="reorderLevel">Reorder Level:</label>
        <input type="number" class="form-control" id="reorderLevel" required>
    </div>
    <div class="form-group">
        <label for="active">Active:</label>
        <select class="form-control" id="active" required>
            <option value="true">Yes</option>
            <option value="false">No</option>
        </select>
    </div>
    <div class="form-group">
        <label for="user">User:</label>
        <input type="number" class="form-control" id="user" required>
    </div>
    <button type="button" class="btn btn-primary" onclick="submitUpdate()">Update</button>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    var selectedProductId; // Store the ID of the selected product for update

    // Function to get the product list ========================================================== (GET)
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

                // Add buttons for update and delete actions =====================
                var actionsCell = row.insertCell(6);
                var updateButton = document.createElement('button');
                updateButton.innerText = 'Update';
                updateButton.className = 'btn btn-primary btn-sm mr-1';
                updateButton.onclick = function () {
                    // Set the selected product ID and show the update form ======
                    selectedProductId = product.id;
                    showUpdateForm(product);
                };
                actionsCell.appendChild(updateButton);

                var deleteButton = document.createElement('button');
                deleteButton.innerText = 'Delete';
                deleteButton.className = 'btn btn-danger btn-sm';
                deleteButton.onclick = function () {
                    deleteProduct(product.id);
                };
                actionsCell.appendChild(deleteButton);
            });
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to show the update form with product data ============================================== (PUT)
    function showUpdateForm(product) {
        // Populate the form fields with the selected product data
        document.getElementById('productCode').value = product.productCode;
        document.getElementById('productName').value = product.productName;
        document.getElementById('dangerLevel').value = product.dangerLevel;
        document.getElementById('reorderLevel').value = product.reorderLevel;
        document.getElementById('active').value = product.active.toString();
        document.getElementById('user').value = product.user;

        // Display the update form
        document.getElementById('updateForm').style.display = 'block';
    }

    // Function to submit the update request
    function submitUpdate() {
        // Get the updated values from the form
        var updatedCode = document.getElementById('productCode').value;
        var updatedName = document.getElementById('productName').value;
        var updatedDangerLevel = document.getElementById('dangerLevel').value;
        var updatedReorderLevel = document.getElementById('reorderLevel').value;
        var updatedActive = document.getElementById('active').checked;
        var updatedUser = document.getElementById('user').value;

        // Prepare the update payload
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
                // Update the product list after a successful update
                getProductList();
                // Hide the update form
                document.getElementById('updateForm').style.display = 'none';
            } else {
                alert('Failed to update product. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to delete a product ============================================================== (DELETE)
    function deleteProduct(productId, user) {
        // Prepare the delete payload
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
                alert('Product deleted successfully!');
                // Update the product list after delete
                getProductList();
            } else {
                alert('Failed to delete product. Please try again.');
            }
        })
        .catch(error => console.error('Error:', error));
    }


    // Initial load of the product list
    getProductList();
</script>

</body>
</html>
