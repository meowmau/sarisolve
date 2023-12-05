<?php
// Include your database connection code (adjust as needed)
require_once 'inventory.php';

// Check if a product ID is provided in the AJAX request
if (isset($_GET['productid'])) {
    $productId = $_GET['productid'];

    // Create an instance of the Inventory class
    $inventory = new Inventory();

    // Get product data by ID
    $product = $inventory->getProductById($productId);

    // Check if the product was found
    if ($product) {
        // Return JSON response with product data
        echo json_encode([
            'price' => $product->price,
            'quantity' => $product->quantity
        ]);
    } else {
        // Return an error response if the product was not found
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    // Return an error response if no product ID is provided
    echo json_encode(['error' => 'Product ID not provided']);
}
?>
