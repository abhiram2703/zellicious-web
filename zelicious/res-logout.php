<?php

session_start();

if(isset($_SESSION['res_id']))
{
    unset($_SESSION['res_id']);
}

header("Location:restaurant-login.php");
die;