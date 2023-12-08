<?php
// delete_sale.php
require_once 'inventory.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $inventory = new Inventory();
    $inventory->deleteSale($id);

    header("Location: salesContent.php");
    exit();
}
?>