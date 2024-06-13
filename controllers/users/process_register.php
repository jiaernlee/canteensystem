<?php
require_once '../connection.php';

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];

$errors = 0;

if(strlen($username) <8){
    $errors++;
    echo "<h4>Username must be at least 8 characters</h4>";
};
if(strlen($password) < 8 || strlen($password2) < 8){
    $errors++;
    echo "<h4>Password must be at least 8 characters</h4>";
}
if($password != $password2){
    $errors++;
    echo "<h4>Password and Confirm password match</h4>";
}

if($username){
    $query = "SELECT username FROM users WHERE username = '$username'; ";
    $query2 = "SELECT email FROM users WHERE email = '$email'; ";
    $result = mysqli_fetch_assoc(mysqli_query($cn, $query));
    $result2 = mysqli_fetch_assoc(mysqli_query($cn, $query2));

    if($result && $result2){
        echo "User is already registered";
        $errors++;
        mysqli_close($cn);
    } else if ($result2){
        echo "Email is already registered";
        $errors++;
        mysqli_close($cn);
    } else if ($result){
        echo "Username is already taken";
        $errors++;
        mysqli_close($cn);
    } 
}

if($errors > 0){
    echo "</br><a href='/views/pages/register.php'>Go back</a>";
}

if($errors ===0){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, username, password) VALUES ('$email' ,'$username', '$password')";
    mysqli_query($cn, $query);
    mysqli_close($cn);

    session_start();
    $_SESSION['class'] = "success";
    $_SESSION["message"] = "Registered Successfully";

    header ('Location: /');
}