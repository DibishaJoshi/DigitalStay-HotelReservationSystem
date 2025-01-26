<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Delete item
    $sql = "DELETE FROM hotel WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Hotel $id deleted";
    } else {
        echo "Error deleting item: " . $conn->error;
    }
} else {
    echo "ID not set";
}
}else {
    echo "Invalid request method";
}

?>