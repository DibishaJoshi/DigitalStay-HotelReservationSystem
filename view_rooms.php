<?php
require 'admin/db_connect.php';
include 'components/head.php';
include 'components/header.php';
if (isset($_GET['id'])) {
    $hotel_id = intval($_GET['id']);
    $sql = "SELECT name FROM hotel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();

    if (!$hotel) {
        echo "No hotel found with ID: $hotel_id";
        exit;
    }

    $sql = "SELECT room.id, room.name, room.description, room.price, room.image, hotel.name as hotel_name FROM room JOIN hotel ON hotel.id = '$hotel_id' WHERE hotel_id = '$hotel_id' ";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
        $hotel_name = $row['hotel_name'];
    }
}

$conn->close();
} else {
    echo "ID not set";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/style_rooms.css"> -->
</head>
    <section class="room__container" id="room">
        <p class="section__subheader">ROOMS</p>
        <h2 class="section__header"> <?php echo 'Hand Picked Rooms at ' . htmlspecialchars($hotel_name) ;?></h2>
        <div class="room__grid">
            <?php
            foreach ($rooms as $room) {
                echo '<div class="room__card"  onclick="window.location.href=\'booking.php?hotel='. urlencode($hotel_id) .'&room=' . urlencode($room['id']) . '\'">';
                echo '<img src="admin/uploads/rooms/' . htmlspecialchars($room['image']) . '" alt="room" />';
                echo '<div class="room__card__details">';
                echo '<div>';
                echo '<h4>' . htmlspecialchars($room['name']) . '</h4>';
                echo '<p>' . htmlspecialchars($room['description']) . '</p>';
                echo '</div>';
                echo '<h3>' . htmlspecialchars($room['price']) . '<span>/night</span></h3>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
    <footer>
        <?php require_once 'components/footer.php'; ?>
    </footer>

</html>
