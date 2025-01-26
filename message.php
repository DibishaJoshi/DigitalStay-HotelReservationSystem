<?php
require_once 'components\header.php';
require_once 'components\head.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            /* display: ; */
            justify-content: center;
            align-items: center;
            /* height: 500vh; */
            margin: 0;
        }

        /* Container */
        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
             /* Full viewport height */
            padding: 20px;
        }

        .success-box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 40px 20px;
            max-width: 400px;
            width: 100%;
        }

        /* Icon */
        .icon {
            margin-bottom: 20px;
        }

        .checkmark {
            width: 80px;
            height: 80px;
            stroke: #4CAF50;
            stroke-width: 3;
            animation: draw 1s ease-in-out forwards;
        }

        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: dash 1s ease-in-out forwards;
        }

        .checkmark-check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: dash-check 1s 0.5s ease-in-out forwards;
        }

        @keyframes dash {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes dash-check {
            to {
                stroke-dashoffset: 0;
            }
        }
        .success-container .success-box p{
            padding: 5px;
            margin: 5px;
            box-sizing: border-box;
        }

        /* Heading and Paragraph */
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
            margin-top: 20px;
            padding-top: 10px;
        }

        /* Button */
        .button {
            display: inline-block;
            text-decoration: none;
            background:rgb(34, 102, 239);
            color: #fff;
            padding: 10px 20px;
            margin: 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background 0.3s;
        }

        .button:hover {
            background:rgb(84, 103, 172);
        }
    </style>
</head>
<body>
<?php
if (isset($_SESSION['transaction_msg'])) {
    echo $_SESSION['transaction_msg'];
    unset($_SESSION['transaction_msg']);
}
?>
    <div class="success-container">
        <div class="success-box">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="checkmark" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark-check" fill="none" d="M14 27l7.8 7.8L38 17"/>
                </svg>
            </div>
            <h1>Payment Successful!</h1>
            <p>Thank you for your payment. Your transaction has been completed successfully.</p>
            <a href="booking_history.php" class="button">View Booking History</a>
        </div>
    </div>
</body>
</html>

<?php require_once 'components\footer.php'; ?>
