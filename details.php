<?php require_once 'components/head.php'; ?>
<?php require_once 'components/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    if (isset($_GET['location'])) {
        $location = $_GET['location'];

        // Sample data for demonstration
        $hotelDetails = [
            'Kathmandu' => [
                'image' => 'images/kathmandu-hotel.jpg',
                'description' => 'A beautiful hotel in Kathmandu.',
                'address' => '123 Kathmandu St, Kathmandu, Nepal'
            ],
            'Bhaktapur' => [
                'image' => 'images/bhaktapur-hotel.jpg',
                'description' => 'A cozy hotel in Bhaktapur.',
                'address' => '456 Bhaktapur St, Bhaktapur, Nepal'
            ],
            'Pokhara' => [
                'image' => 'images/pokhara-hotel.jpg',
                'description' => 'A serene hotel in Pokhara.',
                'address' => '789 Pokhara St, Pokhara, Nepal'
            ],
            'Mustang' => [
                'image' => 'images/mustang-hotel.jpg',
                'description' => 'A mountain hotel in Mustang.',
                'address' => '101 Mustang St, Mustang, Nepal'
            ],
            'Illam' => [
                'image' => 'images/illam-hotel.jpg',
                'description' => 'A green hotel in Illam.',
                'address' => '102 Illam St, Illam, Nepal'
            ]
        ];

        if (array_key_exists($location, $hotelDetails)) {
            $details = $hotelDetails[$location];
            echo "
                <h2>Hotels in $location</h2>
                <div class='hotel'>
                    <img src='{$details['image']}' alt='$location Hotel'>
                    <p><strong>Description:</strong> {$details['description']}</p>
                    <p><strong>Address:</strong> {$details['address']}</p>
                </div>
            ";
        } else {
            echo "<p>Location not found.</p>";
        }
    } else {
        echo "<p>No location specified.</p>";
    }
    ?>
</body>

</html>

<?php require_once 'components/footer.php'; ?>