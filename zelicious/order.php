<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($con);

$food_id = $_SESSION['food_order_id'];
$query = "SELECT * FROM zeli_foods WHERE food_id='$food_id' LIMIT 1";
$res = mysqli_query($con, $query);
$food_data = mysqli_fetch_assoc($res);
$res_id = $food_data['res_id'];
$query = "SELECT * FROM zeli_res WHERE res_id='$res_id' LIMIT 1";
$result = mysqli_query($con, $query);
$res_data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $address = $_POST['address'];
    $food_price = $food_data['food_price'];
    $price = $quantity * $food_price;
    $user_id = $user_data['user_id'];
    $query = "insert into zeli_orders(food_id, user_id, food_quantity, order_price, order_address,order_status) values ('$food_id', '$user_id', '$quantity', '$price', '$address','Order Placed')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('modalMessage').innerText = 'Order placed successfully!';
                    document.getElementById('orderSuccessModal').style.display = 'block';
                setTimeout(function() {
                        window.location.href = 'home.php';  
                    }, 1000);
                    });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('modalMessage').innerText = 'Error placing order: " . mysqli_error($con) . "';
                    document.getElementById('orderSuccessModal').style.display = 'block';
                setTimeout(function() {
                        window.location.href = 'home.php';  
                    }, 1000);
                    });
                    });

              </script>";
    }

   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bento Style Order Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }

        .food-image-container {
            margin-bottom: 15px;
        }

        .food-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .food-name {
            font-weight: bold;
            font-size: 25px;
        }

        button:hover {
            background-color: #218838;
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

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px; 
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
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
    <button onclick="location.href='myorders.php'" class="my-orders-btn">My Orders</button>
        <div class="user-id">Hi, <?php echo $user_data['user_name']; ?></div>
        <button onclick="location.href='logout.php'" class="logout-btn">Logout</button>
    </div>
</header>

<div class="popup-content">
    <h2>Order</h2>

    <div class="food-image-container">
        <img src="images/<?php echo $food_data['food_img'];?>" alt="Food Image" class="food-image" id="popup-food-image">
    </div>

    <div class="food-name">
        <label for="food-name"><?php echo $food_data['food_name'];?></label>
    </div>

    <div>
        <label for="food-price">Price: $<?php echo $food_data['food_price'];?> </label>
    </div>
    <div>
        <label for="restaurant-name">Restaurant: <?php echo $res_data['res_name'];?> </label>
    </div>

    <form id="ordersubmitForm" method="POST">
        <div>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" required>
        </div>

        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required>
        </div>

        <button type="submit" name="submit">Submit Order</button>
    </form>
</div>

<!-- Modal for success/error messages -->
<div id="orderSuccessModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('orderSuccessModal').style.display='none'">&times;</span>
        <p id="modalMessage"></p>
    </div>
</div>

<script>
    // Close the modal when the user clicks on <span> (x)
    window.onclick = function(event) {
        var modal = document.getElementById('orderSuccessModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>
</body>
</html>
