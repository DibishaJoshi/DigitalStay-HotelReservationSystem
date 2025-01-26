<?php
include 'db_connect.php'; // Make sure to replace with your actual database connection file

$sql = "SELECT * FROM location";
$result = $conn->query($sql);
// Update active status
if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {

    $location_id = intval($_POST['id']);
    $active = $_POST['status'] ? 1: 0; // Toggle active status
    $sql = "UPDATE location SET active_status = $active WHERE id = $location_id";
    if ($conn->query($sql) === TRUE) {
        header('Location: view_location.php'); // Redirect back to admin panel after update
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Invalid request method";
}

$conn->close();


require_once'components/adminhead.php';
require_once'components/header.php';?>
<head>
    <style>
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
}

input:checked + .slider {
    background-color: #28a745;
}

input:focus + .slider {
    box-shadow: 0 0 1px #28a745;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}
    </style>
</head>
    <div class="location-container">
        <h1>Locations</h1>
        <a href="add_location.php" class="add-location-btn">Add Location</a>
        <?php
        if (isset($_GET['message'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['message']) . '</div>';
        }
        ?>
        <table id="locationtable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <!-- <th>Active Status</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $status = $row['active_status'] ? 'Active' : 'Inactive';
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td><img src='" . $row['image'] . "' alt='" . $row['name'] . "' width='200'></td>";
                        // echo"<td>
                        //             <form method='post' action='' >
                        //             <label class='switch'>
                        //                 <input type='hidden' name='id' value='{$row['id']}'>
                        //                 <input type='checkbox' name='status' onchange='this.form.submit()'{$status}>
                        //                 <span class='slider round'></span>
                        //             </label>
                        //             </form>
                        //         </td>";
                        // echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No locations found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


