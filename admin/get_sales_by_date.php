<?php
// get_sales_by_date.php

require_once 'inventory.php';

// Create an instance of the Inventory class
$inventory = new Inventory();

// Get the date filter from the AJAX request
$dateFilter = $_GET['date'];

// Get sales data based on the selected date
$filteredSales = $inventory->getSalesByDate($dateFilter);

// Generate HTML table rows for the filtered sales data
foreach ($filteredSales as $sale) {
    echo "<tr>";
    echo "<td>" . $sale['saleid'] . "</td>";
    echo "<td>" . $sale['product_name'] . "</td>"; // Access product_name directly
    echo "<td>" . $sale['saledate'] . "</td>";
    echo "<td>" . $sale['quantitysold'] . "</td>";
    echo "<td>" . $sale['totalamount'] . "</td>";
    echo "</tr>";
}
?>
