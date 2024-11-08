<?php
session_start();

if (isset($_GET['foodid'])) {
    $_SESSION['food_order_id'] = $_GET['foodid'];
}

// Redirect to avoid showing the query parameter in the URL after setting the session
header("Location: order.php"); 
exit;
?>