<?php
// Include your database connection file
include 'db_connect.php';

// Check if the delete button is clicked and if an ID is passed
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM reservation WHERE id = ?";
    $sql = "DELETE FROM reservation_room WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
