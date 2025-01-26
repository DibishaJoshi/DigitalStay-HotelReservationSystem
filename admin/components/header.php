<?php
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: index.php");
    exit();
}

// Include the update_bookings.php script
include 'update_bookings.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_css.css"> -->
    <?php require_once 'components/adminhead.php'; ?>
</head>
<body>
    <div class="sidebar">
        <div class="logo"><img src="digitalstaylogo.png" alt="DigitalStay" onclick="window.location.href='dashboard.php'"></div>
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="get_admin.php">Admins</a></li>
            <li><a href="get_users.php">Users</a></li>
            <li><a href="view_location.php">Locations</a></li>
            <li><a href="get_hotel.php">Hotels</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="bookings.php">Bookings</a></li>
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <div class="header-right">
                <a href="dashboard.php">Home</a>
            
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($_SESSION['admin_username']); ?> 
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div>
                </div> 
            </div>
        </div>
        
</body>
</html>


