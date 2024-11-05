<?php
session_start();
include("connection.php");
include("functions.php");

if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];
    $user_email = $_POST['user_email'];
    $user_address = $_POST['user_address'];


    // Validation
    if (!empty($user_name) && !empty($user_password) && !empty($user_email) && !empty($user_address) && !is_numeric($user_name)) 
    {
        // Save to database
        $user_id = random_num(10);
        
        $query = "insert into zeli_users (user_id, user_name, user_email, user_password, user_address) values ('$user_id', '$user_name', '$user_email', '$user_password', '$user_address')";
        mysqli_query($con, $query);

        header("Location: login.php");
        die;

    } 
    else 
    {
        echo "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
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
      <img src="images/userreg1.jpg" alt="User Registration Left Background">
    </div>
    <div class="section2">
      <img src="images/indeximg2.jpg" alt="User Registration Right Background">
      <div class="form-container">
          <form id="userRegisterForm" action="" method="post">
            <input type="text" name="user_name" placeholder="Full Name" required>
            <input type="email" name="user_email" placeholder="Email" required>
            <input type="password" name="user_password" placeholder="Password" required>
            <input type="text" name="user_address" placeholder="Address" required>
            <button type="submit" name="submit">Register</button>
            <button type="button" onclick="location.href='index.php'" class="back-button">Back</button>
          </form>
        </form>
      </div>
    </div>
  </div>
</body>
</html>

