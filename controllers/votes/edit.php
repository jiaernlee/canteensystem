<?php 
session_start();
require_once '../../controllers/connection.php';

$vote_id = $_GET['v'];
$category_id = $_GET['f'];
$food_name = $_GET['n'];
$user_id = $_GET['u'];

$food_query = "SELECT id FROM foods WHERE name = '$food_name'";
$food_result = mysqli_query($cn, $food_query);
$foods = mysqli_fetch_assoc($food_result);
$food_id = $foods["id"];

$query = "UPDATE votes SET food_id = $food_id WHERE id = $vote_id AND category_id = $category_id AND user_id = $user_id AND vote_date = CURDATE();";
if(mysqli_query($cn, $query)){
    echo 
    "<script>
    alert('Vote updated successfully');
    window.location.href='/views/pages/vote.php'
    </script>
    ";
} else{
    echo 
    "<script>
    alert('Error');
    window.location.href='/views/pages/vote.php'
    </script>
    ";
}
mysqli_close( $cn );
