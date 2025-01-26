<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    
    // Fetch current status
    $sql = "SELECT * FROM hotel WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $active = ($_row['active_status']==='active' )?'inactive':'active'; // Toggle active status
        // $new_status = ($row['active_status'] === 'active') ? '0' : '1';
        
        // Update status
        $sql = "UPDATE hotel SET active_status = '$active' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            header('Location: get_hotel.php'); 
            exit();
        } else {
            echo "Error updating status: " . $conn->error;
        }
    } else {
        echo "No item found with ID $id";
    }
}
?>
