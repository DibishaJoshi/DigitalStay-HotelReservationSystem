<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location_name = $_POST['location_name'];
    // Handle image upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    echo $_FILES['image']['tmp_name'];

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image_path = $target_file;
        $sql = "INSERT INTO location (name,image) VALUES ('$location_name','$image_path')";
        $stmt = $conn->prepare($sql);
        // $stmt->bind_param("ss", $location_name);

        if ($stmt->execute()) {
            header("Location: view_location.php?message=Location added successfully");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }else {
        echo "Sorry, there was an error uploading your file.";
    }

    $conn->close();
}?>
<head>
 <?php require_once 'components/adminhead.php';
 require_once 'components/header.php'; ?>
</head>
<body>
    <div class="addlocation-container">
        <h1>Add Location</h1>
        <form id="addLocation" method="post" action="" enctype="multipart/form-data">
            <label for="location_name">Location Name:</label>
            <input type="text" id="location_name" name="location_name" required>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*"><br><br>
            <button  type="submit">Add Location</button>
        </form>
    </div>
</body>
<script src="script.js"></script>