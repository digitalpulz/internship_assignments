<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #bcced7; 
        }
    </style>
</head>
<body class="container mt-5">

    <h1 class="mb-4 text-center text-primary">Product Management System</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title text-primary">Add Product</h4>
                    <p class="card-text">Add a new product to the system.</p>
                    <a href="add_product.php" class="btn btn-success btn-block">Go to Add Product</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light">
                <div class="card-body">
                    <h4 class="card-title text-primary">Product List</h4>
                    <p class="card-text">View, update, and delete existing products.</p>
                    <a href="product_list.php" class="btn btn-info btn-block">Go to Product List</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
