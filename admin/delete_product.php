<?php
// delete_product.php
require_once 'inventory.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $inventory = new Inventory();
    $inventory->deleteProduct($id);

    header("Location: productContent.php");
    exit();
}
?>
