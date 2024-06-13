<?php 
require_once '../connection.php';

$email = $_POST["email"];
$password = $_POST["password"];

$query = "SELECT * FROM users WHERE email = '$email';";
$user = mysqli_fetch_assoc(mysqli_query($cn, $query));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format";
    mysqli_close($cn);
    echo "<br><a href='/views/pages/login.php'>Back</a>";
}

if($user && password_verify($password, $user["password"])){
    session_start();
    $_SESSION['user_info'] = $user;
    $_SESSION['class'] = 'success';
    $_SESSION['message'] = 'Login Successfully';
    mysqli_close($cn);
    if($_SESSION['user_info']['isAdmin']){
        header('Location: /views/pages/dashboard.php');
    } else{
    header('Location: /views/pages/home.php');
    }
} else {
    echo "<h4>Wrong credentials</h4>";
    echo "<br><a href='/views/pages/login.php'>Back</a>";
}