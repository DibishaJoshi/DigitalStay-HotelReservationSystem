<?php
include 'admin/db_connect.php';

$hotelId = isset($_POST['hotelId']) ? intval($_POST['hotelId']) : 0;
$roomId = isset($_POST['roomId']) ? intval($_POST['roomId']) : 0;
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : '';
$checkIn = isset($_POST['check_in']) ? $_POST['check_in'] : '';
$checkOut = isset($_POST['check_out']) ? $_POST['check_out'] : '';
$adult_no = isset($_POST['adult_no']) ? intval($_POST['adult_no']) : 1;

// $isAvailable = false;
// $available_rooms = 0;
// $price_per_room = 0;

if ($roomId > 0 && $hotelId > 0 && !empty($checkIn) && !empty($checkOut)) {
    $sql = "SELECT quantity, price FROM room WHERE id = $roomId AND hotel_id = $hotelId";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
        $total_rooms = $room['quantity'];
        $price_per_room = $room['price'];
        
        $sql = "SELECT SUM(num_rooms) as booked_rooms FROM reservation_room rr 
                JOIN reservation r ON rr.reservation_id = r.id 
                WHERE rr.r_id = $roomId AND r.hotel_id = $hotelId 
                AND ((r.check_in <= '$checkIn' AND r.check_out >= '$checkIn') OR 
                     (r.check_in <= '$checkOut' AND r.check_out >= '$checkOut') OR 
                     (r.check_in >= '$checkIn' AND r.check_out <= '$checkOut'))";
        $result = $conn->query($sql);
        $booked_rooms = 0;
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $booked_rooms = intval($row['booked_rooms']);
        }

        $available_rooms = $total_rooms - $booked_rooms;
        $isAvailable = $available_rooms > 0;
    }
}

$checkInDate = new DateTime($checkIn);
$checkOutDate = new DateTime($checkOut);
$interval = $checkInDate->diff($checkOutDate);
$num_days = $interval->days;

header("Location: Booking.php?availability=" . ($isAvailable ? 'available' : 'not_available') . "&available_rooms=" . $available_rooms . "&num_days=" . $num_days . "&price_per_room=" . $price_per_room
."&hotel=" .$hotelId. "&room=" . $roomId . "&userId=".$userId. "&check_in=".$checkIn. "&check_out=".$checkOut. "&adult_no=".$adult_no);
exit();
?>
