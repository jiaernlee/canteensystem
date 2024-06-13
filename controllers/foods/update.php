<?php

require_once '../connection.php';

$food_id = $_POST['food_id'];
$food_name = $_POST['food_name'];
$food_price = $_POST['price'];
$food_description = $_POST['description'];
$food_category = $_POST['category_id'];

$img_name = $_FILES['image']['name'];
$img_size = $_FILES['image']['size'];
$img_tmpname = $_FILES['image']['tmp_name'];
$img_type = strtolower(pathinfo($img_name, PATHINFO_EXTENSION)); 
$img_path = "/public/".time()."-".$img_name;

$extensions = ['jpg', 'jpeg','png', 'svg', 'gif'];
$is_img = false;

if (in_array($img_type, $extensions)) {
    $is_img = true;
} else{
    $query1 = "SELECT image FROM foods WHERE id=$food_id";
    $result = mysqli_query($cn, $query1);
    $foods = mysqli_fetch_assoc($result);
    $img_path = $foods['image'];
    $old_img = true;
}

if(($is_img && $img_size > 0) || $old_img){
    $query = "UPDATE foods SET name='$food_name', price=$food_price, description='$food_description',image='$img_path', category_id='$food_category' WHERE id=$food_id;";

    move_uploaded_file($img_tmpname, "../..".$img_path);
    if(mysqli_query($cn, $query)){
        echo 
        "<script>
            alert('Updated successfully');
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
} 
