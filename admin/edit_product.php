<?php
// edit_product.php
require_once 'inventory.php';

// Decode JSON data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['productid'];
    $name = $data['name'];
    $price = $data['price'];
    $quantity = $data['quantity'];

    $inventory = new Inventory();
    $success = $inventory->editProduct($id, $name, $price, $quantity);

    // Return JSON response
    echo json_encode(['success' => $success]);
    exit();
} else {
    // Return JSON response for error
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
    exit();
}
?>
