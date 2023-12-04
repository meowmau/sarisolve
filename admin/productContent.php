<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>

<body>
    <header>
        <a href="../admin/productContent.php" class="logo"><i class="bx bx-scan"></i><span>SariSolve</span></a>

        <ul class="navbar">
            <li><a href="../admin/productContent.php" class="products">Products</a></li>
            <li><a href="../admin/categoryContent.php" class="category">Category</a></li>
            <li><a href="../admin/reportContent.php" class="report">Report</a></li>
            <li><a href="../admin/userContent.php" class="user">User</a></li>
        </ul>

        <div class="main">
            <div class="user-dropdown">
                <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
                <div class="user-dropdown-content">
                    <a href="../home/login.php">Logout</a>
                </div>
            </div>
    </header>

    <main role="main" class="content">
        <!-- Your main content goes here -->
        <form action="add_product.php" method="post">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <button type="submit">Add Product</button>
        </form>

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
                    echo "<td><input type='text' value='{$product->name}' id='name_{$product->id}'></td>";
                    echo "<td><input type='number' value='{$product->price}' id='price_{$product->id}'></td>";
                    echo "<td><input type='number' value='{$product->quantity}' id='quantity_{$product->id}'></td>";
                    echo "<td>
                        <button class='btn btn-info' onclick='editProduct({$product->id})'>Edit</button>
                        <a href='delete_product.php?id={$product->id}' class='btn btn-danger'>Delete</a>
                      </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ... your HTML and other scripts ... -->
    <script>
    function editProduct(productId) {
        // Get values from input fields
        var name = document.getElementById('name_' + productId).value;
        var price = document.getElementById('price_' + productId).value;
        var quantity = document.getElementById('quantity_' + productId).value;

        // Send AJAX request to edit_product.php
        fetch('edit_product.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Use JSON format
            },
            body: JSON.stringify({
                id: productId,
                name: name,
                price: price,
                quantity: quantity,
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Display SweetAlert for success
                Swal.fire({
                    title: "Success!",
                    text: "Product updated successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "productContent.php";
                });
            } else {
                // Display SweetAlert for error
                Swal.fire({
                    title: "Error!",
                    text: data.error || "Failed to update product. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

    
</body>

</html>
