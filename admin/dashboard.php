<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php'; ?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "digitalstay";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch counts from database
$hotels_count = $conn->query("SELECT COUNT(*) AS count FROM hotel")->fetch_assoc()['count'];
$users_count = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$rooms_count = $conn->query("SELECT COUNT(*) AS count FROM room")->fetch_assoc()['count'];
$admins_count = $conn->query("SELECT COUNT(*) AS count FROM admin")->fetch_assoc()['count'];
$location_count = $conn->query("SELECT COUNT(*) AS count FROM location")->fetch_assoc()['count'];

$conn->close();
?>
<div class="cards">
<div class="card" onclick="window.location.href='view_location.php'">
        <h2>Locations</h2>
        <p>number of locations: <?php echo $location_count; ?></p>
    </div>
<div class="card" onclick="window.location.href='get_users.php'">
        <h2>Users</h2>
        <p>number of users: <?php echo $users_count; ?></p>
    </div>
    <div class="card" onclick="window.location.href='get_hotel.php'">
        <h2>Hotels</h2>
        <p>number of hotels: <?php echo $hotels_count; ?></p>
    </div>
    <div class="card" onclick="window.location.href='rooms.php'">
        <h2>Rooms</h2>
        <p>number of rooms: <?php echo $rooms_count; ?></p>
    </div>
    <div class="card"onclick="window.location.href='get_admin.php'">
        <h2>Admins</h2>
        <p>number of admins: <?php echo $admins_count; ?></p>
    </div>
</div>
</div>
