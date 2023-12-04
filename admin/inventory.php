<?php
// Inventory.php
require_once 'connection.php';
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
            $products[] = new Product($row['productid'], $row['name'], $row['price'], $row['quantity']);
        }

        return $products;
    }

    public function getProductById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE productid = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        $product = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product = new Product($row['productid'], $row['name'], $row['price'], $row['quantity']);
        }

        $stmt->close();

        return $product;
    }

    public function editProduct($id, $name, $price, $quantity) {
        $sql = "UPDATE products SET name=?, price=?, quantity=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $name, $price, $quantity, $id);
        $stmt->execute();
        $stmt->close();
    }


    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE productid=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>
    