<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bento Style Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
        }

        .image1 {
            background-image: url('images/indeximg1.jpg');
            background-size: cover;
            background-position: center;
            width: 30%;
            height: 100vh;
            float: left;
        }

        .image2-container {
            width: 70%;
            height: 100vh;
            position: relative;
            float: right;
        }

        .image2 {
            background-image: url('images/indeximg2.jpg');
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100%;
        }

        .button-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: transparent;
            border: 2px solid white;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            z-index: 1;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .option-buttons {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .separator {
            height: 2px;
            background-color: white;
            margin: 1rem 0;
        }

        .option-buttons button {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .option-buttons button.active {
            background-color: white;
            color: black;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            display: none;
        }

        .buttons a {
            text-decoration: none;
            padding: 0.75rem;
            border-radius: 8px;
            text-align: center;
            background-color: transparent;
            color: white;
            border: 2px solid white;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .buttons a:hover {
            background-color: white;
            color: black;
            font-size: 1.1rem;
        }

        .customer-buttons {
            display: flex;
        }

        .restaurant-buttons {
            display: none;
        }
    </style>
</head>
<body>
    <div class="image1"></div>
    <div class="image2-container">
        <div class="image2"></div>
        <div class="button-box">
            <div class="option-buttons">
                <button id="customerBtn">For Customer</button>
                <button id="restaurantBtn">For Restaurant</button>
            </div>
            <div class="separator"></div>
            <div class="buttons customer-buttons">
                <a href="login.php">User Login</a>
                <a href="signup.php">User SignUp</a>
            </div>
            <div class="buttons restaurant-buttons" style="display: none;">
                <a href="restaurant-login.php">Restaurant Login</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('customerBtn').addEventListener('click', function() {
            document.querySelector('.customer-buttons').style.display = 'flex';
            document.querySelector('.restaurant-buttons').style.display = 'none';
            this.classList.add('active');
            document.getElementById('restaurantBtn').classList.remove('active');
        });

        document.getElementById('restaurantBtn').addEventListener('click', function() {
            document.querySelector('.customer-buttons').style.display = 'none';
            document.querySelector('.restaurant-buttons').style.display = 'flex';
            this.classList.add('active');
            document.getElementById('customerBtn').classList.remove('active');
        });
    </script>
</body>
</html>

