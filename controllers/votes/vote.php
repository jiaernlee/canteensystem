<?php
require_once '../connection.php';
session_start();

$category_id = $_GET['f'];
$food_name = $_GET['n'];
$user_id = $_GET['u'];

$food_query = "SELECT id FROM foods WHERE name = '$food_name'";
$food_result = mysqli_query($cn, $food_query);
$foods = mysqli_fetch_assoc($food_result);
$food_id = $foods["id"];

$check_query = "SELECT * from votes WHERE user_id = $user_id AND category_id = $category_id AND vote_date = CURDATE()";
$check_result = mysqli_query($cn, $check_query);
$check = mysqli_fetch_all($check_result, MYSQLI_ASSOC);

if($check){
    echo 
    "<script>
        alert('You already voted once');
        window.location.href = '/views/pages/vote.php'; 
    </script>";
} else{
    $query = "INSERT INTO votes (user_id, category_id, food_id) VALUES ($user_id, $category_id, $food_id)";
    if(mysqli_query($cn, $query)){
        $_SESSION['user_info']['voted'] = true;
        echo 
        "<script>
            alert('Vote successfully recorded');
            window.location.href = '/views/pages/vote.php'; 
        </script>";
    } else{
        echo 
        "<script>
            alert('Error');
            window.location.href = '/views/pages/vote.php'; 
        </script>";
    };
    mysqli_close($cn);
}



