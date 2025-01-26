<!DOCTYPE html>
<html lang="en">
    <?php require_once 'components/head.php'; ?>
    <body>
    <?php require_once 'components/header.php'; ?>
    <head>
      <style type="text/css">
        body, h1, p {
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #4CAF50;
    color: white;
    padding: 20px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-size: 2.5em;
}

main {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}



.section__description {
    margin-bottom: 20px;
    line-height: 1.8;
    color: #555;
}

.section__description p {
    margin-bottom: 20px;
    text-align: justify;
}

.section__description p:last-child {
    margin-bottom: 0;
}
.hero {
    background-image:linear-gradient(
        rgba(138, 56, 119, 0.5),
        rgba(233, 233, 233, 0.5)
      ) ,url('assets/about-bg.jpg') ;
    color: #fff;
    padding: 5rem 0;
    text-align: center;
    height:800px;
}

.hero h1 {
    font-size: 3rem;
    padding-top:200px
}
.hero p{
    font-size: large;
    color: white;
}
.container {
    width: 80%;
    margin: 0 auto;
    padding: 2rem 0;
}

.mission-vision, .our-story, .team, .values {
    padding: 2rem 0;
    border-bottom: 1px solid #ccc;
    /* background-image: linear-gradient(white,black); */
}

.mission-vision .container {
    display: flex;
    justify-content: space-between;
    text-align: center;
}

.mission-vision .container div {
    width: 45%;
}
.mission-vision .container img{
    width: 100px;
}
.mission-vision .container .vision img {
    width:200px;
}
.about__content{
    background-image: linear-gradient(rgb(147, 147, 204),rgb(238, 200, 206));
}
</style>
</head>
    <section class="hero">
            <h1>About DigitalStay</h1>
            <p>Your comfort, our priority.</p>
        </section>

        <section class="mission-vision">
            <div class="container">
                <div class="mission">
                    <h2>Our Mission</h2>
                    <img src="images/mission.png" alt="mission image">
                    <p>At DigitalStay, our mission is to provide unparalleled hospitality services through innovative technology and exceptional customer service.</p>
                </div>
                <div class="vision">
                    <h2>Our Vision</h2>
                    <img src="images/vision.png" alt="vision image" class="vision">
                    <p>We envision a world where every traveler experiences seamless and personalized stays through cutting-edge digital solutions.</p>
                </div>
            </div>
        </section>
      <div class="about__content">
        <p class="section__description">
        <p>
        Welcome to Digital Stay, your premier destination for hassle-free online hotel reservations. 
        At Digital Stay, we understand the importance of seamless travel experiences, and that starts 
        with finding the perfect place to stay. Whether you're planning a business trip, a romantic 
        getaway, or a family vacation, we're here to make booking your accommodations as simple as a few clicks.
        </p>
        <p>
        Our mission is to revolutionize the way you plan your travels by offering a user-friendly platform that 
        puts the power of choice in your hands. With access to an extensive network of hotels worldwide, we strive 
        to provide you with a diverse range of options to suit every budget and preference. From luxury resorts to 
        cozy boutique hotels, we've got you covered.
        </p>
        <p>
        What sets us apart is our commitment to customer satisfaction. Our team works tirelessly to ensure that your 
        booking experience is smooth, secure, and tailored to your needs. Whether you have questions about a specific 
        property or need assistance with your reservation, our dedicated support staff is here to help every step of the way.
        </p>
        <p>
        At Digital Stay, we believe that your journey should be as enjoyable as your destination. That's why we're constantly 
        innovating and improving our platform to enhance your overall travel experience. Join us and discover a new way to plan 
        your next adventure with ease and convenience. Welcome to the future of hotel reservations—welcome to Digital Stay.
        </p></p>
        
    </div>
    </section>
    
    <?php require_once 'components/footer.php'; ?>
            <script src="script.js"></script> 
    </body>
</html>