<!DOCTYPE html>
<html lang="en">
  <style>
    #payment{
    
    background: var(--color2);
    text-align: center;
    padding-top: 5vh;
    padding-bottom: 5vh;
}

.payment-heading{
    font-size: 2.8rem;
    padding-bottom: 3vh;
}
.payment-div{
    padding-inline: 2px;
}

.payment-logo{
    max-width: 180px;
    width: 180px;
    max-height: 90px;
    height: 90px;
    border: 1px solid black;
}

  </style>
    <?php require_once 'components/head.php'; ?>
    <body>
    <?php require_once 'components/header.php'; ?>
    <header class="header" id="home">
      <div class="section__container header__container">
        <p class="section__subheader">ABOUT US</p>
        <h1>The Perfect<br/>Base For You</h1>
      </div>
    </header>
    <section class="about" id="about">
      <div class="section__container about__container">
        <div class="about__grid">
          <div class="about__image">
            <img src="assets/booking.jpg" alt="about" />
          </div>
          <div class="about__card">
            <span><i class="ri-user-line"></i></span>
            <h4>Easy Booking</h4>
              <p>
                Allows you to search, compare, and book accommodation effortless
              </p>
          </div>
          <div class="about__image">
                      <img src="assets/secure.jpg" alt="about" />
                    </div>
                    <div class="about__card">
                      <span><i class="ri-calendar-check-line"></i></span>
                      <h4>Secure and Reliable</h4>
                      <p>Advanced encryption technology safeguarding your personal information and transaction</p>
                    </div>
                  </div>
                  <div class="about__content">
                    <p class="section__subheader">ABOUT US</p>
                    <h2 class="section__header">Welcome to DigitalStay</h2>
                    <p class="section__description">
                        We strive to make your travel experience seamless and enjoyable.
                        Our mission is to provide you with a hassle-free booking experience, 
                        offering a wide range of hotels, resorts, and vacation rentals to suit 
                        every traveler's preferences and budget. With our user-friendly platform, 
                        you can easily search, compare, and book accommodations at your fingertips.
                    </p>
                    <button onclick="window.location.href='about.php'"class="btn">About us</button>
                  </div>
                </div>
    </section>
  
  
    <script src="script.js"></script> 
    <?php require_once 'location.php'; ?>
    
    <?php require_once 'components/footer.php'; ?>
    </body>
</html>