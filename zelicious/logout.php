<?php

session_start();

if(isset($_SESSION['user_id']))
{
    unset($_SESSION['user_id']);
    unset($_SESSION['res_id']);
    unset($_SESSION['category']);
    unset($_SESSION['foodres']);
    unset($_SESSION['res_name']);
}

header("Location:login.php");
die;