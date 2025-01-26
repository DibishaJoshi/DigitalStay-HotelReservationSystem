<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Include the update_bookings.php script
include 'admin/update_bookings.php';
?>

<head>
    <style>
        button {
            background-color: white;
            color: black;
            font-size: 18px;
            padding: 20px 600px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 150px;
            height: 40px;
        }

        .top-menuitems a {
            color: black;
            text-decoration: none;
            margin-left: 10px;
            padding-right: 20px;
            font-size: larger;
        }

        .top-menuitems .dropdown .dropbtn {
            position: relative;
            display: inline-block;
            width: fit-content;
        }

        .top-menuitems .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 120px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .top-menuitems .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;

        }

        .top-menuitems .dropdown-content a:hover {
            background-color: #474646;
        }

        .top-menuitems .dropdown:hover .dropdown-content {
            display: block;
        }

        .top-menuitems .dropdown:hover .dropbtn {
            background-color: lightblue;
        }

        .top-menuitems i {
            padding-right: 8px;
            padding-left: 8px;
        }
    </style>
</head>
<section class="top-navbar">
    <div class="top-left">
        <p><span class="mailus">Phone no:</span>
            <a href="#">+977 9860640413</a> or <span class="mailus"></span>email us:<a href="#">digitalstay@email.com</a>
        </p>
    </div>
    <div class="top-right">
        <div class="top-social">
            <a class="nav-link" href="#"><i class="fa fa-facebook"></i></a>
            <a class="nav-link" href="#"><i class="fa fa-instagram"></i></a>
            <a class="nav-link" href="#"><i class="fa fa-google"></i></a>

        </div>
    </div>
</section>
<section class="top-menubar">
    <div class="top-logo">
        <!-- <h2 ><span id="logo-max-text" onclick="window.location.href = 'index.php'">Digital</span><span id="logo-mini-text" onclick="window.location.href = 'index.php'">Stay</span><a></h2> -->
        <img src="admin/digitalstaylogo.png" alt="DigitalStay" onclick="window.location.href = 'index.php'">
    </div>
    <div class="top-menuitems">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <!-- <li><a href="contact.php">Contact</a></li> -->
            <li>
                <?php

                if (isset($_SESSION['username'])) {
                    echo ' <li><a href="booking_history.php">Booking</a></li>';
                    echo '<div class="top-menuitems"><div class="dropdown">
                    <button class="dropbtn"><i class="fa fa-user"></i>' . htmlspecialchars($_SESSION['username']) . '<i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="logout.php">Logout</a>
                    </div></div></div>';
                } else {
                    echo '<a href="login.php">Login</a>';
                    echo '<a href="register.php">Register</a>';
                }
                ?>
            </li>
            <!-- <li><a href="login.html">Login</a></li>
        <li><a href="register.html">Register</a></li> -->
            <!-- <li><a class="nav-link" href="#"><i class="fa fa-search"></i></a></li> -->
        </ul>
    </div>
</section>