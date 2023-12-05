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
                        <h5 class="card-title">Revenue Today</h5>
                        <p class="card-text" id="revenueToday"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Capital</h5>
                        <p class="card-text" id="totalCapital"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recently Added Products</h5>
                        <ul id="recentlyAddedProducts"></ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Recent Sales</h5>
                        <ul id="recentSales"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    <?php
        $inventory = new Inventory();

        $revenueToday = $inventory->getRevenueToday();
        $totalCapital = $inventory->getTotalCapital();
        $recentlyAddedProducts = $inventory->getRecentlyAddedProducts();
        $recentSales = $inventory->getRecentSales();
    ?>

    console.log('Revenue Today:', "<?php echo $revenueToday; ?>");
    console.log('Total Capital:', "<?php echo $totalCapital; ?>");
    console.log('Recently Added Products:', <?php echo json_encode($recentlyAddedProducts); ?>);
    console.log('Recent Sales:', <?php echo json_encode($recentSales); ?>);

    document.getElementById('revenueToday').innerText = "<?php echo $revenueToday; ?>";
    document.getElementById('totalCapital').innerText = "<?php echo $totalCapital; ?>";

    var recentlyAddedProducts = <?php echo json_encode($recentlyAddedProducts); ?>;
    var recentSales = <?php echo json_encode($recentSales); ?>;

    console.log('recentlyAddedProducts:', recentlyAddedProducts);
    console.log('recentSales:', recentSales);

    var recentlyAddedProductsList = document.getElementById('recentlyAddedProducts');
    recentlyAddedProducts.forEach(function(product) {
        var li = document.createElement('li');
        li.innerText = product;
        recentlyAddedProductsList.appendChild(li);
    });

    var recentSalesList = document.getElementById('recentSales');
    recentSales.forEach(function(sale) {
        var li = document.createElement('li');
        li.innerText = sale;
        recentSalesList.appendChild(li);
    });

</script>
</body>
</html>
