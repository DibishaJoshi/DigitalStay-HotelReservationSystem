<?php
include 'db_connect.php';

$sql = "SELECT * FROM admin";
$result = $conn->query($sql);
?>
<?php require_once'components/adminhead.php';?>
<?php require_once'components/header.php';?>
<div class="admin-container">
    <h1>Admins</h1>
    <!-- <a href="add_admin.php" class="create-admin-btn">Create admins</a> -->
    <table>
        <thead>
            <tr>
                    <th>id</th>
                    <th>name</th>
                    <!-- <th>password</th> -->
                    <!-- <th>update</th> -->
                    <!-- <th>delete</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['admin_username'] . "</td>";
                        // echo "<td>" . $row['password'] . "</td>";
                        // echo "<td>" . $row['status_value'] . "</td>";
                        // echo "<td><a href='change_status.php?id=" . $row['id'] . "' class='status-btn'>status</a></td>";
                        // echo "<td><a href='update_admin.php?id=" . $row['id'] . "' class='update-btn'>Update</a></td>";
                        // echo "<td><a href='delete_admin.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a></td>";
                        echo "</tr>";
                        
                    }
                } else {
                    echo "<tr><td colspan='7'>No admin found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
