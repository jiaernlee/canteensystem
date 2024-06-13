<?php
require_once '../connection.php';
session_start();

$user_id = $_POST['user_id'];
$product_satisfaction = $_POST['product_satisfaction'];
$service_satisfaction = $_POST['service_satisfaction'];
$team_satisfaction = $_POST['team_satisfaction'];
$improvement_suggestions = $_POST['improvement_suggestions'];

$query = "INSERT INTO feedbacks (user_id, product_satisfaction, service_satisfaction, team_satisfaction, improvement_suggestions) VALUES ($user_id, $product_satisfaction,$service_satisfaction, $team_satisfaction, '$improvement_suggestions');";
if(mysqli_query($cn, $query)){
    echo "
    <script>
    alert('Feedback submitted successfully');
    window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
    </script>
    ";
}