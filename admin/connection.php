<?php
// DbConnection.php
class SARISOLVE {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'inventory';

    protected $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}

?>
