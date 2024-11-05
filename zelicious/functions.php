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