<?php
include 'admin/db_connect.php';
// Query to fetch booking history with payment status
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// Updated SQL query to include payment status
$sql = "SELECT 
            reservation.id,
            reservation.check_in, 
            reservation.check_out, 
            reservation_room.r_id, 
            reservation_room.price,
            rs.id as status,
            rs.name as status_name,
            room.name as room_name,
            hotel.name as hotel_name,
            payment.status as payment_status
        FROM reservation 
        JOIN reservation_room ON reservation.id = reservation_room.reservation_id
        JOIN reservation_status rs ON reservation.status_id = rs.id
        JOIN room ON room.id = reservation_room.r_id
        JOIN hotel ON hotel.id = reservation.hotel_id
        LEFT JOIN payment ON reservation.id = payment.reservation_id
        WHERE reservation.u_id = ?
        ORDER BY reservation.id";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Handle cancel booking action
if (isset($_POST['cancel_booking'])) {
    $bookingId = intval($_POST['cancel_booking']);

    // Fetch room and hotel IDs from the cancelled reservation
    $fetchSql = "SELECT rr.r_id as room_id, r.hotel_id, r.check_in, r.check_out 
                 FROM reservation_room rr
                 JOIN reservation r ON r.id = rr.reservation_id
                 WHERE r.id = ?";
    $fetchStmt = $conn->prepare($fetchSql);
    $fetchStmt->bind_param("i", $bookingId);
    $fetchStmt->execute();
    $fetchResult = $fetchStmt->get_result();

    // Update reservation status to 'cancelled'
    $updateSql = "UPDATE reservation SET status_id = 4 WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $bookingId);
    
    if ($updateStmt->execute()) {
        // Successful update, redirect to booking history page with success message
        header("Location: booking_history.php?booking=Cancelled+Successfully");
        exit();
    } else {
        // Error handling if the update fails
        echo "Error updating reservation status: " . $updateStmt->error;
    }
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Booking History</title>
    <style> 
        .booking-status {
            color: blue;
            font-size: 25px;
            padding: 20px;
        }
    </style>
</head>
<?php require_once 'components/head.php';
require_once 'components/header.php';
?>

<body>
    <section id="history-container">
        <h1>Booking History</h1>

        <?php if (isset($_GET['booking'])): ?>
            <div class="booking-status"><?php echo htmlspecialchars($_GET['booking']); ?></div>
        <?php endif; ?>
        <table class="booking-history">
            <tr>
                <th>S.No.</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
                <th>Hotel Name</th>
                <th>Room Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>Payment Status</th>
            
            </tr>
            <?php if ($result && $result->num_rows > 0) : ?>
                <?php $serial_number = 1;
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $serial_number ?></td>
                        <td><?php echo htmlspecialchars($row['check_in']); ?></td>
                        <td><?php echo htmlspecialchars($row['check_out']); ?></td>
                        <td><?php echo htmlspecialchars($row['hotel_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['room_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['price']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status'] ?? 'Not Paid'); ?></td>
                        <td>
                            <?php if ($row['status'] === 1) : ?>
                                <form method="post" class="cancel-booking-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="cancel_booking" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <button type="submit" class="book-cancelbtn">Cancel</button>
                                </form>
                            <?php else : ?>
                                <span>Cannot cancel</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                    $serial_number++; // Increment the serial number counter
                    ?>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="10">No bookings found</td>
                </tr>
            <?php endif; ?>
        </table>

    </section>
</body>
<script src="script.js"></script>
<?php require_once 'components/footer.php'; ?>

</html>

<?php
// Close database connection
$conn->close();
?>
