<?php require_once 'components/head.php'; ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    $returnUrl = $_SERVER['REQUEST_URI'];
    $_SESSION['returnUrl'] = $returnUrl;
    header("location: /digitalstay/login.php");
    exit();
}
include 'admin/db_connect.php';
$roomId = isset($_GET['room']) ? intval($_GET['room']) : 0;
$hotelId = isset($_GET['hotel']) ? intval($_GET['hotel']) : 0;
$checkIn = isset($_GET['check_in']) ? $_GET['check_in'] : '';
$checkOut = isset($_GET['check_out']) ? $_GET['check_out'] : '';
$adult_no = isset($_GET['adult_no']) ? intval($_GET['adult_no']) : 0;
$userId = isset($_SESSION['userId']) ? intval($_SESSION['userId']) : 0;

// Fetch room details
$roomName = '';
$price = 0;
if ($roomId > 0) {
    $sql = "SELECT name, price FROM room WHERE id = $roomId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roomName = $row['name'];
        $price = $row['price'];
    }
}

// Fetch hotel details
$hotelName = '';
if ($hotelId > 0) {
    $sql = "SELECT name FROM hotel WHERE id = $hotelId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hotelName = $row['name'];
    }
}

// Check for status parameter
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <header>
        <?php require_once 'components/header.php'; ?>
    </header>
    <div class="booking-container">
        <h1>Book Your Stay</h1><br><br>
        <?php if ($status == 'failed') : ?>
            <p style="color: red;">Booking failed. Please try again.</p><br>
        <?php endif; ?>
        <form id="bookingForm" onsubmit="return validateForm()" method="POST">
            <label for="checkInDate">Check-in Date:</label>
            <input type="text" id="check_in" name="check_in" value="<?php echo htmlspecialchars($checkIn); ?>" required>

            <label for="checkOutDate">Check-out Date:</label>
            <input type="text" id="check_out" name="check_out" value="<?php echo htmlspecialchars($checkOut); ?>" required>

            <label for="guests">Adult No:</label>
            <input type="number" id="adults" name="adult_no" min="1" value="<?php echo htmlspecialchars($adult_no); ?>" required>

            <label for="hotelName">Hotel Name:</label>
            <input type="text" id="hotelName" name="hotelName" value="<?php echo htmlspecialchars($hotelName); ?>" readonly required>
            <input type="hidden" id="hotelId" name="hotelId" value="<?php echo htmlspecialchars($hotelId); ?>" />

            <label for="roomType">Room Type:</label>
            <input type="text" id="roomType" name="roomType" value="<?php echo htmlspecialchars($roomName); ?>" readonly required>
            <input type="hidden" id="roomId" name="roomId" value="<?php echo htmlspecialchars($roomId); ?>" />

            <button type="button" id="checkavailability" onclick="if (validateForm()) checkAvailability(event);s">Check Availability</button>

            <div id="availabilityMessage">
                <?php
                if (isset($_GET['availability'])) {
                    $availability = htmlspecialchars($_GET['availability']);
                    $available_rooms = isset($_GET['available_rooms']) ? intval($_GET['available_rooms']) : 0;
                    $num_days = isset($_GET['num_days']) ? intval($_GET['num_days']) : 0;
                    $price_per_room = isset($_GET['price_per_room']) ? floatval($_GET['price_per_room']) : 0;

                    echo "<script>document.getElementById('checkavailability').style.display = 'none';</script>";

                    if ($availability == 'available') {
                        echo "<p style='color: green;'>Rooms are available for your selected dates.</p>";
                        echo "<label for='num_rooms'>Number of Rooms:</label>";
                        echo "<select id='num_rooms' name='num_rooms' onchange='calculateTotalPrice()' required>";
                        echo "<option value='' disabled selected>Select number of rooms</option>";
                        for ($i = 1; $i <= $available_rooms; $i++) {
                            echo "<option value='$i'>$i</option>";
                        }
                        echo "</select><br>";

                        echo "<input type='hidden' id='price_per_room' value='$price_per_room'>";
                        echo "<input type='hidden' id='num_days' value='$num_days'>";
                        echo "<p id='total_price'></p>";

                        echo '<button onclick="dummyPay(event)" id="payButton" style="background-color: #5C2D91; cursor: pointer; color: #fff; border: none; padding: 5px 10px; border-radius: 2px">Pay with Khalti</button>';
                        echo "<p style='font-weight:bold;font-size:20px;'>Or</p><br>";
                        echo "<button id='book_now_button' onclick='validateForm();bookNow(event);'>Book Now</button><br>";
                    } else if ($availability == 'not_available') {
                        echo "<p style='color: red;'>No rooms are available for your selected dates.</p>";
                        echo "<script>document.getElementById('checkavailability').style.display = 'block';</script>";
                    }
                }
                ?>
            </div>
            <input type="hidden" id="totalPrice" name="totalPrice" value="" />
            
        </form>
    </div>

    <script>
        $(function() {
            var check_in = $('#check_in');
            var check_out = $('#check_out');

            check_in.datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 0,
                onSelect: function(selectedDate) {
                    var minDate = new Date(selectedDate);
                    minDate.setDate(minDate.getDate() + 1);
                    check_out.datepicker('option', 'minDate', minDate);
                    if (check_out.datepicker('getDate') <= minDate) {
                        check_out.datepicker('setDate', minDate);
                    }
                    calculatePrice();
                }
            });

            check_out.datepicker({
                dateFormat: 'yy-mm-dd',
                minDate: 1,
                onSelect: function(selectedDate) {
                    calculatePrice();
                }
            });
        });

        function checkAvailability(event) {
            // Prevent form submission
            event.preventDefault();

            // Set form action to check availability
            document.getElementById('bookingForm').action = 'check_and_book_rooms.php';
            document.getElementById('bookingForm').submit();
        }

        function validateForm() {
            const adults = parseInt(document.getElementById('adults').value);
            if (adults <= 0) {
                alert('The number of adults must be greater than zero.');
                return false;
            }
            return true;
        }

        function calculateTotalPrice() {
            const numRooms = parseInt(document.getElementById('num_rooms').value);
            const pricePerRoom = parseFloat(document.getElementById('price_per_room').value);
            const numDays = parseInt(document.getElementById('num_days').value);

            console.log('numRooms:', numRooms, 'pricePerRoom:', pricePerRoom, 'numDays:', numDays);

            const totalPrice = numRooms * pricePerRoom * numDays;
            document.getElementById('total_price').textContent = 'Total Price: Rs.' + totalPrice.toFixed(2);
            document.getElementById('totalPrice').value = totalPrice.toFixed(2);

            console.log('totalPrice:', totalPrice.toFixed(2));
        }
        function validateForm() {
            const adults = parseInt(document.getElementById('adults').value);
            if (adults <= 0) {
                alert('The number of adults must be greater than zero.');
                return false;
            }
            return true;
        }
        function bookNow(event) {
            event.preventDefault();
            const totalPrice = document.getElementById('totalPrice').value;
            if (totalPrice === '' || totalPrice === '0.00') {
                alert('Please select the number of rooms to calculate the total price.');
                return;
            }
            const bookingForm = document.getElementById('bookingForm');
            bookingForm.action = 'book_rooms.php';
            bookingForm.submit();
        }
        document.addEventListener('DOMContentLoaded', function () {
            const payButton = document.getElementById('payButton');
            payButton.addEventListener('click', dummyPay);
            function dummyPay(event) {
            event.preventDefault(); // Prevent the default form submission behavior

            const totalPrice = document.getElementById('totalPrice').value;

            if (totalPrice === '' || totalPrice === '0.00') {
                alert('Please select the number of rooms to calculate the total price.');
                return;
            }
            const payButton = document.getElementById('payButton');
            bookingForm.action = 'khaltipay.php';
            bookingForm.submit();

            }
        });

    </script>
</body>

</html>
<?php require_once 'components/footer.php'; ?>