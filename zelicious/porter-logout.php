<?php

session_start();

if(isset($_SESSION['porter_id']))
{
    unset($_SESSION['porter_id']);
}

header("Location:porter-login.php");
die;