<?php
    session_start();
    include("connection.php");
    include("functions.php");

    $res_data =check_res_login($con);

    if (isset($_POST['res_submit'])) {
        $res_name = $_POST['restaurant_name'];
        $res_image = $_FILES['restaurant_image']['name'];
        $tempname =$_FILES['restaurant_image']['tmp_name'];
        $folder ='images/'.$res_image;

        //set new restaurant name if there is
        $id=$_SESSION['res_id'];
        if(!empty($res_name))
        {
            $query = "update zeli_res set res_name='$res_name' where res_name!='$res_name' AND res_id='$id'";
            mysqli_query($con, $query);
        } 

        //deleting old image in memory
        $query = "select * from zeli_res where res_id='$id'";
        $result=mysqli_query($con, $query);

        $resu=mysqli_fetch_assoc($result);
        $path_oldimg='images/'.$resu['res_img'];
        unlink($path_oldimg);

        //inserting new image
        $query = "update zeli_res set res_img='$res_image' where res_id=$id";
        mysqli_query($con, $query); 

        if(move_uploaded_file($tempname, $folder))
        {
            echo "image updated!";
        }
        else
        {
            echo "upload error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    if (isset($_POST['add_food_btn'])) {
        $food_name = $_POST['food_name'];
        $food_price =$_POST['food_price'];
        $food_category=$_POST['food_category'];
        $food_image = $_FILES['food_image']['name'];
        $tempname =$_FILES['food_image']['tmp_name'];
        $folder ='images/'.$food_image;

        $id=$_SESSION['res_id'];
        if(!empty($food_name)&&!empty($food_price))
        {
            $query = "insert into zeli_foods(res_id,food_price,food_category,food_img,food_name,food_outofstock)values('$id','$food_price','$food_category','$food_image','$food_name',0)";
            mysqli_query($con, $query);
        } 
        
        if(move_uploaded_file($tempname, $folder))
        {
            echo "image updated!";
        }
        else
        {
            echo "upload error";
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    $id=$_SESSION['res_id'];
    $query = "select * from zeli_foods where res_id='$id'";
    $foodinres=mysqli_query($con, $query);


    
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Profile</title>
    <link rel="stylesheet" href="utils/restauranthome.css">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <img src="images/logo.png" alt="Restaurant Logo" class="logo">
        </div>
        <div class="header-right">
            <span class="restaurant-id">Restaurant ID:<?php echo $_SESSION['res_id']?></span>
            <button onclick="location.href='res-logout.php'" class="logout-btn">Logout</button>
        </div>
    </header>

    <section class="restaurant-profile">
        <h1>Restaurant Profile</h1>
        <form class="profile-form" method="post" enctype="multipart/form-data">
            <label for="restaurant-name">Restaurant Name</label>
            <input type="text"  name="restaurant_name" placeholder="Enter restaurant name">
            
            <label for="restaurant-photo">Upload Photo</label>
            <input type="file"  name="restaurant_image">
            
            <button type="submit" name="res_submit" class="save-btn">Save Profile</button>
        </form>
    </section>

    <section class="foods-section">
        <h2>Foods</h2>
        
        <div class="food-box-container">
            
            <div class="food-box online-foods">
                <div class="food-header">
                    <h3>Foods Online</h3>
                    <button type="submit" name="refreshbtn" class="refresh-btn" onclick="location.reload()">Refresh</button>
                </div>
                <ul class="food-list">
                <?php
                    while($row=mysqli_fetch_assoc($foodinres))
                    {
                        
                ?>
                  <li class="food-item">
                      <img src="images/<?php echo $row["food_img"];?>" alt="Pizza" class="food-thumbnail">
                      <span class="food-name"><?php echo $row["food_name"];?></span>
                      <span class="food-price">  Price:₹<?php echo $row["food_price"];?></span>
                      <span class="food-status">
                      <?php
                        if ($row["food_outofstock"]) {
                        ?>
                            <form method="post">
                                <button style="background-color: #dc3545; color: white;" name="outofstock" onclick="location.reload()" class="status-btn out-of-stock">Out of Stock</button>
                                <input type="hidden" name="food_id" value="<?php echo $row['food_id']; ?>">
                            </form>
                        <?php
                        } else {
                        ?>
                            <form method="post">
                                <button style="background-color: #28a745; color: white;" name="instock"  class="status-btn in-stock">In Stock</button>
                                <input type="hidden" name="food_id" value="<?php echo $row['food_id']; ?>">
                            </form>
                        <?php
                        }
                        ?>
                      </span>
                      <form method="post">
                        <button type="submit" class="delete-btn" name="delete_food">X</button>
                      </form>
                  </li>
                <?php
                    
                        if (isset($_POST['outofstock'])) {
                            $food_id = $row['food_id'];
                            $query = "update zeli_foods set food_outofstock = 0 where food_id = '$food_id'";
                            mysqli_query($con, $query);

                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                        
                        if (isset($_POST['instock'])) {
                            $food_id = $row['food_id'];
                            $query = "update zeli_foods set food_outofstock = 1 where food_id = '$food_id'";
                            mysqli_query($con, $query);

                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                        if (isset($_POST['delete_food'])) {
                            $food_id = $row['food_id'];

                            $query = "select * from zeli_foods where food_id='$food_id'";
                            $result=mysqli_query($con, $query);
                    
                            $resu=mysqli_fetch_assoc($result);
                            $path_oldimg='images/'.$resu['food_img'];
                            unlink($path_oldimg);

                            $query = "delete from zeli_foods where food_id = '$food_id'";
                            mysqli_query($con, $query);

                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();

                        }
                    }
                ?>
                  
                </ul>
            </div>

           
            <div class="food-box add-food">
                <h3>Add Food</h3>
                <form class="add-food-form"method="post" enctype="multipart/form-data">
                    <label for="food-name">Food Name</label>
                    <input type="text" id="food-name" name="food_name" placeholder="Enter food name">

                    <label for="food-photo">Upload Photo</label>
                    <input type="file" id="food-photo" name="food_image">

                    <label for="food-category">Category</label>
                    <select id="options" name="food_category">
                    <option value="">Choose a category</option>
                    <option value="Starters">Starters</option>
                    <option value="Main Course">Main Course</option>
                    <option value="Beverages">Beverages</option>
                    <option value="Desserts">Desserts</option>
                    </select>

                    <label for="food-price">Price</label>
                    <input type="number" id="food-price" name="food_price" placeholder="Enter food price">

                    <button type="submit" name="add_food_btn" class="add-food-btn">Save Change</button>
                </form>
                
            </div>
        </div>
    </section>
</body>
</html>