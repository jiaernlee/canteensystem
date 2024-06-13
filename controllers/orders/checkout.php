<?php
require_once '../connection.php';
session_start();

$total = $_POST['total'];
$user_id = $_SESSION['user_info']['id'];

$order_query = "INSERT INTO orders (user_id, total) VALUES ($user_id, $total);";

if(mysqli_query($cn, $order_query)) {
    $last_id = mysqli_insert_id($cn);

    foreach($_SESSION['cart'] as $id => $quantity) {
        $product_orders_query = "INSERT INTO product_orders (food_id, order_id, quantity) VALUES ($id, $last_id, $quantity);";

        mysqli_query($cn, $product_orders_query);
    }

    unset($_SESSION['cart']);
    header("Location: /views/pages/home.php");
    
} else {
    echo "Error: " . mysqli_error($cn);
    die();
}

