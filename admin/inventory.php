<?
// Inventory.php
require_once 'product.php';

class Inventory extends SARISOLVE {
    public function addProduct(Product $product) {
        $sql = "INSERT INTO products (name, price, quantity) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $product->name, $product->price, $product->quantity);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllProducts() {
        $result = $this->conn->query("SELECT * FROM products");
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = new Product($row['name'], $row['price'], $row['quantity']);
        }

        return $products;
    }
}

?>