<?php
include 'admin/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Hash the password using md5
    $hashed_password = md5($password);

    $sql = "INSERT INTO users (full_name, username, email, contact_number, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $full_name, $username, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo "User Registered";
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$usernameError = "";
$usernameCheckResult = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username_check'])) {
    include 'admin/db_connect.php';
    $submittedUsername = $_POST['username'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $usernameError = "Registration successful (or handle errors here)";
}

$conn->close();
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale =1.0">
    <title> Register Form</title>
    <link rel="stylesheet" href="css/registercss.css">
    <link rel="stylesheet" href="https:/cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        function updatePhoneAvailability(result, isAvailable) {
            const resultElement = document.getElementById('phone-result');
            resultElement.innerText = result;
            if (isAvailable) {
                resultElement.classList.add('availability-available');
                resultElement.classList.remove('availability-taken');
            } else {
                resultElement.classList.add('availability-taken');
                resultElement.classList.remove('availability-available');
            }
        }

        function updateEmailAvailability(result, isAvailable) {
            const resultElement = document.getElementById('email-result');
            resultElement.innerText = result;
            if (isAvailable) {
                resultElement.classList.add('availability-available');
                resultElement.classList.remove('availability-taken');
            } else {
                resultElement.classList.add('availability-taken');
                resultElement.classList.remove('availability-available');
            }
        }

        function validate() {
            let isValid = true;
            const full_name = document.querySelector('input[name="full_name"]').value;
            const username = document.querySelector('input[name="username"]').value;
            const phone = document.querySelector('input[name="phone"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            //validate username
            if (username === null || username === '') {
                displayError('username-error', 'Please enter your username');
                isValid = false;
            } else if (username.length < 3) {
                displayError('username-error', 'Username must be at least 3 characters long');
                isValid = false;
            } else {
                clearError('username-error');
            }

            //validate full_name
            if (full_name === null || full_name === '') {
                displayError('full_name-error', 'Please enter your full name');
                isValid = false;
            }
            // } else if (username.length < 5) {
            //     displayError('full_name-error', 'Full name must be at least 5 characters long');
            //     isValid = false;
            // }
            else {
                clearError('full_name-error');
            }
            // Validate phone
            const phonePattern = /^[0-9]{10}$/;
            if (phone === null || phone === '') {
                displayError('phone-error', 'Please enter your phone number');
                isValid = false;
            } else if (!phonePattern.test(phone)) {
                displayError('phone-error', 'Phone must be 10 digits long');
                isValid = false;
            } else {
                clearError('phone-error');
            }

            // Validate email
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (email === null || email === '') {
                displayError('email-error', 'Please enter your email');
                isValid = false;
            } else if (!emailPattern.test(email)) {
                displayError('email-error', 'Invalid email address');
                isValid = false;
            } else {
                clearError('email-error');
            }

            // Validate password
            if (password === null || password === '') {
                displayError('password-error', 'Please enter your password.');
                isValid = false;
            } else if (password.length < 6) {
                displayError('password-error', 'Password must be at least 6 characters long');
                isValid = false;
            } else {
                clearError('password-error');
            }
            console.log(isValid, 'qwerty');
            return isValid;
        }

        function displayError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.innerText = message;
        }

        function clearError(elementId) {
            const errorElement = document.getElementById(elementId);
            errorElement.innerText = '';
        }

        function transferData() {
            const username = document.querySelector('#username-check-form input[name="username"]').value;
            document.querySelector('#form input[name="username"]').value = username;

            const phone = document.querySelector('#username-check-form input[name="phone"]').value;
            document.querySelector('#form input[name="phone"]').value = phone;

            const email = document.querySelector('#username-check-form input[name="email"]').value;
            document.querySelector('#form input[name="email"]').value = email;

            const full_name = document.querySelector('#username-check-form input[name="full_name"]').value;
            document.querySelector('#form input[name="full_name"]').value = full_name;
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="form-box-register">
            <h1 id="title">Register</h1>
            <form id="username-check-form" method="post" action="check_username.php" target="hidden-iframe">
                <div class="input-group">
                    <div class="input-field" id="full_name">
                        <i class="fa fa-user"></i>
                        <input type="text" placeholder="Your Full Name" name="full_name">
                    </div>
                    <div id="full_name-error" class="error"></div>
                    <div class="input-field" id="username">
                        <i class="fa fa-user"></i>
                        <input type="text" placeholder="Username" name="username" oninput="setupTypingTimer()" onkeydown="resetTypingTimer()" required>
                        <span id="username-result"></span><br>
                    </div>
                    <div id="username-error" class="error"></div>
                </div>
                <div id="full_name-error" class="error"></div>
                <div class="input-field" id="phone">
                    <i class="fa fa-phone"></i>
                    <input type="text" placeholder="Phone" name="phone" oninput="setupTypingTimer()" onkeydown="resetTypingTimer()">
                    <span id="phone-result"></span><br>
                </div>
                <div id="phone-error" class="error"></div>
                <div class="input-field" id="email">
                    <i class="fa fa-envelope"></i>
                    <input type="text" placeholder="Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" oninput="setupTypingTimer()" onkeydown="resetTypingTimer()">
                    <span id="email-result"></span><br>
                </div>
                <div id="email-error" class="error"></div>
            </form>

            <iframe name="hidden-iframe" class="hidden-iframe"></iframe>

            <form id="form" action="" method="post" onsubmit="transferData(); return validate();">
                <div class="input-group">
                    <input type="hidden" name="username">
                    <input type="hidden" name="phone">
                    <input type="hidden" name="email">
                    <input type="hidden" name="full_name">
                    <div class="input-field" id="password">
                        <i class="fa fa-lock"></i>
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    <div id="password-error" class="error"></div>
                    <p>Already have an account? <a href="login.php">Click here</a></p>
                    <button class="btn-field" name="register" type="submit" id="registerBtn">Register</button>

                </div>
            </form>
        </div>
    </div>
</body>

</html>