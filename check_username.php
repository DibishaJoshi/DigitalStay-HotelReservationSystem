<?php
include 'admin/db_connect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedUsername = $_POST['username'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $submittedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>parent.updateUsernameAvailability('Username is already taken',false);</script>";
    } else {
        echo "<script>parent.updateUsernameAvailability('Username is available',true);</script>";
    }

    $stmt->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedPhone = $_POST['phone'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE contact_number = $submittedPhone");
    // $stmt->bind_param("i", $submitted);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>parent.updatePhoneAvailability('User already exists with this number',false);</script>";
    } else {
        echo "<script>parent.updatePhoneAvailability('',true);</script>";
    }

    $stmt->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submittedEmail = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = $submittedEmail");
    // $stmt->bind_param("s", $submittedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>parent.updateEmailAvailability('User exists with this email',false);</script>";
    } else {
        echo "<script>parent.updateEmailAvailability('',true);</script>";
    }

    $stmt->close();
}
$conn->close();
?>
