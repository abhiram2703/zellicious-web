<?php
  session_start();
  include("connection.php");
  include("functions.php");
  
  if (isset($_POST['submit'])) 
  {
    $restaurant_id = $_POST['res_id'];
    $restaurant_password = $_POST['res_password'];
  
    // Validation
    if (!empty($restaurant_id) && !empty($restaurant_password)) 
    {
      // read from database
      
      $query = "select * from zeli_res where res_id='$restaurant_id' limit 1";
      $result=mysqli_query($con, $query);
  
      if($result)
      {
        if($result && mysqli_num_rows($result)>0)
        {
          $res_data = mysqli_fetch_assoc($result);
          if($res_data['res_password']==$restaurant_password)
          {
            echo "right";
            $_SESSION['res_id']= $res_data['res_id'];
            header("Location: restauranthome.php");
            die;
          }
        }
      }
      echo "Wrong Email or Password!";
    } 
    else 
    {
      echo "Wrong Email or Password!";
    }
  
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body, html {
      height: 100%;
      font-family: Arial, sans-serif;
    }

    .container {
      display: flex;
      height: 100vh;
    }

    .section1, .section2 {
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .section1 {
      width: 30%;
    }

    .section2 {
      width: 70%;
    }

    img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .form-container {
      background-color: transparent;
      border: 2px solid white;
      border-radius: 10px;
      padding: 2rem;
      width: 300px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      position: relative;
      z-index: 2;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 2px solid white;
      border-radius: 5px;
      background-color: transparent;
      color: white;
      font-size: 16px;
      font-weight: normal;
    }

    input::placeholder {
      color: white;
      opacity: 0.8;
    }

    button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      background-color: transparent;
      color: white;
      border: 2px solid white;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-size: 16px;
      font-weight: normal;
    }

    button:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    .back-button {
      background-color: transparent;
      border: 2px solid white;
      color: white;
    }

    .back-button:hover {
      background-color: rgba(255, 255, 255, 0.2);
      color: black;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="section1">
      <img src="images/restimg1.jpg" alt="Restaurant Login Left Background">
    </div>
    <div class="section2">
      <img src="images/indeximg2.jpg" alt="Restaurant Login Right Background">
      <div class="form-container">
        <form id="restaurantLoginForm" method="post">
          <input type="text" id="restaurantId" name="res_id" placeholder="Restaurant ID" required>
          <input type="password" id="restaurantPassword" name="res_password" placeholder="Password" required>
          <button type="submit" name="submit">Login</button>
          <button type="button" onclick="location.href='index.php'" class="back-button">Back</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

