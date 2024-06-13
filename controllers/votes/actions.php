<?php

require_once '../connection.php';
session_start();

$id = $_GET['id'];
$category_id = $_GET['cat'] ? $_GET['cat'] : null;
$a = $_GET['a'];

if($a == 1){
    $query = "UPDATE foods SET isActive = 1 WHERE id = $id;";
} else{
    $query = "UPDATE foods SET isActive = 0 WHERE id = $id;";

    $check_query = "SELECT * FROM votes WHERE food_id = $id AND vote_date = CURDATE()";
    $check_result = mysqli_query($cn, $check_query);
    $check = mysqli_fetch_all($check_result, MYSQLI_ASSOC);

    if($check){
        $remove_query = "DELETE FROM votes WHERE food_id = $id AND vote_date = CURDATE()";
        mysqli_query($cn, $remove_query);
    }
}


mysqli_query($cn, $query);
mysqli_close($cn);

header("Location: $_SERVER[HTTP_REFERER]");
