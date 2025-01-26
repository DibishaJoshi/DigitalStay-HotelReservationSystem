<?php
include 'db_connect.php';

$sql = "SELECT id , name FROM hotel order by name";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rooms = array();
    $hotels = [];
    while($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
} else {
    echo "0 results";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $adult_no= $_POST['adult_no'];
    $hotel_id = $_POST['hotel_id'];
    $image = $_FILES['image']['name'];
    $quantity = $_POST['quantity'];
    if ($price < 0) {
        echo "Price cannot be a negative number.";
        exit();
    }
    // Handle file upload
    if (isset($_FILES['image'])) {
        $target_dir = "uploads/rooms/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    $sql = "INSERT INTO room (name, price, description, adult_no, hotel_id,image,quantity) VALUES ('$name', '$price','$description', '$adult_no', '$hotel_id','$image',$quantity)";

    if ($conn->query($sql) === TRUE) {
        header("Location: rooms.php?message=Room added successfully");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
</head>
<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php';?>
<body>
    <form  id="addRoom" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <h1>Create Rooms</h1>
    <?php
        if (isset($_GET['message'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['message']) . '</div>';
        }
    ?>
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="file" id="image" name="image" accept="image/*" required><br>
    <input type="number" id="price" name="price" placeholder="Price" min="0" required><br>
    <input type="number" id="adult-no" name="adult_no" min="1" placeholder="Number of Adults" required><br>
    <textarea name="description" placeholder="Description" cols="60" rows="5" required></textarea><br>
    <input type="number" id="quantity" name="quantity" min="1" placeholder="Number of rooms" required><br>
    <select name="hotel_id" required>
        <option value="" disabled selected>Choose Hotel Name</option>
        <?php
        foreach ($hotels as $hotel) {
            echo "<option value=".$hotel['id'].">".$hotel['name']."</option>";
        }
        ?>
    </select><br>
    <button type="submit" id="c-button">Create</button>
    </form>
    <script>
        function validateForm() {
            const price = document.getElementById('price').value;
            const adult = document.getElementById('adult-no').value;
            const quantity = document.getElementById('quantity').value;
            let isValid = true;

            if (price < 0) {
                alert("Price cannot be a negative number.");
                isValid = false;
            } 
            if (price == 0) {
                alert("Price cannot be 0");
                isValid = false;
            }
            if (price < 4000) {
                alert("Price cannot be more than 4000");
                isValid = false;
            }
            if (adult < 0) {
                alert("Number of adults cannot be a negative number.");
                isValid = false;
            } 
            if (adult == 0) {
                alert("Number of adults cannot be 0");
                isValid = false;
            }
            if (quantity < 1) {
                alert("Quantity must be at least 1");
                isValid = false;
            }

            return isValid;
        }

        document.getElementById('addRoom').addEventListener('submit', function (event) {
            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

            if (file && !validImageTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF).');
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>
