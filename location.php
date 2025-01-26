<section id="location-container">
    <header class="head">
        <h1>BROWSE BY LOCATION</h1>
    </header>
    <main>
        <div class="locations" id="locations">
        <div class="location" >
    <main id="location-list">
        <?php
        include 'admin/db_connect.php';
        
        $sql = "SELECT name, image FROM location";
        $result = $conn->query($sql);
        
        $locations = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $locations[] = $row;
            }
        }
        foreach ($locations as $location) {
            echo '<div class="location-card" onclick="window.location.href=\'fetch_hotel.php?location=' . urlencode($location['name']) . '\'">';
            echo '<img src="admin/' . $location['image'] . '" alt="' . $location['name'] . '">';
            echo '<p>' . $location['name'] . '</p>';
            // echo '<button type="button" class="fetch-hotel-btn">Explore Hotels</button>';
            echo '</div>';
        }
        
        ?>
    </main>
    </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationCards = document.querySelectorAll('.location-card');
            locationCards.forEach(card => {
                card.addEventListener('click', function() {
                    const location = this.querySelector('p').innerText;
                    window.location.href = `fetch_hotel.php?location=${location}`;
                });
            });
        });
    </script>