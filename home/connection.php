<?php

class SARISOLVE
{
    public static function connect()
    {
        try {
            $con = new PDO('mysql:host=localhost;dbname=sarisolve', 'root', '');
            return $con;
        } catch (PDOException $error1) {
            echo 'Something went wrong with your connection!' . $error1->getMessage();
        } catch (Exception $error2) {
            echo 'Generic error!' . $error2->getMessage();
        }
    }

    // Function to add a product
    public static function addProduct($name, $quantity, $price)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("INSERT INTO products (name, quantity, price) VALUES (?, ?, ?)");
        $result = $stmt->execute([$name, $quantity, $price]);
        return $result;
    }

    // Function to update a product
    public static function updateProduct($id, $name, $quantity, $price)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("UPDATE products SET name=?, quantity=?, price=? WHERE id=?");
        $result = $stmt->execute([$name, $quantity, $price, $id]);
        return $result;
    }

    // Function to delete a product
    public static function deleteProduct($id)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $result = $stmt->execute([$id]);
        return $result;
    }

    // Function to fetch all products
    public static function getAllProducts()
    {
        $conn = self::connect();
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = array();
        if ($result->rowCount() > 0) {
            $products = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        return $products;
    }
}
?>
