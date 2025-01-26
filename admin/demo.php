<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['admin_username'];
    $password = $_POST['password'];

    // Hash the password using md5
    $hashed_password = md5($password);

    $sql = "INSERT INTO admin (admin_username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: get_admin.php?message=Admin Added Successfully");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
$usernameError = "";
$usernameCheckResult = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username_check'])) {
    include 'db_connect.php';
    $submittedUsername = $_POST['admin_username'];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_username = ?");
    $stmt->bind_param("s", $submittedUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usernameCheckResult = "Username is already taken";
    } else {
        $usernameCheckResult = "Username is available";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php require_once 'components/adminhead.php'; ?>
<?php require_once 'components/header.php'; ?>
<style>
    .input-group {
        margin-bottom: 15px;
    }

    .hidden-iframe {
        display: none;
    }

    .availability-taken {
        color: red;
    }

    .availability-available {
        color: green;
    }

    .error {
        color: red;
        font-size: 12px;
    }
</style>
<div class="addadmin-container">
    <form id="username-check-form" method="POST" action="demo.php" target="hidden-iframe">
        <h1>Add Admin</h1>
        <div class="input-field" id="username">
            <i class="fa fa-user"></i>
            <input type="text" placeholder="Username" name="admin_username" oninput="setupTypingTimer()" onkeydown="resetTypingTimer()" required>
            <span id="username-result"></span><br>
        </div>
        <!-- <label for="username">Username:</label>
        <input type="text" id="username" name="admin_username" oninput="setupTypingTimer()" onkeydown="resetTypingTimer()" required>
        <span id="username-result"></span><br> -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <iframe name="hidden-iframe" class="hidden-iframe"></iframe>
        <button type="submit">Add Admin</button>
    </form>
</div>
<script>
    let typingTimer;
    const doneTypingInterval = 500; // Time in ms (0.5 seconds)

    function doneTyping() {
        document.getElementById('username-check-form').submit();
    }

    function setupTypingTimer() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    }

    function resetTypingTimer() {
        clearTimeout(typingTimer);
    }

    function updateUsernameAvailability(result) {
        document.getElementById('username-result').innerText = result;
    }

    function updateUsernameAvailability(result, isAvailable) {
        const resultElement = document.getElementById('username-result');
        resultElement.innerText = result;
        if (isAvailable) {
            resultElement.classList.add('availability-available');
            resultElement.classList.remove('availability-taken');
        } else {
            resultElement.classList.add('availability-taken');
            resultElement.classList.remove('availability-available');
        }
    }
</script>