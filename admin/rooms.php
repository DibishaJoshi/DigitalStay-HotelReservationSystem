<?php
include 'db_connect.php'; ?>

<?php
// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM room WHERE id = $id";
    $conn->query($sql);
}

// Handle status change request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_status'])) {
    $id = $_POST['id'];
    // Logic to toggle status value, e.g., 1 to 0 or 0 to 1
    $status_value = $_POST['status_value'] == 1 ? 0 : 1;
    $sql = "UPDATE room SET status_value = $status_value WHERE id = $id";
    $conn->query($sql);
}

// Fetch rooms
$sql = "SELECT
    room.id,
    room.name AS name,
    room.price,
    room.description,
    room.adult_no,
    room.image,
    room.quantity,
    hotel.name AS hotel_name
FROM
    room
JOIN
    hotel ON room.hotel_id = hotel.id
LEFT JOIN 
    reservation_room rr ON room.id = rr.r_id
GROUP BY
    room.id
ORDER BY
    room.id";
$result = $conn->query($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'components/adminhead.php';
    require_once 'components/header.php'; ?>
    <style>
        a {
            text-decoration: none;
            color: black;
        }

        .popup {
            display: none;
            margin: 10px;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 50%;
            max-height: fit-content;
            transform: translate(-50%, -50%);
            border: 1px solid #ddd;
            padding: 20px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            overflow: hidden;

        }

        .popup img {
            width: 500px;
            height: fit-content;
        }

        .popup-content {
            padding: 20px;
            overflow-y: auto;
            max-height: calc(80vh - 100px);
            /* Adjust this value based on the header height */
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #f2f2f2;
            border-bottom: 1px solid #ddd;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            background-color: #f2f2f2;
            border: none;
            padding: 5px 10px;
            background-color: red;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        form.delete-room-form{
            padding:0px;
        }
    </style>
</head>

<body>
    <div class="room-container">
    <h1>Rooms</h1>
    <button class="create-room" onclick="window.location.href='create_rooms.php'">Create Room</button>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Hotel Name</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td>
                            <a href="#" class="room-name" 
                            data-name="<?= $row['name'] ?>" 
                            data-price="<?= $row['price'] ?>" 
                            data-description="<?= $row['description'] ?>" 
                            data-image="<?= 'uploads/rooms/' . $row['image'] ?>" 
                            data-quantity="<?= $row['quantity'] ?>">
                                <?= $row['name'] ?>
                            </a>
                        </td>
                        <td><?= $row['hotel_name'] ?></td>
                        <!-- <td>
                            <form class="delete-room" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <input type="hidden" name="status_value" value="<?= $row['status_value'] ?>">
                                <button type="submit" name="change_status" class="status">Status</button>
                            </form>
                        </td>  -->
                        <td>
                            <form method="post" class="delete-room-form" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="12">No rooms found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="overlay" id="overlay"></div>
    <div class="popup" id="RoomsPopup">
        <button class="popup-close" id="popupClose">Close</button>
        <h2 id="popupName"></h2>
        <p><strong>Price:</strong> <span id="popupPrice"></span></p>
        <p><strong>Description:</strong> <span id="popupDescription"></span></p>
        <p><strong>Quantity:</strong> <span id="popupQuantity"></span></p>
        <img id="popupImage" src="" alt="Rooms Image">
    </div>
    </div>

    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('RoomsPopup');
            const closeBtn = document.getElementById('popupClose');
            const roomLinks = document.querySelectorAll('.room-name');

            const popupName = document.getElementById('popupName');
            const popupPrice = document.getElementById('popupPrice');
            const popupDescription = document.getElementById('popupDescription');
            const popupQuantity = document.getElementById('popupQuantity');
            const popupImage = document.getElementById('popupImage');

            roomLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const name = this.getAttribute('data-name');
                    const price = this.getAttribute('data-price'); // Fixed variable name
                    const description = this.getAttribute('data-description');
                    const image = this.getAttribute('data-image');
                    const quantity = this.getAttribute('data-quantity');

                    popupName.textContent = name;
                    popupPrice.textContent = price;
                    popupDescription.textContent = description;
                    popupQuantity.textContent = quantity;
                    popupImage.src = image;
                    popupImage.alt = name;

                    overlay.style.display = 'block';
                    popup.style.display = 'block';
                });
            });

            closeBtn.addEventListener('click', function() {
                overlay.style.display = 'none';
                popup.style.display = 'none';
            });

            overlay.addEventListener('click', function() {
                overlay.style.display = 'none';
                popup.style.display = 'none';
            });
        });
    </script>
</body>

</html>