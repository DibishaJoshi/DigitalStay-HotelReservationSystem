<?php
require 'db_connect.php';

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
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

            // Update item using prepared statements
            $stmt = $conn->prepare("UPDATE hotel SET name = ?, address = ?, image = ?, description = ?, L_id = ? WHERE id = ?");
            if ($stmt === false) {
                echo "Error: " . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("ssssii", $name, $address, $image_path, $description, $L_id, $id);

                if ($stmt->execute()) {
                    header("Location: get_hotel.php?message=Hotel+updated");
                    exit();
                } else {
                    echo "Error updating item: " . htmlspecialchars($stmt->error);
                }

                $stmt->close();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "ID not set";
    }
} else {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM hotel WHERE id = $id");
    $row = $result->fetch_assoc();
}

$conn->close();

require_once "components/adminhead.php";
require_once "components/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Hotel</title>
</head>
<body>
    <form method="POST" action="update_hotel.php" enctype="multipart/form-data">
        <h1>Update Hotel</h1>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>
        <label for="location">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $row['address']; ?>" required>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" value="<?php echo $row['address']; ?>"required><br><br>

        <label for="description">Description:</label>
        <textarea type="text" id="description" name="description" value="<?php echo $row['description']; ?>" cols="50" rows="10" ></textarea>

        <label for="L_id">Location :</label>
        <select name="L_id" required>
            <option value="" disabled selected>Choose Location Name</option>
            <?php
            
            foreach ($locations as $location) {
                echo "<option value=".$location['id'].">".$location['name']."</option>";
            }
            ?></select>
        <button type="submit" style="margin:5px">Update</button>
    </form>
</body>
</html>

