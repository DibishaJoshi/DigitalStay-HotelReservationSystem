<?php
include 'admin/db_connect.php';
include 'admin/update_bookings.php';
require_once 'components/head.php';
require_once 'components/header.php';
if (isset($_GET['location'])) {
    $location_name = $_GET['location'];
    $sql = "
        SELECT 
            hotel.id,
            hotel.name AS hotel_name,
            hotel.description,
            hotel.address,
            hotel.image,
            location.name AS location_name
        FROM
            hotel
        JOIN
            location ON hotel.L_id = location.id 
        WHERE 
            location.name = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location_name);
    $stmt->execute();
    $result = $stmt->get_result();
    echo '<body>';
    echo '<div id="hotel-details">';
    echo '<h1>Hotels in ' . htmlspecialchars($location_name) . '</h1>';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="hotel-item">';
        echo '<img src="admin/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['hotel_name']) . '">';
        echo '<div class="hotel-info">';
        echo '<h3>' . htmlspecialchars($row['hotel_name']) . '</h3>';
        echo '<p>' . htmlspecialchars($row['description']) . '</p>';
        echo '<p class="address">' . htmlspecialchars($row['address']) . '</p>';
        echo "<form class='book-rooms-form' method='GET' action='view_rooms.php'>";
        echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
        echo "<button type='submit' class='book-rooms-btn'>Book Rooms</button>";
        echo "</form>";
        // echo "<button type='submit' class='book-rooms-btn'>Book Room</button>";
        echo '</div>';
        echo '</div>';
    }

    echo '</div>';
    echo '<a href="index.php">Go Back</a>';
    echo '</body>';
    echo '</html>';

    $stmt->close();
} else {
    echo "Location not specified.";
}

$conn->close();
require_once 'components/footer.php';
?>