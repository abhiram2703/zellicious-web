<?php
session_start();
include("connection.php");
if (isset($_GET['resid'])) {
    $_SESSION['res_food_id'] = $_GET['resid'];
    $_SESSION['foodres']=1;
    $res_id=$_SESSION['res_food_id'];
    $query="select res_name from zeli_res where res_id='$res_id' limit 1";
    $result=mysqli_query($con, $query);
    $res=mysqli_fetch_assoc($result);

    $_SESSION['res_name'] = $res['res_name'];
}

// Redirect to avoid showing the query parameter in the URL after setting the session
header("Location: food.php"); 
exit;
?>