<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $porter_data =check_porter_login($con);
    $porter_id=$porter_data['porter_id'];

    $query="select * from zeli_orders where porter_id='$porter_id' and order_status='Out For Delivery'";
    $result=mysqli_query($con, $query);
    if($result&&mysqli_num_rows($result)>0){
        header("Location: porter-accept.php");
        die;
    }

    $query="select * from zeli_orders where order_status='Order Placed'";
    $placedorders=mysqli_query($con, $query);

    
    if(isset($_POST['acceptbtn'])){
        $order_id=$_POST['order_id_btn'];

        $query = "update zeli_orders set order_status = 'Out for Delivery',porter_id='$porter_id' where order_id = '$order_id'";
        mysqli_query($con, $query);
        
        header("Location: porter-accept.php");
        die;
    }

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
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
    </style>
</head>
<body>

<header class="header">
    <div class="header-left">
        <img src="images/logo.png" alt="Restaurant Logo" class="logo">
        <div class="nav-links">
            <a href="porter-home.php" class="nav-link">Home</a>
        </div>
    </div>
    <div class="header-right">
        <button onclick="location.href='mydeliveries.php'"class="my-orders-btn">My Deliveries</button>
        <div class="user-id">Hi, <?php echo $porter_data['porter_name']; ?></div>
        <button onclick="location.href='porter-logout.php'" class="logout-btn">Logout</button>
    </div>
</header>

<div class="order-section">
    <h2>Current Orders</h2>

    <?php
        while($row = mysqli_fetch_assoc($placedorders)){
            $food_id=$row['food_id'];
            $query="select * from zeli_foods where food_id='$food_id' limit 1";
            $food_d=mysqli_query($con, $query);
            $food_data=mysqli_fetch_assoc($food_d);

            $res_id=$food_data['res_id'];
            $query="select * from zeli_res where res_id='$res_id' limit 1";
            $res_d=mysqli_query($con, $query);
            $res_data=mysqli_fetch_assoc($res_d);
    
            ?>
            <form method="POST">
            <div class="order-card">
                <div class="order-id">Order ID: <?php echo $row['order_id'];?></div>
                <div class="order-details">Restaurant: <?php echo $res_data['res_id'];?><br>Address: <?php echo $row['order_address'];?></div>
                <div class="action-buttons">
                    <button class="action-button accept-btn" name="acceptbtn">Accept</button>
                    <input type="hidden" name="order_id_btn" value="<?php echo $row['order_id']; ?>">
                    <button class="action-button reject-btn" onclick="alert('Order rejected.')">Reject</button>
                </div>
            </div>
        </form>
    
          <?php
            }
            ?>

</div>

</body>
</html>
