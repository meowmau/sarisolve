<?php
// edit_product.php
require_once 'inventory.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $id = $_POST['productid']; // Corrected from 'id' to 'productid'
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Instantiate the Inventory class
    $inventory = new Inventory();

    // Call the editProduct method to update the product
    $inventory->editProduct($id, $name, $price, $quantity);

    // Redirect to the product content page or any other desired page after editing
    header('Location: productContent.php');
    exit();
} else {
    // Invalid request method
    echo 'Invalid request method';
}
?>
