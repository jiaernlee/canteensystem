<?php
require_once '../connection.php';

$menu_date = $_POST['menu_date'];

$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($cn, $category_query);
$categories = mysqli_fetch_all($category_result, MYSQLI_ASSOC);
$error = 0;


foreach ($categories as $category) {
    $category_id = $category['id'];

    $food_id_1 = isset($_POST["category_" . $category_id . "_food_1"]) ? $_POST["category_" . $category_id . "_food_1"] : null;
    $food_id_2 = isset($_POST["category_" . $category_id . "_food_2"]) ? $_POST["category_" . $category_id . "_food_2"] : null;
    $food_id_3 = isset($_POST["category_" . $category_id . "_food_3"]) ? $_POST["category_" . $category_id . "_food_3"] : null;

    $check_query = "SELECT * from menus WHERE menu_date = CURDATE() AND category_id = $category_id";
    $check_result = mysqli_query($cn, $check_query);
    $check = mysqli_fetch_all($check_result, MYSQLI_ASSOC);

    if($check){
        $update_query_parts = [];
        if ($food_id_1 !== null) {
            $update_query_parts[] = "food_id_1 = $food_id_1";
        } else $error ++;
        if ($food_id_2 !== null) {
            $update_query_parts[] = "food_id_2 = $food_id_2";
        } else {
            $update_query_parts[] = "food_id_2 = null";
        }
        if ($food_id_3 !== null) {
            $update_query_parts[] = "food_id_3 = $food_id_3";
        }else {
            $update_query_parts[] = "food_id_3 = null";
        }
        if (!empty($update_query_parts)) {
            $query = "UPDATE menus SET " . implode(', ', $update_query_parts) . " WHERE menu_date = CURDATE() AND category_id = $category_id";
        } else {
            echo "
            <script>
            alert('You cannot post an empty menu');
            window.location.href = '/views/pages/vote.php';
            </script>
            ";

        }

    } else{
        $cols = "menu_date, isActive, category_id";
        $vals = "CURDATE(), 1, $category_id";
    
        if ($food_id_1 !== null) {
            $cols .= ", food_id_1";
            $vals .= ", $food_id_1";
        }
        if ($food_id_2 !== null) {
            $cols .= ", food_id_2";
            $vals .= ", $food_id_2";
        }
        if ($food_id_3 !== null) {
            $cols .= ", food_id_3";
            $vals .= ", $food_id_3";
        }

        $query = "INSERT INTO menus ($cols) VALUES ($vals)";
    }

    if (!mysqli_query($cn, $query)) {
        $error++;
    }
}

if ($error < 1) {
    echo "
    <script>
    alert('Menu Posted Successfully'); 
    window.location.href = '/views/pages/dashboard.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('There was an error posting the menu.');
    </script>
    ";
}

mysqli_close($cn);
