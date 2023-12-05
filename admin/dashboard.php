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
        </ul>
        <div class="main">
            <div class="user-dropdown">
                <img src="#" alt="User Icon" id="user-icon">
                <div class="user-dropdown-content">
                    <a href="../home/login.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main role="main" class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="mt-4">Welcome, [Username]!</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Revenue Today</h3>
                            <p class="card-text" id="revenueToday"></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Sales Today</h3>
                            <p class="card-text" id="salesCount"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Recently Added Products</h3>
                            <ul id="recentlyAddedProducts"></ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Recent Sales</h3>
                            <ul id="recentSales"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- Other HTML code remains unchanged -->

<script>
    <?php
    require_once 'connection.php'; // Include the connection class
    require_once 'inventory.php';
    $inventory = new Inventory();

    // Fetch data from the database
    $revenueToday = $inventory->getRevenueToday();
    $salesCount = $inventory->getSalesTodayCount();
    $recentlyAddedProducts = $inventory->getRecentlyAddedProducts();
    $recentSales = $inventory->getRecentSales();
    ?>

    // Display Revenue Today
    var revenueTodayElement = document.getElementById('revenueToday');
    revenueTodayElement.innerHTML = `
        <p class="card-text"> <?php echo date('F j, Y'); ?>: $<?php echo number_format($inventory->getRevenueToday(), 2); ?></p>
    `;

    // Display Total Sales
    var salesCountElement = document.getElementById('salesCount');
    salesCountElement.innerHTML = `
        <p class="card-text"> <?php echo date('F j, Y'); ?>: <?php echo $inventory->getSalesTodayCount(); ?> sales</p>
    `;

    // Display Recently Added Products
    var recentlyAddedProductsList = document.getElementById('recentlyAddedProducts');
    recentlyAddedProductsList.innerHTML = `
        <ul>
            ${<?php echo json_encode($recentlyAddedProducts); ?>.map(product => `<li>${product.name}</li>`).join('')}
        </ul>
    `;

    // Display Recent Sales
    var recentSalesList = document.getElementById('recentSales');
    recentSalesList.innerHTML = `
        <ul>
            ${<?php echo json_encode($recentSales); ?>.map(sale => `<li>${sale}</li>`).join('')}
        </ul>
    `;
</script>

<!-- Other HTML code remains unchanged -->

</body>
</html>
