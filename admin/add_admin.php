<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO admin (username,password) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username,$password);

    if ($stmt->execute()) {
        header("Location: get_admin.php?message=Admin Added Successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php'; ?>


    <div class="addadmin-container">
        <form method="POST" action="add_admin.php">
        <h1>Add Admin </h1>
            <label  for="username">Username:</label>
            <input type="text" id="username" name="admin_username"  required>
            <label  for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button  type="submit">Add Admin</button>
        </form>
    </div>

