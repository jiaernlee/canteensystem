<?php

session_start();

$id = $_GET['id'];

unset($_SESSION['cart'][$id]);

if(count($_SESSION["cart"])<1){
    unset($_SESSION["cart"]);
}

header("Location: /views/pages/home.php");