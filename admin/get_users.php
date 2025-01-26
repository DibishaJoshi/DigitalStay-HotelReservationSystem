<?php
include 'db_connect.php';

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<?php require_once'components/adminhead.php';?>
<?php require_once'components/header.php';?>
<div class="admin-container">
    <h1>Users</h1>
    <table>
        <thead>
            <tr>
                    <th>id</th>
                    <th>full name</th>
                    <th>username</th>
                    <th>contact_number</th>
                    <th>email</th>
                    <!-- <th>password</th> -->
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                $serial_number = 1; 
                    while($row = $result->fetch_assoc()) {
                        
                        echo "<tr>";
                        echo"<td>$serial_number</td>";
                        echo "<td>" . $row['full_name'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['contact_number'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        //echo "<td>" . $row['password'] . "</td>";
                        echo "</tr>";
                        $serial_number++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
