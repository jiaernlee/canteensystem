<?php 
require_once '../connection.php';
session_start();

$food_name = $_POST['food_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];

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
    echo "Please upload an image";
}

if($is_img && $img_size > 0){
    $query = "INSERT INTO foods(name,price,description,image,category_id) VALUES ('$food_name', $price, '$description','$img_path', '$category_id');";

    move_uploaded_file($img_tmpname, "../..".$img_path);
    mysqli_query($cn, $query);
    mysqli_close($cn);
    echo 
    '<script>
    alert("Food added successfully");
    window.location.href="/views/pages/add_food.php";
    </script>'; 
}