<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $user_data =check_login($con);
    
    $query="select * from zeli_res";
    $allres=mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="utils/testhome.css">
    <title>Bento Box Design</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
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

        /* Button Styles */
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


        .nameontop{
         max-width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    
            gap: 15px;
        }
        .bento-box {
            max-width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row; 
            flex-wrap:wrap ; 
            gap: 15px;
        }

        .food-item {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .food-image {
            width: 200px;
            height: 200px;
            border-radius: 8px;
        }

        .food-details {
            flex-grow: 1;
            padding: 0 15px;
            flex-direction:row;
        }

        .order-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .order-button:hover {
            background-color: #218838;
        }

        .unavailable-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: not-allowed;
        }

        .popup {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .popup-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 350px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, opacity 0.3s ease;
            transform: translateY(-20px);
            opacity: 0;
        }

        .popup.active .popup-content {
            transform: translateY(0);
            opacity: 1;
        }

        .close-button {
            cursor: pointer;
            font-size: 20px;
            float: right;
            color: #333;
            transition: color 0.3s;
        }

        .close-button:hover {
            color: #dc3545;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input[type="number"],
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            margin-top: 15px;
            padding: 10px 15px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
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
.nameontop{
         max-width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    
            gap: 15px;
        }

    .box{
  flex-direction: column;
  align-items: center;
  width:230px;
}
.food-thumbnail{
  width:230px;
  height: 230px; 
  object-fit: cover; 
  border-radius: 8px; 
  object-position: center;
}
.bento-box {
            max-width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row; 
            flex-wrap:wrap ; 
            gap: 15px;
        }
</style>
</head>
<body>
  <header class="header">
    <div class="header-left">
        <img src="images/logo.png" alt="Restaurant Logo" class="logo">
        <div class="nav-links">
        <a href="home.php" class="nav-link">Home</a>
        <a href="allfood.php" class="nav-link">Food</a>
        <a href="allrestaurant.php" class="nav-link">Restaurant</a>
      </div>
    </div>
    
    <div class="header-right">
    <button onclick="location.href='myorders.php'"class="my-orders-btn">My Orders</button>
      <div class="user-id">Hi, <?php echo $user_data['user_name']; ?></div>
      <button onclick="location.href='logout.php'" class="logout-btn">Logout</button>
    </div>
  </header>
  <div class="nameontop">
    <h1>Restaurants</h1>
    </div>
    <div class="bento-box">
  <?php
    while($row=mysqli_fetch_assoc($allres))
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
    <script>
        function redirectToRes(resid) {
            window.location.href = 'restau.php?resid=' + encodeURIComponent(resid);
        }
    </script>
</body>
</html>
