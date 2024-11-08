<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $user_data =check_login($con);

    $query="select * from zeli_res where res_featured=1 order by rand() limit 4";
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

  <style>
    .header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem 2rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid #ddd;
}

.header-left {
  display: flex;
  align-items: center;
}

.logo {
  height: 40px;
  margin-right: 2rem;  
}

.nav-links {
  display: flex;
  gap: 1.5rem;
}

.nav-link {
  position: relative;
  text-decoration: none;
  font-weight: bold;
  color: #343a40;
  font-size: 1rem;
  transition: color 0.3s;
}

.nav-link:hover {
  color: #ff5a5f; 
}
 
.nav-link::after {
  content: '';
  position: absolute;
  bottom: -3px;
  left: 0;
  width: 100%;
  height: 2px;
  background-color: #ff5a5f;
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.3s ease;
}

.nav-link:hover::after {
  transform: scaleX(1);
}
  </style>
</head>
<body>
  <header class="header">
    <div class="header-left">
        <img src="images/logo.png" alt="Restaurant Logo" class="logo">
    </div>
    <div class="nav-links">
        <a href="home.php" class="nav-link">Home</a>
        <a href="allfood.php" class="nav-link">Food</a>
        <a href="allrestaurant.php" class="nav-link">Restaurant</a>
      </div>
    <div class="header-right">
    <button onclick="location.href='myorders.php'"class="my-orders-btn">My Orders</button>
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
      <div class="box" onclick="redirectToRes('<?php echo $row['res_id'];?>')">
        <img src="images/<?php echo $row['res_img'];?>" alt="Pizza" class="food-thumbnail">
        <div class="text-placeholder"><?php echo $row['res_name'];?></div>
      </div>

    <?php
    }
    ?>
    </div>
  
  <script src="utils/popup.js"></script>
</body>
</html>
