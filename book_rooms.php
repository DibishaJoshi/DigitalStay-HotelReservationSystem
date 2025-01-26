<?php
// Ensure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'admin/db_connect.php';

// Process form data
$hotelId = isset($_POST['hotelId']) ? intval($_POST['hotelId']) : 0;
$roomId = isset($_POST['roomId']) ? intval($_POST['roomId']) : 0;
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$checkIn = isset($_POST['check_in']) ? $_POST['check_in'] : '';
$checkOut = isset($_POST['check_out']) ? $_POST['check_out'] : '';
$adult_no = isset($_POST['adult_no']) ? intval($_POST['adult_no']) : 0;
$num_rooms = isset($_POST['num_rooms']) ? intval($_POST['num_rooms']) : 0;
$available_rooms = isset($_POST['available_rooms']) ? intval($_POST['available_rooms']) : 0;
$price = isset($_POST['totalPrice']) ? floatval($_POST['totalPrice']) : 0;

$isBooked = false;

if ($roomId > 0 && $hotelId > 0 && $userId > 0 && !empty($checkIn) && !empty($checkOut) && $num_rooms > 0) {
    // Insert into reservation table
    $sql = "INSERT INTO reservation (check_in, check_out, u_id, hotel_id, status_id) 
            VALUES ('$checkIn', '$checkOut', '$userId', '$hotelId', 1)";

    if ($conn->query($sql) === TRUE) {
        $reservationId = $conn->insert_id;

        // Insert into reservation_room table
        $sql = "INSERT INTO reservation_room (r_id, price, num_rooms, adult_no, reservation_id) 
                VALUES ('$roomId', '$price','$num_rooms', '$adult_no', '$reservationId')";
                
        if ($conn->query($sql) === TRUE) {
            $isBooked = true;
        } else {
            echo "Error inserting into reservation_room: " . $conn->error;
        }
    } else {
        echo "Error inserting into reservation: " . $conn->error;
    }
} else {
    echo "Invalid reservation data: roomId=$roomId, hotelId=$hotelId, userId=$userId, checkIn=$checkIn, checkOut=$checkOut, num_rooms=$num_rooms, price=$price";
}

// Redirect back to the form with booking status
$bookingStatus = $isBooked ? 'Booking successful' : 'Booking failed';
header("Location: booking_history.php?booking=" . urlencode($bookingStatus));
exit();
?>
