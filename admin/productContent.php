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
  </header>
    

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
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

    <div class="product-list">
        <?php
        require_once 'Inventory.php';

        $inventory = new Inventory();
        $products = $inventory->getAllProducts();

        foreach ($products as $product) {
            echo "<div class='product'>";
            $product->display();
            echo "</div>";
        }
        ?>
    </div>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAlert(title, message) {
            Swal.fire({
                title: title,
                text: message,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>
</html>
