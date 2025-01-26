<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'admin/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_pass = $_POST['password'];
    
    // Hash the input password using md5
    $hashed_input_pass = md5($input_pass);
    
    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();
    
    $hashed_password == 'password';
    
    
    // Check if the user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();
        
        // Verify the entered password with the hashed password
        if ($hashed_input_pass === $hashed_password) {
            // Login successful
            echo "Login successful";
            $_SESSION['username'] = $input_username;
            $_SESSION['user_id'] = $user_id;
            if(isset($_SESSION['returnUrl'])) {
                $returnURL = $_SESSION['returnUrl'];
                $_SESSION['returnUrl'] = "";
                header("Location:".$returnURL);
                die();
            }
            header("Location: index.php");
        } else {
            // Invalid password
            $error = "Invalid Password.";
            header("Location: login.php?error=" . urlencode($error));
        }
    } else {
        // User not found
        $error = "Invalid Username.";
        header("Location: login.php?error=" . urlencode($error));
    }
    
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Sign In Form</title>
    <link rel="stylesheet" href="css/registercss.css">
    <link rel="stylesheet" href="https:/cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .error {
            color: red;
            font-size: 14px;
        }

        p {
            padding-top: 10px;
        }
    </style>
    <script>
        function validate() {
            let isValid = true;

            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;

            // Validate username
            if (username.length < 3) {
                displayError('username-error', 'Username must be at least 3 characters long');
                isValid = false;
            } else {
                clearError('username-error');
            }
            // Validate password
            if (password.length < 6) {
                displayError('password-error', 'Password must be at least 6 characters long');
                isValid = false;
            } else {
                clearError('password-error');
            }

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
    </script>
</head>

<body>
    <div class="container">
        <div class="form-box-login">
            <h1 id="title">Login</h1>
            <form method="POST" id="form" onsubmit="return validate()" action="login.php">
                <?php if (isset($_GET['error'])): ?>
                    <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
                <?php endif; ?>
                <div class="input-field" id="username">
                    <i class="fa fa-user"></i>
                    <input type="text" id="username" placeholder="Username" name="username" required>
                </div>
                <div id="username-error" class="error"></div>
                <div class="input-field" id="password">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" placeholder="Password" name="password">
                </div>
                <div id="password-error" class="error"></div>
                <p> Doesn't have an account? <a href="register.php">Click Here!</a></p>
                <button class="btn-field" type="submit" id="loginBtn">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
