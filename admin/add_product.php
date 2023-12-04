<?php
// add_product.php
require_once 'inventory.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    $product = new Product($id, $name, $price, $quantity);

    $inventory = new Inventory();
    $inventory->addProduct($product);

    header("Location: productContent.php");
    exit();
}
?>
