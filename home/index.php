<?php
// login.php

// Include the connection.php file
require_once('../admin/connection.php');

class Login extends SARISOLVE {
    public function __construct() {
        parent::__construct();
    }

    public function loginUser($username, $password) {
        // Validate that both username and password are provided
        if (empty($username) || empty($password)) {
            echo "Please enter both username and password.";
            return;
        }

        // Sanitize user input to prevent SQL injection
        $username = $this->conn->real_escape_string($username);

        // Retrieve hashed password from the database
        $query = "SELECT password FROM users WHERE username = '$username'";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            // Verify the password using password_verify
            if (password_verify($password, $hashedPassword)) {
                // Login successful
                // Redirect to dashboard.php
                header("Location: ../admin/dashboard.php");
                exit(); // Ensure that no more code is executed after the redirection
            } else {
                // Invalid password
                echo "Invalid password";
            }
        } else {
            // User not found
            echo "User not found";
        }
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create an instance of the Login class
    $login = new Login();

    // Get the user input from the form
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Call the loginUser method to validate the login
    $login->loginUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>

    <form action="" method="post"> <!-- Update the form action attribute -->
        <h1>Login</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>

</body>
</html>
