<?php
include 'db_connect.php';

$sql = "SELECT id, name FROM location ORDER BY name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data and store in array
    $locations = [];
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
} else {
    echo "0 results";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    $L_id = $_POST['L_id'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/hotels/";
    $target_file = $target_dir . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = $target_file;

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO hotel (name, address, image, description, L_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            echo "Error: " . htmlspecialchars($conn->error);
        } else {
            $stmt->bind_param("ssssi", $name, $address, $image_path, $description, $L_id);

            if ($stmt->execute()) {
                header("Location: get_hotel.php?message=New Hotel Added Successfully");
                exit();
            } else {
                echo "Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();

require_once 'components/adminhead.php';
require_once 'components/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Hotel</title>
    <link rel="stylesheet" href="admin_css.css">
</head>

    <form id="addhotel" action="" method="post" enctype="multipart/form-data">
    <h2>Add New Hotel</h2>
        <label for="name">Hotel Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required><br><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*"><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="5" cols="50" required></textarea><br><br>

        <label for="L_id">Location :</label>
        <select name="L_id" required>
            <option value="" disabled selected>Choose Location Name</option>
            <?php
            
            foreach ($locations as $location) {
                echo "<option value=".$location['id'].">".$location['name']."</option>";
            }
            ?></select>
        
        <button type="submit" value="Add Hotel">Add Hotel</button>
    </form>
    <script src="script.js">
    </script>
    
</html>
