<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "digitalstay";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['admin_username'];
    $pass = $_POST['password'];

    // Hash the entered password using md5
    $hashed_pass = md5($pass);
    

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id FROM admin WHERE admin_username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $hashed_pass);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Login successful
        $_SESSION['admin_username'] = $user;
        header("Location: dashboard.php");
    } else {
        // Login failed
        $error = "Invalid username or password.";
        header("Location: index.php?error=" . urlencode($error));
    }

    $stmt->close();
}

$conn->close();
?>
