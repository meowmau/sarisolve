<?php
// Inventory.php
require_once 'connection.php';
require_once 'product.php';
// Set the server time zone
date_default_timezone_set('Asia/Manila'); // Change to your server's time zone


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
        $sql = "UPDATE products SET name=?, price=?, quantity=? WHERE productid=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdii", $name, $price, $quantity, $id);
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





    public function addSale($productId, $quantitySold, $totalPrice, $saleDate) {
        $stmt = $this->conn->prepare("INSERT INTO sales (productid, quantitysold, totalamount, saledate) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $productId, $quantitySold, $totalPrice, $saleDate);
        $stmt->execute();
    
        $saleId = $stmt->insert_id;
    
        $stmt->close();
    
        return $saleId;
    }
    
    public function updateProductQuantity($productId, $quantitySold) {
        $stmt = $this->conn->prepare("UPDATE products SET quantity = quantity - ? WHERE productid = ?");
        $stmt->bind_param("ii", $quantitySold, $productId);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllSales() {
        $sql = "SELECT sales.*, products.name as product_name FROM sales
                JOIN products ON sales.productid = products.productid
                ORDER BY sales.saledate DESC";
        $result = $this->conn->query($sql);
        
        $allSales = [];

        while ($row = $result->fetch_assoc()) {
            $allSales[] = $row;
        }

        return $allSales;
    }

    public function getSaleById($saleId) {
        $stmt = $this->conn->prepare("SELECT sales.*, products.name as product_name FROM sales
                                     JOIN products ON sales.productid = products.productid
                                     WHERE saleid = ?");
        $stmt->bind_param("i", $saleId);
        $stmt->execute();

        $result = $stmt->get_result();
        $sale = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sale = $row;
        }

        $stmt->close();

        return $sale;
    }

    public function editSale($saleId, $productId, $quantitySold, $saleDate, $totalAmount) {
        $sql = "UPDATE sales SET productid=?, quantitysold=?, saledate=?, totalamount=? WHERE saleid=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("issdi", $productId, $quantitySold, $saleDate, $totalAmount, $saleId);
        $stmt->execute();
        $stmt->close();
    }

    public function deleteSale($saleId) {
        // Fetch the productid and quantitysold from the sales table
        $stmt = $this->conn->prepare("SELECT productid, quantitysold FROM sales WHERE saleid = ?");
        $stmt->bind_param("i", $saleId);
        $stmt->execute();
        $stmt->bind_result($productId, $quantitySold);
        
        // Check if the sale exists
        if ($stmt->fetch()) {
            $stmt->close();
    
            // Update the quantity in the products table
            $updateProductsQuery = "UPDATE products SET quantity = quantity + $quantitySold WHERE productid = $productId";
            $this->conn->query($updateProductsQuery);
    
            // Delete the sale from the sales table
            $stmt = $this->conn->prepare("DELETE FROM sales WHERE saleid = ?");
            $stmt->bind_param("i", $saleId);
            $stmt->execute();
            $stmt->close();
    
            return "success";
        } else {
            $stmt->close();
            return "Sale not found";
        }
    }
    
    

    
    public function returnQuantityToProduct($productId, $saleId) {
        // Fetch the quantity sold for the specified sale
        $quantitySold = $this->getQuantitySoldForSale($saleId);

        // Update the product quantity in products table
        $updateProductQuery = "UPDATE products SET quantity = quantity + ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($updateProductQuery);
        $stmt->bind_param("ii", $quantitySold, $productId);
        $stmt->execute();
        $stmt->close();
    }

    // Helper function to get the quantity sold for a specific sale
    private function getQuantitySoldForSale($saleId) {
        $stmt = $this->conn->prepare("SELECT quantitysold FROM sales WHERE saleid = ?");
        $stmt->bind_param("i", $saleId);
        $stmt->execute();
        $stmt->bind_result($quantitySold);
        $stmt->fetch();
        $stmt->close();

        return $quantitySold;
    }







// Inside the Inventory class

public function getSalesByDate($date)
{
    // Ensure that $date is a valid date format (you might want to add more validation)
    $formattedDate = date('Y-m-d', strtotime($date));

    // Prepare and execute an SQL query to fetch sales data for the specified date
    $sql = "SELECT sales.*, products.name as product_name 
            FROM sales
            JOIN products ON sales.productid = products.productid
            WHERE saledate = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $formattedDate);
    $stmt->execute();

    // Fetch the results into an associative array
    $result = $stmt->get_result();
    $salesData = [];

    while ($row = $result->fetch_assoc()) {
        $salesData[] = $row;
    }

    $stmt->close();

    return $salesData;
}



        // getRevenueToday function
        public function getRevenueToday() {
            $today = date('Y-m-d');
            $sql = "SELECT SUM(totalamount) as revenue FROM sales WHERE DATE(saledate) = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $today);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $revenue = $row['revenue'];

            $stmt->close();

            return $revenue;
        }

        // getSalesTodayCount function
        public function getSalesTodayCount() {
            $today = date('Y-m-d');
            $sql = "SELECT COUNT(*) AS sales_count FROM sales WHERE DATE(saledate) = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $today);
            $stmt->execute();

            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $salesCount = $row['sales_count'];

            $stmt->close();

            return $salesCount;
        }

    

    public function getRecentlyAddedProducts($limit = 5) {
        $sql = "SELECT * FROM products ORDER BY productid DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        $recentlyAddedProducts = [];

        while ($row = $result->fetch_assoc()) {
            $product = new Product($row['productid'], $row['name'], $row['price'], $row['quantity']);
            $recentlyAddedProducts[] = $product;
        }

        $stmt->close();

        return $recentlyAddedProducts;
    }

    public function getRecentSales($limit = 5) {
        $sql = "SELECT sales.*, products.name as product_name FROM sales
                JOIN products ON sales.productid = products.productid
                ORDER BY sales.saledate DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $recentSales = [];
    
        while ($row = $result->fetch_assoc()) {
            $recentSales[] = "Product Name: " . $row['product_name'] . ", Quantity Sold: " . $row['quantitysold'] . ", Total Amount: $" . $row['totalamount'];
        }
    
        $stmt->close();
    
        return $recentSales;
    }
}
?>
    