<?php

require_once '../connection.php';

$order_id = $_GET['id'];

$query = "DELETE FROM orders WHERE id = $order_id";
$query2 = "DELETE FROM product_orders WHERE order_id = $order_id";

if(mysqli_query($cn, $query) && mysqli_query($cn, $query2)){
    echo 
    "<script>
        alert('Order successfully deleted');
        window.location.href = '/views/pages/my_orders.php'; 
    </script>";
}

mysqli_close($cn);