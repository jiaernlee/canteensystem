<?php

require_once '../connection.php';

$food_id = $_GET['id'];

$img_query = "SELECT image FROM foods WHERE id = $food_id";
$img_result = mysqli_query($cn, $img_query);
$img_path = mysqli_fetch_assoc( $img_result );

$query = "DELETE FROM foods WHERE id = $food_id";

$file_path = "../..".$img_path['image'];
if(file_exists($file_path)){
    unlink($file_path);
} else{
    echo "File does not exist";
    die();
};

if(mysqli_query($cn, $query)){
    echo 
    "<script>
        alert('Food successfully deleted');
        window.location.href = '/views/pages/add_food.php'; 
    </script>";
} else{
    echo 
    "<script>
        alert('Error');
        window.location.href = '/views/pages/add_food.php'; 
    </script>";
};

mysqli_close( $cn );

