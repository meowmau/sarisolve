<?php
include '../home/connection.php';  // Include the connection file to define $conn

session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the owner's credentials are valid
    $stmt = $conn->prepare("SELECT * FROM owners WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Login successful
        $_SESSION['owner_id'] = $row['id'];
        header("Location: dashboard.php"); // Redirect to the dashboard page
        exit();  // Ensure that no code is executed after the redirect
    } else {
        echo "Invalid credentials";
    }
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

    <form action="login.php" method="post">
        <h1>Login</h1>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>

</body>
</html>
