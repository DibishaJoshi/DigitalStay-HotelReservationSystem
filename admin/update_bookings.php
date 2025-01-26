<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['bookings_updated'])) {
    include 'db_connect.php';

    // Get the current date
    $current_date = date('Y-m-d');

    // Update the status of bookings where the checkout date has passed
    $sql = "UPDATE reservation SET status_id = '4' WHERE check_in < '$current_date' AND status_id = '1'";
    if ($conn->query($sql) === TRUE) {
        // echo "Bookings updated successfully";
    } else {
        echo "Error updating bookings: " . $conn->error;
    }

    // Set the session variable to indicate that bookings have been updated
    $_SESSION['bookings_updated'] = true;
}
?>

