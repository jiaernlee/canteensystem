<?php 
session_start();

$id = $_POST['id'];
$quantity = intval($_POST['quantity']) ;

if($quantity < 1) {
    echo "Please input at least 1";
} else {
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'][$id] = $quantity;
    } else {
        $_SESSION['cart'][$id] += $quantity;
    }
    header("Location: $_SERVER[HTTP_REFERER]");
}