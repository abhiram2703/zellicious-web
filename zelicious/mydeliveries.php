<?php
     session_start();
     include("connection.php");
     include("functions.php");
 
     $porter_data =check_porter_login($con);

     $porter_id=$_SESSION['porter_id'];
     $query="select * from zeli_orders where porter_id='$porter_id'";
     $res=mysqli_query($con, $query);
     $order_data=mysqli_fetch_assoc($res);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Orders</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700&display=swap">
  <style>

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Manrope', sans-serif;
    }
    
    body {
      background-color: #f9f9f9;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }

    /* Header Styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: #f8f9fa;
      border-bottom: 1px solid #ddd;
      width: 100%;
      max-width: 1200px;
    }

    .header-left .logo {
      height: 40px;
    }

    .header-right {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .user-id {
      font-size: 1rem;
      font-weight: bold;
      color: #333;
    }

    .logout-btn {
      background-color: #ff5a5f;
      color: #fff;
      border: none;
      padding: 0.5rem 1rem;
      cursor: pointer;
      border-radius: 4px;
    }

    /* Order Card Styles */
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 20px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 16px;
    }

    .order-card {
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 16px;
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s;
    }

    .order-card:hover {
      transform: scale(1.05);
    }

    .restaurant-name {
      font-weight: bold;
      font-size: 1.2em;
      color: #333;
      margin-bottom: 0.5em;
    }

    .food-name {
      font-size: 1em;
      color: #555;
      margin: 0.5em 0;
    }

    .quantity, .price {
      font-size: 0.9em;
      color: #777;
    }

    .price {
      font-weight: bold;
      color: #333;
      margin-top: 0.5em;
    }
    .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-id {
            font-size: 1rem;
            font-weight: bold;
            color: #333;
        }

    .logout-btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .my-orders-btn {
            background-color: #f9f9f9;
            color: #000;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border: 1px solid #000;
            border-radius: 4px;
            font-weight: bold;
        }

        /* Additional hover effect for both buttons */
        .logout-btn:hover {
            background-color: #e04a4e; /* Slightly darker shade */
        }

        .my-orders-btn:hover {
            background-color: #000;
            color: #f9f9f9;
        }
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
        <div class="nav-links">
            <a href="porter-home.php" class="nav-link">Home</a>
            <a href="porter-accept.php" class="nav-link">Accept</a>
        </div>
    </div>
    <div class="header-right">
        <button class="my-orders-btn">My Deliveries</button>
        <div class="user-id">Hi, <?php echo $porter_data['porter_name']; ?></div>
        <button onclick="location.href='porter-logout.php'" class="logout-btn">Logout</button>
    </div>
</header>

  <!-- Page Content -->
  <div class="container">
    <?php
        while($row=mysqli_fetch_assoc($res)){
            $food_id=$row['food_id'];
            $query="select * from zeli_foods where food_id='$food_id' limit 1";
            $food_d=mysqli_query($con, $query);
            $food_data=mysqli_fetch_assoc($food_d);

            $res_id=$food_data['res_id'];
            $query="select * from zeli_res where res_id='$res_id' limit 1";
            $res_d=mysqli_query($con, $query);
            $res_data=mysqli_fetch_assoc($res_d);
    ?>
    <div class="order-card">
      <div class="restaurant-name"><?php echo $res_data['res_name'];?></div>
      <div class="food-name">Food Item: <?php echo $food_data['food_name'];?></div>
      <div class="quantity">Quantity: <?php echo $row['food_quantity'];?></div>
      <div class="price">Price: $<?php echo $row['order_price'];?></div>
      <div class="price">Status: <?php echo $row['order_status'];?></div>
    </div>
    
    <?php
        }
    ?>
  </div>

</body>
</html>
