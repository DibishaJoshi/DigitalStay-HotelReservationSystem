<?php
session_start();
    $host = "localhost"; // Your host
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password
    $database = "digitalstay1"; // Your database name

    // Create a connection
    $connection = mysqli_connect($host, $username, $password, $database);

    // Check the connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert Data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        

        $sql = "INSERT INTO users (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";

        if (mysqli_query($connection, $sql)) {
            echo "User Registered";
            header("Location:login.html");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
        $conn->close();
    }
    
    
   
    ?>