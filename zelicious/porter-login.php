<?php
session_start();
include("connection.php");
include("functions.php");

if (isset($_POST['submit'])) 
{
  $porter_email = $_POST['porter_email'];
  $porter_password = $_POST['porter_password'];

  // Validation
  if (!empty($porter_password) && !empty($porter_email)) 
  {
    // read from database
    
    $query = "select * from zeli_porter where porter_email='$porter_email' limit 1";
    $result=mysqli_query($con, $query);

    if($result)
    {
      if($result && mysqli_num_rows($result)>0)
      {
        $porter_data = mysqli_fetch_assoc($result);
        if($porter_data['porter_password']==$porter_password)
        {
          $_SESSION['porter_id']= $porter_data['porter_id'];
          header("Location: porter-home.php");
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
  <title>User Login</title>
  <link rel="stylesheet">
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

    .section1 {
      width: 30%;
      background-size: cover;
      background-position: center;
    }

    .section2 {
      width: 70%;
      background-size: cover;
      background-position: center;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .form-container {
      background-color: transparent;
      border: 2px solid white;
      border-radius: 10px;
      padding: 2rem;
      width: 300px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
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
    <div class="section1" style="background-image: url('images/userlogin1.jpg');"></div>
    <div class="section2" style="background-image: url('images/indeximg2.jpg');">
      <div class="form-container">
        <form id="userLoginForm" method="post">
        <input type="email" id="porterEmail" name="porter_email" placeholder="Email" required>
        <input type="password" id="porterPassword" name ="porter_password" placeholder="Password" required>
        <button type="submit" name="submit">Login</button>
       <!-- <button type="button" onclick="location.href='index.php'" class="back-button">Back</button> -->
    </form>
      </div>
    </div>
  </div>
</body>
</html>
