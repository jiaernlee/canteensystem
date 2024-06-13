<?php

require_once '../connection.php';
session_start();

$cat_id = $_GET['cat'];

$query = "UPDATE foods SET isActive = 0 WHERE category_id = $cat_id";

mysqli_query($cn, $query);
mysqli_close($cn);

header("Location: $_SERVER[HTTP_REFERER]");