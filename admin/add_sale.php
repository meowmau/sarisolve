<?php
require_once 'inventory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $productId = $_POST['productid'];
    $quantitySold = $_POST['quantity_sold'];
    $totalPrice = $_POST['total_price'];
    $saleDate = $_POST['sale_date'];

    // Create an instance of the Inventory class
    $inventory = new Inventory();

    // Insert the sale into the database
    $saleId = $inventory->addSale($productId, $quantitySold, $totalPrice, $saleDate);

    // Update the product quantity in the database
    $inventory->updateProductQuantity($productId, $quantitySold);

    // Redirect to the sales page or wherever you want to go after adding a sale
    header('Location: salesContent.php');
    exit();
}
?>
