<?php require_once 'components/adminhead.php';
require_once 'components/header.php'; ?>
<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch booking details
    $query = "
    SELECT 
        id,name 
    FROM 
        reservation_status";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $reservation_status = $stmt->get_result();

    $query = "
    SELECT 
        id,status_id 
    FROM 
        reservation
        where id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('d', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservation = $result->fetch_assoc();
} else {
    header("Location: bookings.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    // Update booking status
    $update_query = "
    UPDATE 
        reservation 
    SET 
        status_id = ? 
    WHERE 
        id = ?
    ";

    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('si', $status, $id);

    if ($update_stmt->execute()) {
        echo "Booking status updated successfully!";
    } else {
        echo "Error: " . $update_stmt->error;
    }

    $update_stmt->close();

    header("Location: bookings.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking Status</title>
    <style>
        /* styles.css */
        #update {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: grid;
            justify-content: center;
            align-items: center;
        }

        /* .container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
} */

        h2 {
            text-align: center;
            color: #333333;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .update-form {
            display: grid;

        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 0;
            display: grid;
            color: #555555;

        }

        .form-control {
            padding: 8px;
            width: 100%;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        button[type='submit'] {
            background-color: green;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin:20px;
            margin-left: 0;
        }

        button[type='submit']:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <section class="update-form">
        <div id="update-container">
        <h2>Update Booking Status</h2>
        <form action="update_bookingstatus.php?id=<?= $id ?>" method="post">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <?php while ($row = $reservation_status->fetch_assoc()) : ?>
                    <?php $isSelected = $row['id'] == $reservation['status_id'] ? 'selected' : ''; ?>
                    <option value="<?= $row['id'] ?>" <?= $isSelected ?>><?= $row['name'] ?></option>

                <?php endwhile; ?>

            </select>
            <br>
            <button type="submit">Update Status</button>
        </form>
        </div>
    </section>

</body>

</html>