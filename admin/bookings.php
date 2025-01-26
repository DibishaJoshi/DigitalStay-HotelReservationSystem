<?php include 'db_connect.php'; ?>

<?php
// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    $conn->begin_transaction();

    try {
        // Delete payment record first
        $stmt = $conn->prepare("DELETE FROM payment WHERE reservation_id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting from payment: " . $stmt->error);
        }
        $stmt->close();

        // Then delete from reservation_room
        $stmt = $conn->prepare("DELETE FROM reservation_room WHERE reservation_id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting from reservation_room: " . $stmt->error);
        }
        $stmt->close();

        // Then delete from reservation
        $stmt = $conn->prepare("DELETE FROM reservation WHERE id = ?");
        $stmt->bind_param("i", $id);

        if (!$stmt->execute()) {
            throw new Exception("Error deleting from reservation: " . $stmt->error);
        }
        $stmt->close();

        $conn->commit();
        echo "Record deleted successfully";
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }
}

// Fetch bookings
$query = "SELECT 
    u.full_name as full_name,
    u.username as username,
    u.contact_number as phone_number,
    u.email as email,
    r.check_in as check_in,
    r.check_out as check_out,
    r.id as id,
    ro.name as room_name,
    h.name as hotel_name,
    rs.name as status,
    rs.badge_class,
    rr.price as price,
    rr.num_rooms as num_rooms,
    p.status as payment_status  
FROM 
    users u
JOIN 
    reservation r ON u.id = r.u_id 
JOIN reservation_room rr ON rr.reservation_id = r.id 
JOIN room ro ON ro.id = rr.r_id
JOIN hotel h ON h.id = ro.hotel_id
JOIN reservation_status rs on rs.id = r.status_id
JOIN payment p ON p.reservation_id = r.id  
ORDER BY r.check_in ASC, r.check_out ASC";
$result = $conn->query($query);
?>

<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Admin Interface</title>
    <style>
        .container {
            text-align: center;
        }

        .checkedin {
            background-color: green;
            color: #fff;
            font-size: 0.8em;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .pending {
            background-color: #d6c758;
            color: black;
            font-size: 0.8em;
            font-weight: bolder;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .checkedout {
            background-color: #0d6efd;
            color: #fff;
            font-size: 0.8em;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .cancelled {
            background-color: red;
            color: white;
            font-size: 0.8em;
            padding: 5px 10px;
            border-radius: 4px;
            margin-left: 5px;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333333;
            margin-bottom: 20px;
        }

        .update-form {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #555555;
        }

        .form-control {
            padding: 8px;
            width: 100%;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            z-index: 1000;
        }

        .popup-header {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .popup-content {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .close-popup {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .overlay {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="booking-container">
        <h1>Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Full Name</th>
                    <th>Hotel Name</th>
                    <th>Room Name</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Payment Status</th> 
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) : ?>
                    <?php
                    $serial_number = 1; // Initialize the serial number counter
                    while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= $serial_number ?></td>
                            <td><?= $row['check_in'] ?></td>
                            <td><?= $row['check_out'] ?></td>
                            <td>
                                <a href="#" class="user-link" data-username="<?= $row['username'] ?>" data-email="<?= $row['email'] ?>" data-phone="<?= $row['phone_number'] ?>"><?= $row['full_name'] ?></a>
                            </td>
                            <td><?= $row['hotel_name'] ?></td>
                            <td><?= $row['room_name'] ?></td>
                            <td><span class="<?= $row['badge_class'] ?>"><?= $row['status'] ?></span></td>
                            <td><?= $row['price'] ?></td> 
                            <td><?= $row['payment_status'] ?></td> 
                            <td><?= $row['num_rooms'] ?></td>
                            <td>
                                <a href='update_bookingstatus.php?id=<?= $row['id'] ?>'>Update Status</a><br>
                                <a href='bookings.php?id=<?= $row['id'] ?>' onclick='return confirm("Are you sure you want to delete this booking?")'>Delete</a>
                            </td>
                        </tr>
                        <?php $serial_number++; ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="10">No bookings found</td> 
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <div class="popup-header">User Information</div>
            <div class="popup-content" id="popup-content"></div>
            <button class="close-popup" id="close-popup">Close</button>
        </div>
    </div>
    <script>
        document.querySelectorAll('.user-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const username = this.dataset.username;
                const email = this.dataset.email;
                const phone = this.dataset.phone;

                const content = ` 
                    <p><strong>Username:</strong> ${username}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Phone:</strong> ${phone}</p>
                `;
                document.getElementById('popup-content').innerHTML = content;
                document.getElementById('popup').style.display = 'block';
                document.getElementById('overlay').style.display = 'block';
            });
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });

        document.getElementById('overlay').addEventListener('click', function() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>
