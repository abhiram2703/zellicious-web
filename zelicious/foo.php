<?php
session_start();

if (isset($_GET['category'])) {
    $_SESSION['category'] = $_GET['category'];
}

// Redirect to avoid showing the query parameter in the URL after setting the session
header("Location: food.php"); 
exit;
?>