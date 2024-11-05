<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $user_data =check_login($con);

    $query="select res_name,res_img from zeli_res where res_featured=1 order by rand() limit 4";
    $topres=mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Homepage</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Roboto:wght@300;400;700&display=swap">
  <link rel="stylesheet" href="utils/testhome.css">
</head>
<body>
  <header class="header">
    <div class="header-left">
        <img src="images/logo.png" alt="Restaurant Logo" class="logo">
    </div>
    <div class="header-right">
    <button class="my-orders-btn">My Orders</button>
      <div class="user-id">Hi, <?php echo $user_data['user_name']; ?></div>
      <button onclick="location.href='logout.php'" class="logout-btn">Logout</button>
    </div>
  </header>
  
  <div class="homepage-container">
    <h2 class="catchphrase">Order food from the comfort of your home!</h2>
    
    <!-- Horizontal Lines -->
    <div class="horizontal-lines">
      <hr class="line">
      
      <!-- News Carousel -->
      <div class="news-carousel">
        <p> 'FLAT10' FOR 10% DISCOUNT ON ORDERS ABOVE 599 || FREE DELIVERY ON FIRST ORDER || FREE BEVERAGES ON ORDERS ABOVE 999 || 'BR15' FOR 15% DISCOUNT ON ORDERING FROM BRANZOS</p>
      </div>
      
      <hr class="line">
    </div>
    
    
    <h2 class="top-foods-heading">Top Categories</h2>
    <div class="grid-container-1x4">
      <div class="food-box" onclick="redirectToFood('Starters')">
        <img src="images/section1img1.jpg" alt="Starters" class="food-image">
        <h3>Starters</h3>
      </div>
      <div class="food-box" onclick="redirectToFood('Main Course')">
        <img src="images/section1img2.jpg" alt="Main Course" class="food-image">
        <h3>Main Course</h3>
      </div>
      <div class="food-box" onclick="redirectToFood('Beverages')">
        <img src="images/section1img3.jpg" alt="Beverages" class="food-image">
        <h3>Beverages</h3>
      </div>
      <div class="food-box" onclick="redirectToFood('Desserts')">
        <img src="images/section1img4.jpg" alt="Desserts" class="food-image">
        <h3>Desserts</h3>
      </div>
    </div>
    
    <h2 class="top-restaurants-heading">Top Restaurants</h2>
    <div class="grid-container">
    <?php
    while($row=mysqli_fetch_assoc($topres))
    {
    ?>
      <div class="box" onclick="openPopup('Restaurant 1')">
        <img src="images/<?php echo $row['res_img'];?>" alt="Pizza" class="food-thumbnail">
        <div class="text-placeholder"><?php echo $row['res_name'];?></div>
      </div>

    <?php
    }
    ?>
    </div>
    <div id="popup" class="popup">
      <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2 id="restaurant-name">Restaurant Name</h2>
        <div id="menu-items"></div>
      </div>
    </div>
  </div>
  
  <script src="utils/popup.js"></script>
</body>
</html>
