<?php
    include 'admin/db_connect.php';

    // Insert Data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $messages = $_POST['messages'];
        

        $sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$messages')";

        if (mysqli_query($connection, $sql)) {
            header("Location:contact.php?message=Message added successfully");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($connection);
        }
        $conn->close();
    }
    
    
   
    ?>
<?php require_once 'components/head.php'; ?>

    <?php require_once 'components/header.php'; ?>
<section class="contact-container">
        
        <form class="contact-form" action="" method="POST">
        <?php
        if (isset($_GET['message'])) {
            echo '<div class="success-message">' . htmlspecialchars($_GET['message']) . '</div>';
        }
        ?>
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="messages" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
       
</section>

<?php require_once 'components/footer.php'; ?>

    