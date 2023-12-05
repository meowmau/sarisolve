<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="../CSS/dashboard.css">
</head>

<body>
    <header>
        <a href="dashboard.php" class="logo"><i class="bx bx-scan"></i><span>SariSolve</span></a>

        <ul class="navbar">
            <li><a href="../admin/productContent.php" class="products">Products</a></li>
            <li><a href="../admin/salesContent.php" class="sales">Sales</a></li>
            <li><a href="../admin/reportContent.php" class="report">Report</a></li>
            <li><a href="../admin/userContent.php" class="user">User</a></li>
        </ul>

        <div class="main">
            <div class="user-dropdown">
                <img src="#" alt="User Icon" id="user-icon">
                <div class="user-dropdown-content">
                    <a href="../home/login.php">Logout</a>
                </div>
            </div>
    </header>

    <main role="main" class="content">
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="add_product.php" method="post">
                        <label for="name">Product Name:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" required>

                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" required>

                        <button type="submit" class="btn btn-success">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_product.php" method="post">
                        <!-- Hidden input for product ID -->
                        <input type="hidden" id="editProductId" name="productid">

                        <label for="editName">Product Name:</label>
                        <input type="text" id="editName" name="name" required>

                        <label for="editPrice">Price:</label>
                        <input type="number" id="editPrice" name="price" required>

                        <label for="editQuantity">Quantity:</label>
                        <input type="number" id="editQuantity" name="quantity" required>

                        <!-- Use onclick to trigger the editProduct function -->
                        <button type="submit" class="btn btn-info">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to open the Add Product Modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Add Product</button>

    <!-- Your existing HTML for the product table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'inventory.php';

            $inventory = new Inventory();
            $products = $inventory->getAllProducts();

            foreach ($products as $product) {
                echo "<tr>";
                echo "<td>{$product->id}</td>";
                echo "<td>{$product->name}</td>";
                echo "<td>{$product->price}</td>";
                echo "<td>{$product->quantity}</td>";
                echo "<td>
                        <button class='btn btn-info' data-toggle='modal' data-target='#editProductModal' onclick='editProduct({$product->id}, \"{$product->name}\", {$product->price}, {$product->quantity})'>Edit</button>
                        <a href='delete_product.php?id={$product->id}' class='btn btn-danger'>Delete</a>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</main>
    <!-- JavaScript libraries and Bootstrap JS links go here -->

    <!-- Your custom script goes here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Your custom script goes here -->
    <script>
        function editProduct(id, name, price, quantity) {
            // Set the values of the input fields in the modal
            document.getElementById('editProductId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editPrice').value = price;
            document.getElementById('editQuantity').value = quantity;

            // Show the "Edit Product" modal
            $('#editProductModal').modal('show');
        }
    </script></body>
</html>
