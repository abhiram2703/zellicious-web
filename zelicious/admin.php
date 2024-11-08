<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $admin_data =check_admin_login($con);
 
    if(isset($_POST['add-res']))
    {
        $res_email=$_POST['restaurantEmail'];
        $res_password=$_POST['restaurantPassword'];

        $query="insert into zeli_res(res_email,res_password)values('$res_email','$res_password')";
        mysqli_query($con, $query);
    }
    if(isset($_POST['search-res']))
    {
        $res_email=$_POST['searchRestaurantEmail'];

        $query="select res_email,res_id,res_password from zeli_res where res_email='$res_email' limit 1";
        $res=mysqli_query($con, $query);
        $res_data=mysqli_fetch_assoc($res);

        
    }

    if(isset($_POST['add-porter']))
    {
        $porter_name=$_POST['porterName'];
        $porter_email=$_POST['porterEmail'];
        $porter_password=$_POST['porterPassword'];

        $query="insert into zeli_porter(porter_name,porter_email,porter_password)values('$porter_name','$porter_email','$porter_password')";
        mysqli_query($con, $query);

        
    }
    if(isset($_POST['search-porter']))
    {
        $por_email=$_POST['searchPorterEmail'];

        $query="select porter_id,porter_password,porter_email from zeli_porter where porter_email='$por_email' limit 1";
        $por=mysqli_query($con, $query);
        $por_data=mysqli_fetch_assoc($por);

       
    }
    $query="select * from zeli_res";
    $restaurants=mysqli_query($con, $query);

    $query="select * from zeli_porter";
    $porter=mysqli_query($con, $query);

    $query="select * from zeli_foods";
    $foods=mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" >
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            flex-direction: column; /* Change to column layout for header and main */
        }

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

        .logout-btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-radius: 4px;
        }

        .container {
            flex: 1; /* Allow container to take remaining space */
            display: flex;
            flex-direction: column;
            width: 80%;
            max-width: 1200px;
            margin: 20px auto; /* Centering the container */
            padding: 20px;
        }

        .section {
            display: flex;
            flex-direction: row;
            padding: 20px;
            margin: 10px 0;
            border-radius: 10px;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            transition: transform 0.2s;
            height: 400px; /* Increased height for longer sections */
            overflow: hidden;
        }

        .section:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .left-column, .right-column {
            flex: 1; 
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        input {
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #5c8df0;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #4a7cd5;
            outline: none;
        }

        button {
            padding: 10px;
            margin-top: 10px;
            background-color: #5c8df0;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4a7cd5;
        }

        .result-card {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        .result-card h3 {
            margin: 10px 0;
            color: #333;
        }

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #5c8df0;
            color: white;
        }

        .delete-button {
            background-color: #ff5a5f;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #e74c3c;
        }

        .refresh-btn {
            margin-top: 10px;
            background-color: #5cb85c;
        }

        .refresh-btn:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="images/logo.png" alt="Restaurant Logo" class="logo">
        </div>
        <div class="header-right">
            <span class="user-id"><?php echo $admin_data['admin_name']; ?></span>
            <button onclick="location.href='admin-logout.php'"class="logout-btn">Logout</button>
        </div>
    </header>

    <div class="container">
        <!-- Section 1: Restaurant Management -->
        <div class="section">
            <div class="left-column">
                <h2>Add Restaurant</h2>
                <form id="addRestaurantForm" method="POST" >
                    <input type="text" id="restaurantEmail" name="restaurantEmail" placeholder="Restaurant Email" required>
                    <input type="password" id="restaurantPassword" name="restaurantPassword" placeholder="Password" required>
                    <button name="add-res" type="submit">Add Restaurant</button>
                </form>
            </div>
            <div class="right-column">
                <h2>Search Restaurant</h2>
                <form id="searchRestaurantForm" method="POST" >
                    <input type="text" id="searchRestaurantEmail" name="searchRestaurantEmail" placeholder="Enter Restaurant Email" required>
                    <button name="search-res" type="submit">Search</button>

                    <div class="result-card">
                    <h3>Restaurant Details:</h3>
                    <p><strong>Restaurant ID:</strong>  <?php echo isset( $res_data['res_id'])?$res_data['res_id']:""; ?></p>
                    <p><strong>Restaurant Email:</strong>  <?php echo isset($res_data['res_email'])?$res_data['res_email']:""; ?></p>
                    <p><strong>Restaurant Password:</strong>  <?php echo isset($res_data['res_password'])?$res_data['res_password']:""; ?></p>
                    </div>
                </form>
                
                
            </div>
        </div>

        <!-- Section 2: Delivery Driver Management -->
        <div class="section">
            <div class="left-column">
                <h2>Add Porter</h2>
                <form id="addDeliveryDriverForm" method="POST">
                    <input type="text" id="drivername" name="porterName" placeholder="Porter Name" required>
                    <input type="text" id="driverEmail" name="porterEmail" placeholder="Porter Email" required>
                    <input type="password" id="driverPassword" name="porterPassword" placeholder="Password" required>
                    <button name="add-porter"type="submit">Add Porter</button>
                </form>
            </div>
            <div class="right-column">
                <h2>Search Porter</h2>
                <form id="searchPortererForm" method="POST">
                    <input type="text" id="searchPorterEmail" name="searchPorterEmail" placeholder="Enter Driver Email" required>
                    <button name="search-porter" type="submit">Search</button>
                    <div class="result-card">
                    <h3>Delivery Driver Details:</h3>
                    <p><strong>Porter ID:</strong>  <?php echo isset( $por_data['porter_id'])?$por_data['porter_id']:""; ?></p>
                    <p><strong>Porter Email:</strong>  <?php echo isset( $por_data['porter_email'])?$por_data['porter_email']:""; ?></p>

                    <p><strong>Porter Password:</strong>  <?php  echo isset( $por_data['porter_password'])?$por_data['porter_password']:""; ?></p>
                </div>
                </form>
            </div>
        </div>

    
        <div class="section">
            <div class="left-column">
                <h2>Restaurants</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Restaurant ID</th>
                                <th>Restaurant Name</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while($row=mysqli_fetch_assoc($restaurants)){
                            ?>
                            <tr>
                                <td><?php echo $row['res_id']; ?></td>
                                <td><?php echo $row['res_name']; ?></td>
                                <td><form method="post">
                                    <button type="submit" class="delete-btn" name="delete_res">X</button>
                                    <input type="hidden" name="res_id_del" value="<?php echo $row['res_id']; ?>">                        
                                    </form></td>
                            </tr>

                        <?php
                                 if (isset($_POST['delete_res'])) {
                                    $res_id = $_POST['res_id_del'];
                                
                                    $query = "select * from zeli_res where res_id='$res_id'";
                                    $result = mysqli_query($con, $query);
                                
                                    $resu = mysqli_fetch_assoc($result);
                                    if (isset($resu['res_img'])&& !empty($resu['res_img'])) {  
                                        $path_oldimg = 'images/' . $resu['res_img'];
                                        if (is_file($path_oldimg)) {
                                            unlink($path_oldimg);
                                        }
                                    }
                                
                                    $query = "delete from zeli_res where res_id = '$res_id'";
                                    mysqli_query($con, $query);

                                }


                                }
                        ?>
                         
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="refreshbtn" class="refresh-btn" onclick="location.reload()">Refresh</button>
            </div>
        </div>

        <!-- Section 4: View Delivery Drivers -->
        <div class="section">
            <div class="left-column">
                <h2>Porters</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Porter ID</th>
                                <th>Porter Email</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                while($row=mysqli_fetch_assoc($porter)){
                            ?>
                            <tr>
                                <td><?php echo $row['porter_id']; ?></td>
                                <td><?php echo $row['porter_name']; ?></td>
                                <td><form method="post">
                                    <button type="submit" class="delete-btn" name="delete_por">X</button>
                                    <input type="hidden" name="por_id_del" value="<?php echo $row['porter_id']; ?>">                        
                                    </form></td>
                            </tr>

                        <?php
                                 if (isset($_POST['delete_por'])) {
                                    $por_id = $_POST['por_id_del'];
                                
                                    $query = "delete from zeli_porter where porter_id = '$por_id'";
                                    mysqli_query($con, $query);
                                }


                                }
                        ?>
                         
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="refreshbtn" class="refresh-btn" onclick="location.reload()">Refresh</button>
            </div>
        </div>

        <!-- Section 5: View Food Items -->
        <div class="section">
            <div class="left-column">
                <h2>Food Items</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Food ID</th>
                                <th>Food Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                while($row=mysqli_fetch_assoc($foods)){
                            ?>
                            <tr>
                                <td><?php echo $row['food_id']; ?></td>
                                <td><?php echo $row['food_name']; ?></td>
                                <td><form method="post">
                                    <button type="submit" class="delete-btn" name="delete_food">X</button>
                                    <input type="hidden" name="food_id_del" value="<?php echo $row['food_id']; ?>">                        
                                    </form></td>
                            </tr>

                        <?php
                                 if (isset($_POST['delete_food'])) {
                                    $food_id = $_POST['food_id_del'];
                                
                                    $query = "select * from zeli_foods where food_id='$food_id'";
                                    $result = mysqli_query($con, $query);
                                
                                    $resu = mysqli_fetch_assoc($result);
                                    if (isset($resu['food_img'])&& !empty($resu['food_img'])) {  
                                        $path_oldimg = 'images/' . $resu['food_img'];
                                        if (is_file($path_oldimg)) {
                                            unlink($path_oldimg);
                                        }
                                    }
                                    $query = "delete from zeli_foods where food_id = '$food_id'";
                                    mysqli_query($con, $query);
                                

                                }


                                }
                        ?>
                         
                        </tbody>
                    </table>
                </div>
                <button type="submit" name="refreshbtn" class="refresh-btn" onclick="location.reload()">Refresh</button>
            </div>
        </div>
    </div>
</body>
</html>
