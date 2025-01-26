<?php
include 'admin/db_connect.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isBooked = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
    if ($userId > 0) {
        // Fetch user details
        $stmt = $conn->prepare("SELECT full_name, email, contact_number FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $customerName = $user['full_name'];
            $customerEmail = $user['email'];
            $customerPhone = $user['contact_number'];
        } else {
            die(json_encode(array("error" => "User not found")));
        }
        $stmt->close();
    } else {
        die(json_encode(array("error" => "Invalid user ID")));
    }

    // Collect form data
    $hotelId = isset($_POST['hotelId']) ? intval($_POST['hotelId']) : 0;
    $roomId = isset($_POST['roomId']) ? intval($_POST['roomId']) : 0;
    $checkIn = isset($_POST['check_in']) ? $_POST['check_in'] : '';
    $checkOut = isset($_POST['check_out']) ? $_POST['check_out'] : '';
    $adult_no = isset($_POST['adult_no']) ? intval($_POST['adult_no']) : 0;
    $num_rooms = isset($_POST['num_rooms']) ? intval($_POST['num_rooms']) : 0;
    $totalPrice = isset($_POST['totalPrice']) ? floatval($_POST['totalPrice']) : 0; // Validate total price
    $amount = $totalPrice * 100; // Convert to paisa
    $paymentId = uniqid("Payment_"); // Generate a unique payment ID
    $paymentName = "Hotel Room Booking";
    // echo "Price: " . $_POST['price'] . "<br>";
    // echo "Total Price: " . $_POST['totalPrice'] . "<br>";
    
    // Ensure price and totalPrice are valid
    if ($totalPrice <= 0) {
        die(json_encode(array("error" => "Invalid price or total price")));
    }

    // Insert into reservation table
    if ($roomId > 0 && $hotelId > 0 && $userId > 0 && !empty($checkIn) && !empty($checkOut) && $num_rooms > 0) {
        $sql = "INSERT INTO reservation (check_in, check_out, u_id, hotel_id, status_id) 
                VALUES ('$checkIn', '$checkOut', '$userId', '$hotelId', 1)";
        if ($conn->query($sql) === TRUE) {
            $reservationId = $conn->insert_id;

            // Insert into reservation_room table
            $sql = "INSERT INTO reservation_room (r_id, price, num_rooms, adult_no, reservation_id) 
                    VALUES ('$roomId', '$totalPrice', '$num_rooms', '$adult_no', '$reservationId')";
            if ($conn->query($sql) === TRUE) {
                $isBooked = true;

                // Insert payment data into the payments table
                $stmt = $conn->prepare("INSERT INTO payment (payment_id, reservation_id, amount, status) 
                                        VALUES (?, ?, ?, ?)");
                $status = 'paid'; // Default status before payment confirmation
                $stmt->bind_param("siis", $paymentId, $reservationId, $totalPrice, $status);

                if ($stmt->execute()) {
                    // Initiate Khalti payment
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode(array(
                            "return_url" => "http://localhost/digitalstay/paymentresponse.php",
                            "website_url" => "http://localhost/digitalstay/",
                            "amount" => $amount,
                            "purchase_order_id" => $paymentId,
                            "purchase_order_name" => $paymentName,
                            "customer_info" => array(
                                "name" => $customerName,
                                "email" => $customerEmail,
                                "phone" => $customerPhone
                            )
                        )),
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Key live_secret_key_68791341fdd94846a146f0457ff7b455', // Replace with your live key
                            'Content-Type: application/json',
                        ),
                    ));

                    $response = curl_exec($curl);
                    if (curl_errno($curl)) {
                        echo 'Error:' . curl_error($curl);
                    } else {
                        $responseArray = json_decode($response, true);

                        if (isset($responseArray['payment_url'])) {
                            // Redirect to payment URL
                            header('Location: ' . $responseArray['payment_url']);
                            exit();
                        } else {
                            echo 'Unexpected response: ' . $response;
                        }
                    }
                    curl_close($curl);
                } else {
                    echo 'Error inserting into payments: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error inserting into reservation_room: " . $conn->error;
            }
        } else {
            echo "Error inserting into reservation: " . $conn->error;
        }
    } else {
        echo "Invalid reservation data: roomId=$roomId, hotelId=$hotelId, userId=$userId, checkIn=$checkIn, checkOut=$checkOut, num_rooms=$num_rooms, price=$price";
    }
}


// Redirect back to the form with booking status
$bookingStatus = $isBooked ? 'Booking successful' : 'Booking failed';
header("Location: booking_history.php?booking=" . urlencode($bookingStatus));
exit();
?>
