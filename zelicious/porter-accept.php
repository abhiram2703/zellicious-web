<?php
        session_start();
        include("connection.php");
        include("functions.php");
    
        $porter_data =check_porter_login($con);
        $porter_id=$porter_data['porter_id'];

        $query="select * from zeli_orders where porter_id='$porter_id' and order_status='Out For Delivery' limit 1";
        $ord_data=mysqli_query($con, $query);
        if($ord_data&&mysqli_num_rows($ord_data)){
            $order_data=mysqli_fetch_assoc($ord_data);
            $order_id=$order_data['order_id'];
        }
        else{
            header("Location: porter-home.php");
            exit();
        }
        

        if (isset($_POST['submit'])) {
            $order_image = $_FILES['proof_image']['name'];
            $tempname =$_FILES['proof_image']['tmp_name'];
            $folder ='images/'.$order_image;
    
            if(!empty($folder))
            {
                $query = "update zeli_orders set order_img='$order_image', order_status='Order Delivered' where order_id='$order_id'";
                mysqli_query($con, $query);
            } 
            
            if(move_uploaded_file($tempname, $folder))
            {
                echo "image updated!";
                header("Location: porter-home.php");
                exit();
            }
            else
            {
                echo "upload error";
            }
    
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
       body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
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

        .logout-btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #e04a4e;
        }

        .order-section {
            margin-top: 20px;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin: 10px 0;
            transition: transform 0.2s ease;
        }

        .order-card:hover {
            transform: scale(1.02);
        }

        .order-id {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .order-details {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-button {
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .accept-btn {
            background-color: #28a745;
            color: #fff;
        }

        .reject-btn {
            background-color: #dc3545;
            color: #fff;

        }
        .content {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .order-info {
            margin-bottom: 20px;
        }

        .order-info div {
            font-size: 16px;
            margin: 5px 0;
        }

        .upload-section {
            margin-top: 20px;
            text-align: center;
        }

        .upload-btn {
            padding: 0.5rem 1rem;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
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
        <button onclick="location.href='mydeliveries.php'"class="my-orders-btn">My Deliveries</button>
        <div class="user-id">Hi, <?php echo $porter_data['porter_name']; ?></div>
        <button onclick="location.href='porter-logout.php'" class="logout-btn">Logout</button>
    </div>
</header>
<div class="header">Delivery Confirmation</div>

<div class="content">
    <div class="order-info">
            <?php
                $food_id=$order_data['food_id'];
                $query="select * from zeli_foods where food_id='$food_id' limit 1";
                $food_d=mysqli_query($con, $query);
                $food_data=mysqli_fetch_assoc($food_d);
    
                $res_id=$food_data['res_id'];
                $query="select * from zeli_res where res_id='$res_id' limit 1";
                $res_d=mysqli_query($con, $query);
                $res_data=mysqli_fetch_assoc($res_d);

                $user_id=$order_data['user_id'];
                $query="select * from zeli_users where user_id='$user_id' limit 1";
                $user_d=mysqli_query($con, $query);
                $user_data=mysqli_fetch_assoc($user_d);

        ?>
        <div><strong>Order ID:<?php echo $order_data['order_id'];?></strong> <span id="orderId"></span></div>
        <div><strong>Restaurant:<?php echo $res_data['res_name'];?></strong> <span id="restaurant"></span></div>
        <div><strong>Address:<?php echo $order_data['order_address'];?></strong> <span id="address"></span></div>
        <div><strong>Food Item:<?php echo $food_data['food_name'];?></strong> <span id="foodName"></span></div>
        <div><strong>Price:<?php echo $order_data['order_price'];?></strong> <span id="price"></span></div>
       <!-- <div><strong>Customer:<?php echo $user_data['user_name'];?></strong> <span id="username"></span></div>-->
    </div>

    <div class="upload-section">
    <form method="post" enctype="multipart/form-data">
        <label for="uploadProof">Upload Proof of Delivery:</label><br><br>
        <input type="file" id="uploadProof" name="proof_upload" accept="image/*"><br><br>
        <button name="submit" class="upload-btn">Upload</button>
    </div>
</div>

<script>
   
</script>

</body>
</html>
