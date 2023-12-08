<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" href="../CSS/sales.css">
</head>
<body>
<header>
<a href="dashboard.php" class="logo"> <img src="../pictures/logo.png" alt="Logo"> <span>SariSolve</span></a>

    <ul class="navbar">
      <li><a href="../admin/productContent.php" class="products">Products</a></li>
      <li><a href="../admin/salesContent.php" class="sales">Sales</a></li>
    </ul>

    <div class="main">
        <div class="user-dropdown">
            <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
            <div class="user-dropdown-content">
            <a href="../home/login.php">Logout</a>
            </div>
        </div>
    </header>

    <h1 class="text-center">Sales</h1>

    <main role="main" class="content">
        <!-- Container for Filter and Add Sale button -->
        <div class="filter-container">
        <!-- Add a filter for sales by date using calendar -->
        <div class="filter-group">
            <label for="filter_date">Filter by Date:</label>
            <input type="date" name="filter_date" id="filter_date">
            <button onclick="applyDateFilter()" class="btn btn-info">Apply Filter</button>
        </div>

        <!-- Button to trigger modal -->
        <button type="button" class="btn btn-primary add-sale-btn" data-toggle="modal" data-target="#salesModal">
            Add Sale
        </button>
    </div>

<!-- Modal -->
<div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">Add Sale</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <!-- Your existing form goes here -->
                    <form action="add_sale.php" method="post">
                        <div>
                            <label for="productid">Product:</label>
                            <!-- Check if $productData is set and is an array before using it in the foreach loop -->
                            <select name="productid" id="productid" required>
                                <?php
                                require_once 'inventory.php';

                                // Create an instance of the Inventory class
                                $inventory = new Inventory();

                                // Fetch product data from the backend
                                $productData = $inventory->getAllProducts();

                                if (!empty($productData)) {
                                    echo "<option value='' disabled selected>Select a product</option>";
                                    foreach ($productData as $product) {
                                        // Access the object's properties using methods
                                        echo "<option value='{$product->id}'>{$product->name}</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled>No products available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="quantity_sold">Quantity Sold:</label>
                            <input type="number" name="quantity_sold" id="quantity_sold" required>
                        </div>

                        <div>
                            <label for="price">Price per Unit:</label>
                            <input type="text" name="price" id="price" readonly>
                        </div>

                        <div>
                            <label for="quantity">Available Stock:</label>
                            <input type="text" name="quantity" id="quantity" readonly>
                        </div>

                        <div>
                            <label for="total_price">Total Price:</label>
                            <input type="text" name="total_price" id="total_price" readonly>
                        </div>

                        <div>
                            <label for="sale_date">Sale Date:</label>
                            <input type="date" name="sale_date" required>
                        </div>

                        <div>
                            <button type="submit"class="btn btn-success">Add Sale</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>



            <!-- Your existing table to display sales data -->
            <table class="table" id="productTable">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Product Name</th>
                        <th>Sale Date</th>
                        <th>Quantity Sold</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once 'inventory.php';
                    
                        // Create an instance of the Inventory class
                        $inventory = new Inventory();
                        // Get all sales data
                        $allSales = $inventory->getAllSales();
                        // Loop through the sales data and display it in the table
                        foreach ($allSales as $sale) {
                            echo "<tr>";
                            echo "<td>" . $sale['saleid'] . "</td>";
                            echo "<td>" . $sale['product_name'] . "</td>";
                            echo "<td>" . $sale['saledate'] . "</td>";
                            echo "<td>" . $sale['quantitysold'] . "</td>";
                            echo "<td>" . $sale['totalamount'] . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
    </main>
<script>
    // Add an event listener to the date filter input
    document.getElementById('filter_date').addEventListener('change', function () {
        applyDateFilter();
    });

    // Function to apply the date filter and fetch sales data
    function applyDateFilter() {
        var dateFilter = document.getElementById('filter_date').value;

        // Make an AJAX request to get sales data based on the selected date
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_sales_by_date.php?date=' + dateFilter, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Update the table with filtered sales data
                document.getElementById('productTable').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Get references to relevant form elements
        var productSelect = document.getElementById('productid');
        var quantitySoldInput = document.getElementById('quantity_sold');
        var priceInput = document.getElementById('price');
        var totalPriceInput = document.getElementById('total_price');
        var quantityInput = document.getElementById('quantity'); // Added this line

        // Add an event listener to the product select dropdown
        productSelect.addEventListener('change', function () {
            // Fetch the selected product's price, quantity, and available stock from the backend using AJAX
            var productId = productSelect.value;

            // Make an AJAX request to get product data
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_product_info.php?productid=' + productId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var productData = JSON.parse(xhr.responseText);

                    // Update the price and quantity input fields
                    priceInput.value = productData.price;
                    quantityInput.value = productData.quantity;

                    // Calculate and update the total price based on quantity sold
                    updateTotalPrice();
                }
            };
            xhr.send();
        });

        // Add an event listener to the quantity input
        quantitySoldInput.addEventListener('input', function () {
            // Calculate and update the total price based on quantity sold
            updateTotalPrice();
        });

        // Function to calculate and update the total price
        function updateTotalPrice() {
            var price = parseFloat(priceInput.value);
            var quantitySold = parseFloat(quantitySoldInput.value);

            // Check if both price and quantity are valid numbers
            if (!isNaN(price) && !isNaN(quantitySold)) {
                // Calculate total price
                var totalPrice = price * quantitySold;

                // Update the total price input field
                totalPriceInput.value = totalPrice.toFixed(2); // Adjust the decimal places as needed
            } else {
                // If either price or quantity is not a valid number, set total price to empty
                totalPriceInput.value = '';
            }
        }
    });

    // Function to show SweetAlert confirmation before submitting the form
    function confirmAddSale() {
        // Use SweetAlert to show a confirmation dialog
        Swal.fire({
            title: 'Confirm Sale',
            text: 'Are you sure you want to add this sale?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, add it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks "Yes," submit the form
                document.getElementById('addSaleForm').submit();
            }
        });
    }
</script>

</body>
</html>