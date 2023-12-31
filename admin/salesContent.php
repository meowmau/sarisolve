<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link rel="stylesheet" href="../CSS/sales.css">
</head>
<body>
<header>
    <a href="dashboard.php" class="logo">
        <img src="../pictures/logo.png" alt="Logo">
        <span>SariSolve</span>
    </a>

    <ul class="navbar">
        <li><a href="../admin/productContent.php" class="products">Products</a></li>
        <li><a href="../admin/salesContent.php" class="sales">Sales</a></li>
    </ul>

    <div class="main">
        <div class="user-dropdown">
            <img src="../pictures/admin.png" alt="User Icon" id="user-icon">
            <div class="user-dropdown-content">
                <a href="../home/index.php">Logout</a>
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
        <div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel"
             aria-hidden="true">
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
                        <form id="addSaleForm" action="add_sale.php" method="post">
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
                                <button type="submit" class="btn btn-success">Add Sale</button>
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
                    <th>Actions</th>
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
                    echo "<td>
                            <a href='#' class='btn btn-danger delete-sale-btn'
                            data-saleid='{$sale['saleid']}' data-productid='{$sale['productid']}'>Delete</a>
                        </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </main>
    <!-- Your custom script goes here -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Add an event listener to the date filter input
    document.getElementById('filter_date').addEventListener('change', function () {
        applyDateFilter();
    });

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

                    // Check if quantity is greater than 0
                    if (productData.quantity <= 0) {
                        Swal.fire({
                            title: 'Out of Stock',
                            text: 'The selected product is out of stock.',
                            icon: 'warning',
                        });
                        // Clear quantity sold and total price fields
                        quantitySoldInput.value = '';
                        totalPriceInput.value = '';
                    } else {
                        // Calculate and update the total price based on quantity sold
                        updateTotalPrice();
                    }
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

    // Add SweetAlert before form submission
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('salesModal').querySelector('form').addEventListener('submit', function (event) {
            // Check if the selected product is out of stock before form submission
            var quantityAvailable = parseFloat(document.getElementById('quantity').value);

            if (quantityAvailable <= 0) {
                event.preventDefault();

                Swal.fire({
                    title: 'Out of Stock',
                    text: 'The selected product is out of stock. Please choose another product.',
                    icon: 'warning',
                });
            } else {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You are about to add a new sale!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, add it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with form submission
                        event.target.submit();
                    } else {
                        // Cancel the action
                        Swal.fire('Cancelled', 'Your action has been cancelled.', 'info');
                    }
                });
            }
        });

        const deleteButtons = document.querySelectorAll('.delete-sale-btn');
        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var saleId = button.getAttribute('data-saleid'); // Using 'data-saleid' attribute
                        var productId = button.getAttribute('data-productid');

                        // Make an AJAX request to delete sale
                        var deleteSaleXHR = new XMLHttpRequest();
                        deleteSaleXHR.open('GET', 'delete_sale.php?id=' + saleId, true); // Using 'id' as the parameter name
                        deleteSaleXHR.onreadystatechange = function () {
                            if (deleteSaleXHR.readyState == 4 && deleteSaleXHR.status == 200) {
                                // After deleting the sale, reload the page
                                location.reload();
                            }
                        };
                        deleteSaleXHR.send();
                    } else {
                        // Cancel the action
                        Swal.fire('Cancelled', 'Your action has been cancelled.', 'info');
                    }
                });
            });
        });
    });
</script>

</body>
</html>
