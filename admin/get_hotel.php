<?php
include 'db_connect.php';

$sql = "SELECT 
hotel.id,
hotel.name as name,
hotel.address,
hotel.description,
hotel.image,
hotel.active_status,
location.name as location_name
FROM hotel
left join 
location on hotel.L_id = location.id 
GROUP BY
    hotel.id
ORDER BY
    hotel.id";
$result = $conn->query($sql);
?>
<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotels</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th{
            background-color: #bcb9b9;
        }
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

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
            height: fit-content ;
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
        
    </style>
</head>

<body><div class="admin-container">
    <h1>Hotels</h1>
    <a href="add_hotel.php" class="create-hotel-btn">Create Hotels</a>
    <?php
    if (isset($_GET['message'])) {
        echo '<div class="success-message">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>location</th>
                <th>update</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td><a href='#' class='hotel-name' 
                    data-name='" . $row['name'] . "' 
                    data-address='" . $row['address'] . "' 
                    data-description='" . $row['description'] . "' 
                    data-image='" . $row['image'] . "' 
                    data-location='" . $row['location_name'] . "' 
                    data-status='" . $row['active_status'] . "'>" . $row['name'] . "</a></td>";
                    // echo "<td>" . $row['address'] . "</td>";
                    // echo "<td>" . $row['description'] . "</td>";
                    // echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "' width='100'></td>";
                    echo "<td>" . $row['location_name'] . "</td>";
                    //echo "<td>" . $row['active_status'] . "</td>";
                    echo "<td><form action='update_hotel.php' method='get'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit'  class='update-btn'>Update</button></form></td>";
                    echo "<td><form action='delete_hotel.php' method='post' class='delete-hotel-form'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <button type='submit'  class='delete-btn'>Delete</button></form></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No hotels found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="overlay" id="overlay"></div>
    <div class="popup" id="hotelPopup">
        <button class="popup-close" id="popupClose">Close</button>
        <h2 id="popupName"></h2>
        <p><strong>Address:</strong> <span id="popupAddress"></span></p>
        <p><strong>Description:</strong> <span id="popupDescription"></span></p>
        <p><strong>Location:</strong> <span id="popupLocation"></span></p>
        <p><strong>Status:</strong> <span id="popupStatus"></span></p>
        <img id="popupImage" src="" alt="Hotel Image">
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('overlay');
            const popup = document.getElementById('hotelPopup');
            const closeBtn = document.getElementById('popupClose');
            const hotelLinks = document.querySelectorAll('.hotel-name');

            const popupName = document.getElementById('popupName');
            const popupAddress = document.getElementById('popupAddress');
            const popupDescription = document.getElementById('popupDescription');
            const popupLocation = document.getElementById('popupLocation');
            const popupStatus = document.getElementById('popupStatus');
            const popupImage = document.getElementById('popupImage');

            hotelLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const name = this.getAttribute('data-name');
                    const address = this.getAttribute('data-address');
                    const description = this.getAttribute('data-description');
                    const image = this.getAttribute('data-image');
                    const location = this.getAttribute('data-location');
                    const status = this.getAttribute('data-status');

                    popupName.textContent = name;
                    popupAddress.textContent = address;
                    popupDescription.textContent = description;
                    popupLocation.textContent = location;
                    popupStatus.textContent = status;
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