<?php

function check_login($con)
{

    if(isset($_SESSION['user_id']))
    {
        $id=$_SESSION['user_id'];
        $query = "select * from zeli_users where user_id='$id' limit 1";

        $result= mysqli_query($con,$query);
        if($result && mysqli_num_rows($result)>0)
        {
            $user_data =mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    //reddirect to login
    header("Location: login.php");
    die;

}

function check_porter_login($con)
{

    if(isset($_SESSION['porter_id']))
    {
        $id=$_SESSION['porter_id'];
        $query = "select * from zeli_porter where porter_id='$id' limit 1";

        $result= mysqli_query($con,$query);
        if($result && mysqli_num_rows($result)>0)
        {
            $porter_data =mysqli_fetch_assoc($result);
            return $porter_data;
        }
    }

    //reddirect to login
    header("Location: login.php");
    die;

}


function check_res_login($con)
{

    if(isset($_SESSION['res_id']))
    {
        $id=$_SESSION['res_id'];
        $query = "select * from zeli_res where res_id='$id' limit 1";

        $result= mysqli_query($con,$query);
        if($result && mysqli_num_rows($result)>0)
        {
            $res_data =mysqli_fetch_assoc($result);
            return $res_data;
        }
    }

    //reddirect to login
    header("Location: login.php");
    die;

}   

function check_admin_login($con)
{

    if(isset($_SESSION['admin_id']))
    {
        $id=$_SESSION['admin_id'];
        $query = "select * from zeli_admin where admin_id='$id' limit 1";

        $result= mysqli_query($con,$query);
        if($result && mysqli_num_rows($result)>0)
        {
            $admin_data =mysqli_fetch_assoc($result);
            return $admin_data;
        }
    }

    //reddirect to login
    header("Location: login.php");
    die;

}  

function random_num($len)
{
    $text ="";
    $l = rand(4,$len);

    for($i=0;$i<$len;$i++)
    {
        $text .= rand(0,9);
    }
    return $text;
}

function displayFoodItems($title, $availableFoods, $unavailableFoods) {
    ?>
    <div class="nameontop">
    <h1><?php echo htmlspecialchars($title); ?></h1>
    </div>
    <div class="bento-box">
       

        <?php while ($row = mysqli_fetch_assoc($availableFoods)) { ?>
            <div class="food-item available">
                <img src="images/<?php echo $row["food_img"]; ?>" class="food-image">
                <div class="food-details">
                    <h2><?php echo htmlspecialchars($row["food_name"]); ?></h2>
                    <p>Price: $<?php echo htmlspecialchars($row["food_price"]); ?></p>
                    <button class="order-button" onclick="redirectToOrder(<?php echo htmlspecialchars($row['food_id']); ?>)">Order Now</button>
                </div>
            </div>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($unavailableFoods)) { ?>
            <div class="food-item unavailable">
                <img src="images/<?php echo $row["food_img"]; ?>" alt="Food image" class="food-image">
                <div class="food-details">
                    <h2><?php echo htmlspecialchars($row["food_name"]); ?></h2>
                    <p>Price: $<?php echo htmlspecialchars($row["food_price"]); ?></p>
                    <button class="outofstock-button">Out Of Stock</button>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
}

