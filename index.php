<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Responsive Tour and Travel Agency Website Design </title>

 <!-- swiper cdn link -->
 <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

 <!-- font awesome cdn link  -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

 <!-- custom css file link  -->
 <link rel="stylesheet" href="styles.css">

</head>

<body>
<!-- header section starts -->


<header>

  <div id="menu-bar" class="fas fa-bars"></div>

  <a href="#" class="logo">
    <span>T</span>ravel
    <span>A</span>tlas
  </a>
  
  <nav class="navbar">
    <a href="#home">home</a>
    <a href="#book">book now</a>
    <a href="#packages">packages</a>
    <a href="#services">services</a>
    <a href="#gallery">gallery</a>
    <a href="displaybookings.php">my bookings</a>
    <a href="display.php?id=<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : ''; ?>">my profile</a>

</nav>


  <div class="icons">
   
  </div>


</header>

<!-- header section ends    -->

<!-- login form container -->

<div class="login-form-container">

  <i class="fas fa-times" id="form-close"></i>

  <form action="">
    <h3>login</h3>
    <input type="email" class="box" placeholder="Email">
    <input type="password" class="box" placeholder="Password">
    <input type="submit" value="login now" class="btn">
    <input type="checkbox" id="remember">
    <label for="remember">remember me</label>
    <p>forget password? <a href="#">click here</a></p>
    <p>don't have an account? <a href="#">register now</a></p>
  </form>
</div>

<!-- home section starts -->

<section class="home" id="home">
  <div class="content">
    <h3>adventure is worthwhile</h3><br><br>
    <p>discover new places with us, adventure awaits</p><br>
    <a href="#packages" class="btn">discover more</a>
  </div>

 

  <div class="video-container">
    <video src="Images/start.mp4" id="video-slider" loop autoplay muted></video>
  </div>

</section> 

<!-- home section ends --> 


<!-- book section starts -->
<section class="book" id="book">
  <h1 class="heading">
    <span>b</span>
    <span>o</span>
    <span>o</span>
    <span>k</span>
    <span class="space"></span>
    <span>n</span>
    <span>o</span>
    <span>w</span>
  </h1>

  <div class="row">
    <div class="image">
      <img src="https://img.freepik.com/premium-vector/travelling-illustration_294101-316.jpg?w=2000" alt="">
    </div>
    <form action="takebookings.php" method="POST">
      <div class="inputBox">
        <h3>where to</h3>
        <input list="destination" name="destination" placeholder="Select">
        <datalist id="destination">
          <option value="Mumbai">Mumbai</option>
          <option value="Hawaii">Hawaii</option>
          <option value="Sydney">Sydney</option>
          <option value="Belfast">Belfast</option>
          <option value="Tokyo">Tokyo</option>
          <option value="Egypt">Egypt</option>
        </datalist>
      </div>
      <div class="inputBox">
        <h3>how many</h3>
        <input type="number" name="guests" placeholder="Number of Guests">
      </div>
      <div class="inputBox">
        <h3>arrivals</h3>
        <input type="date" name="arrival_date">
      </div>
      <div class="inputBox">
        <h3>leaving</h3>
        <input type="date" name="departure_date">
      </div>
      <input type="submit" class="btn" value="book now">
    </form>
  </div>
</section>


<!-- book section ends -->


<!-- packages section starts -->



<section class="packages" id="packages">

  <h1 class="heading">
    <span>p</span>
    <span>a</span>
    <span>c</span>
    <span>k</span>
    <span>a</span>
    <span>g</span>
    <span>e</span>
    <span>s</span>
  </h1>

  <div class="box-container">

    <div class="box">
      <img src="images/p-1.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> mumbai </h3>
        <p>Experience the Gateway of India and bustling streets of India's financial capital. Rich in culture, cuisine, and Bollywood glamour.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 1200.00 <span>₹ 2000.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

    <div class="box">
      <img src="images/p-2.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> hawaii </h3>
        <p>Pristine turquoise waters surrounded by majestic Rocky Mountains. Perfect for canoeing and experiencing breathtaking Alpine scenery.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 22000.00 <span>₹ 30000.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

    <div class="box">
      <img src="images/p-3.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> sydney </h3>
        <p>Modern skyline meets historic charm in Australia's largest city. Explore vibrant neighborhoods, iconic architecture, and world-class entertainment.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 15700.00 <span>₹ 21500.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

    <div class="box">
      <img src="images/p-4.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> belfast </h3>
        <p>Discover Northern Ireland's historic capital, with its grand Victorian architecture, rich maritime heritage, and dynamic cultural scene.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 14300.00 <span>₹ 20500.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

    <div class="box">
      <img src="images/p-5.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> tokyo </h3>
        <p>Discover Northern Ireland's historic capital, with its grand Victorian architecture, rich maritime heritage, and dynamic cultural scene.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 16500.00 <span>₹ 26990.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

    <div class="box">
      <img src="images/p-6.jpg" alt="">
      <div class="content">
        <h3> <i class="fas fa-map-marker-alt"></i> egypt </h3>
        <p>Marvel at the ancient Pyramids of Giza, timeless wonders of human ingenuity. Explore 4,500 years of history in the shadow of these magnificent royal tombs.</p>
        <div class="stars">
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="fas fa-star"></i>
          <i class="far fa-star"></i>
        </div>
        <div class="price"> ₹ 17500.00 <span>₹ 29500.00</span> per person</div>
        <a href="#book" class="btn">book now</a>
      </div>
    </div>

  </div>

</section>
<!-- packages section ends -->


<!-- services section starts -->
<section class="services" id="services">

  <h1 class="heading">
    <span>s</span>
    <span>e</span>
    <span>r</span>
    <span>v</span>
    <span>i</span>
    <span>c</span>
    <span>e</span>
    <span>s</span>
  </h1>

  <div class="box-container">

    <div class="box">
      <i class="fas fa-hotel"></i>
      <h3>affordable hotels</h3>
      <p>"Find comfortable, budget-friendly accommodations worldwide. We carefully select hotels that offer the best value without compromising on quality and comfort."</p>
    </div>
    <div class="box">
      <i class="fas fa-utensils"></i>
      <h3>food and drinks</h3>
      <p>"Savor local cuisines and culinary experiences at every destination. From street food to fine dining, discover the authentic flavors of each region."</p>
  
    </div>
    <div class="box">
      <i class="fas fa-bullhorn"></i>
      <h3>safety guide</h3>
      <p>"Travel with confidence using our comprehensive safety tips and local insights. Stay informed with real-time updates and expert advice for worry-free exploration."</p>
    </div>
    <div class="box">
      <i class="fas fa-globe-asia"></i>
      <h3>around the world</h3>
      <p>"Explore diverse destinations across continents. From iconic landmarks to hidden gems, experience the world's most fascinating places and cultures."</p>
    </div>
    <div class="box">
      <i class="fas fa-plane"></i>
      <h3>fastest travel</h3>
      <p>"Get to your destination efficiently with optimized travel routes and connections. Save time with smart itineraries and seamless transportation options."</p>
    </div>
    <div class="box">
      <i class="fas fa-hiking"></i>
      <h3>adventures</h3>
      <p>"Embark on thrilling experiences tailored to every adventurer. Whether hiking, diving, or cultural exploration, find your perfect adventure with us."</p>
    </div>
  </div>
</section>

<!-- services section ends -->

<!-- gallery section starts -->

<section class="gallery" id="gallery">

  <h1 class="heading">
    <span>g</span>
    <span>a</span>
    <span>l</span>
    <span>l</span>
    <span>e</span>
    <span>r</span>
    <span>y</span>
  </h1>

  <div class="box-container">

    <div class="box">
      <img src="images/g-1.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy scenic beauty.</p>
        <a href="https://youtu.be/cOa97mBh8co?si=8czHaA7lRRYN6O5M" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-2.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy camping</p>
        <a href="https://youtu.be/MmNvkxIaJvs?si=y58iLqxzHidrTTpt" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-3.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy hiking</p>
        <a href="https://youtu.be/2fQZcnSvf-g?si=AtsGNm1Io7qOrknj" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-4.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy visiting gems</p>
        <a href="https://youtu.be/ufOykYSswCk?si=6-hse5Rm4pL_4wLJ" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-5.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy photography</p>
        <a href="https://youtu.be/5fL6BqAHGyY?si=I-iRESpSUkWNw5YW" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-6.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy diving</p>
        <a href="https://youtu.be/5fL6BqAHGyY?si=I-iRESpSUkWNw5YW" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-7.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy sunsets</p>
        <a href="https://youtu.be/rzOHlHqfVHQ?si=dSul4N-p8BHIE-Lg" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-8.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy uniqueness of their beauty</p>
        <a href="https://youtu.be/KitENxyT0t0?si=dwhhBKC7dIRx_aPJ" target="_blank" class="btn">see more</a>
      </div>
    </div>
    <div class="box">
      <img src="images/g-9.jpg" alt="">
      <div class="content">
        <h3>amazing places</h3>
        <p>Check out some amazing places where you can enjoy with your family</p>
        <a href="https://youtu.be/nb-In2qHyc4?si=73Qq1g9g1RX_HOMZ" target="_blank" class="btn">see more</a>
      </div>
    </div>

  </div>

</section>


<!-- gallery section ends -->








<!-- footer section starts -->

<section class="footer">

  <div class="box-container">

    <div class="box">
      <h3>about us</h3>
      <p>Welcome to Travel Atlas! I’m here to simplify your travel planning—providing destination tips, booking support, and personalized recommendations. Let’s make your next adventure unforgettable!</p>
    </div>
    <div class="box">
      <h3>branch locations</h3>
      <a href="#">india</a>
      <a href="#">USA</a>
      <a href="#">japan</a>
      <a href="#">france</a>
      <a href="#">UK</a>
    </div>
    <div class="box">
      <h3>quick links</h3>
      <a href="#home">home</a>
      <a href="#book">book</a>
      <a href="#packages">packages</a>
      <a href="#services">services</a>
      <a href="#gallery">gallery</a>

    </div>
    <div class="box">
      <h3>follow us</h3>
      <a href="#">instagram</a>
      <a href="#">twitter</a>
      <a href="#">linkedin</a>
    </div>
  </div>
  <h1 class="credit"> created by <span> Adrian </span> | all rights reserved! </h1>
</section>

<!-- footer section ends -->

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file link -->
<script src="script.js"></script>
<script>
window.embeddedChatbotConfig = {
chatbotId: "U53V2aWgaBJzvY5IYWzuI",
domain: "www.chatbase.co"
}
</script>
<script>
window.embeddedChatbotConfig = {
chatbotId: "U53V2aWgaBJzvY5IYWzuI",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="U53V2aWgaBJzvY5IYWzuI"
domain="www.chatbase.co"
defer>
</script>

</body>
</html>